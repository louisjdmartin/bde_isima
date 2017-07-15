<?php
/*
  statistiques.php
  
  ENTREE
      mode: type de statistiques: liste-negatif, etat, ventes, cotisations
      si mode = ventes
          deb: date de debut (timestamp)
	  si mode = liste-negatif et promo un entier, renvoie la liste par promo
	  fin: date de fin (timestamp)
  SORTIE
      liste contenant 
      si liste-negatif: liste[carte, nom, prenom, solde]
      si etat: total-positif, total-negatif, total
      si ventes: liste[article, vente, gain], total
	  si cotisations: liste[annee, nombre]
  AUTORISATION:
      bde
*/
$autorise = array("zz", "bde");
function statistiques($settings, $objets){
	if(!isset($objets['user_info']['autorisations']['bde']))return array("error" => 1, "error_msg" => "Accès refusé");
	else
	{
		$bdd=$objets['bdd'];
		if($settings['mode']=='liste-negatif')
		{
			$liste_negatif = $bdd->query("SELECT numero, nom, prenom, surnom, solde FROM membres WHERE solde<0 ORDER BY solde");
			if(isset($settings['promo']) and is_numeric($settings['promo']))$liste_negatif = $bdd->query("SELECT numero, nom, prenom, surnom, solde FROM membres WHERE solde<0 AND promo=".$settings['promo']." ORDER BY solde");
			$retour = array("error"=>0);
			$retour["nb_elt"]=0;
			$retour['liste']=array();
			foreach($liste_negatif as $neg)
			{
			  $retour['liste'][] = array(
						 "carte" => $neg['numero'],
						 "nom" => utf8_encode($neg['nom']),
						 "prenom" => utf8_encode($neg['prenom']),
						 "surnom" => utf8_encode($neg['surnom']),
						 "solde" => $neg['solde']
						 );
			  $retour['nb_elt']++;
			}
		}
		else if($settings['mode']=='etat')
		{
		  $total_positif = $bdd->query("SELECT SUM(solde) AS 'total-positif' FROM membres WHERE solde>0");
		  foreach($total_positif as $solde)$t_pos = round($solde[0],2);
		  
		  $total_negatif = $bdd->query("SELECT SUM(solde) AS 'total-negatif' FROM membres WHERE solde<0");
		  foreach($total_negatif as $solde)$t_neg = round($solde[0],2);

		  $tot = $t_pos+$t_neg;
		  $retour = array('total-positif'=>$t_pos,'total-negatif'=>$t_neg,'total'=>$tot);
		}
		else if($settings['mode']=='ventes')
		{
			$sstotal = 0; //SCRIPT ANCIEN SITE (bien un des seul truc qui fonctionne)
			$req = $bdd->query('SELECT * FROM articles');
			$retour = array("error"=>0);
			$retour["nb_elt"]=0;
			while ($donnees = $req->fetch())
			{
					$id_article = $donnees['id'];
					$deb = date('Y-m-d H:i:s', $settings['deb']);
					$fin = date('Y-m-d H:i:s', $settings['fin']);

					$nbre = $bdd->query("SELECT COUNT(*) FROM transactions WHERE id_article='$id_article' AND timestamp > '$deb' AND timestamp < '$fin'")->fetchColumn();
					$sstotal += $nbre * $donnees['tarif'];
					$retour['liste'][] = array(
						'nom' => utf8_encode($donnees['nom']), 
						'nombre' => $nbre,
						'gain' => $nbre * $donnees['tarif']
					);
			} 
		}
		else if($settings['mode']=='cotisations')
		{
			$cotisation = annee_scolaire();
			$cotisations = $bdd->query('SELECT DISTINCT(promo), count(*) as nb FROM membres WHERE cotisation='. $cotisation .' GROUP BY promo');
			$retour['liste']=array();
			$retour['nb_elt']=0;
			foreach($cotisations as $neg)
			{
				$retour['liste'][] = array(
							 "annee" => $neg['promo'],
							 "nombre" => utf8_encode($neg['nb'])
							 );
				$retour['nb_elt']++;
			}
		}
    }

     return $retour;
}


