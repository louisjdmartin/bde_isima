<?php
/*
	cherche_carte.php
	Recherhe la carte d'une personne
	
	ENTREE:
		q: terme recherché
		
	SORTIES:
		liste contenant nom/prenom/surnom/carte/solde
		
	AUTORISATION:
		bde
*/


function cherche_carteisibouffe($settings, $objets){
	$bdd = $objets['bdd'];	
	if(!isset($objets['user_info']['autorisations']['ZZ']))return (array("error" => 1, "msg" => "Action refusée"));
	$conditions = "nom LIKE '%%'";
	
	$mots = explode(" ",$settings['q']);
	foreach($mots as $mot)
	{
		$conditions .= "AND (nom LIKE '%".addslashes($mot)."%' OR prenom LIKE '%".addslashes($mot)."%' OR surnom LIKE '%".addslashes($mot)."%') ";
	}
	
	if(is_numeric($settings['q']) and isset($settings['force_number']))$conditions = "id = ".$settings['q'];	

	$resultats = $bdd->query("SELECT id,nom, prenom, surnom, solde FROM isibouffe_zz WHERE ".$conditions);
	$retour = array();
	$retour["nb_elt"]=0;
	foreach ($resultats as $r)
	{
		$retour['liste'][] = array(
			"id_isibouffe" => $r['id'],
			"nom" => utf8_encode($r['nom']),
			"prenom" => utf8_encode($r['prenom']),
			"surnom" => utf8_encode($r['surnom']),
			"solde" => $r['solde']
		);
		$retour["nb_elt"]++;
	}
	return $retour;
}
?>
