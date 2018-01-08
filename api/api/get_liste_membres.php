<?php
/*
	get_liste_membres.php

	ENTREE
		numero: carte de l'utilisateur dont on veut connaitre le nom
					
	SORTIE:
		le nom de l'utilisateur
	AUTORISATION:
		all
*/



$autorise = array("zz", "bde");
function get_liste_membres($settings, $objets){
	$bdd = $objets['bdd'];
	if(!isset($objets['user_info']['autorisations']['bde']))return (array("error" => 1, "msg" => 'Action refusée'));
	
	
	$membres = $bdd->query("SELECT * FROM membres ");
	if(isset($settings['orderby']))
	{
		$membres = $bdd->query("SELECT * FROM membres ORDER BY ".addslashes($settings['orderby']));
	}
	elseif(isset($settings['id']) && is_numeric($settings['id']))
	{
		$membres = $bdd->query("SELECT * FROM membres WHERE id=".addslashes($settings['id']));
	}
	else $membres = $bdd->query("SELECT * FROM membres ");
	$retour = array();
	$retour["nb_elt"]=0;
	foreach ($membres as $r)
	{
		$retour['liste'][] = array(
			"id" => $r['id'],
			"nom" => utf8_encode($r['nom']),
			"prenom" => utf8_encode($r['prenom']),
			"numero" => utf8_encode($r['numero']),
			"mail" => utf8_encode($r['mail']),
			"promo" => utf8_encode($r['promo']),
			"grade" => utf8_encode($r['grade']),
			"cotisation" => utf8_encode($r['cotisation']),
			"solde" => utf8_encode($r['solde']),
			"surnom" => utf8_encode($r['surnom'])
		);
		$retour["nb_elt"]++;
	}
	
	return $retour;
}
?>
