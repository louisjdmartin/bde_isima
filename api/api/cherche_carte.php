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


function cherche_carte($settings, $objets){
	$bdd = $objets['bdd'];	
	if(!isset($objets['user_info']['autorisations']['club']))return (array("error" => 1, "msg" => "Action refusée"));
	$conditions = "nom LIKE '%%'";
	
	$mots = explode(" ",$settings['q']);
	foreach($mots as $mot)
	{
		$conditions .= "AND (nom LIKE '%".addslashes($mot)."%' OR prenom LIKE '%".addslashes($mot)."%' OR surnom LIKE '%".addslashes($mot)."%' OR numero LIKE '%".addslashes($mot)."%') ";
	}
	
	if(is_numeric($settings['q']))$conditions = "numero = ".$settings['q'];	

	$resultats = $bdd->query("SELECT nom, prenom, surnom, numero, solde FROM membres WHERE ".$conditions);
	$retour = array();
	$retour["nb_elt"]=0;
	foreach ($resultats as $r)
	{
		$retour['liste'][] = array(
			"nom" => utf8_encode($r['nom']),
			"prenom" => utf8_encode($r['prenom']),
			"surnom" => utf8_encode($r['surnom']),
			"carte" => $r['numero'],
			"solde" => $r['solde']
		);
		$retour["nb_elt"]++;
	}
	return $retour;
}
?>
