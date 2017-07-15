<?php
/*
	open_club.php

	ENTREE
		nom: nom du nouveau club
		mail: mail du nouveau proprietaire
		token: jeton d'identification
		
	SORTIE:
		error: 1 si erreur
		
	AUTORISATION:
		bde
*/

$autorise = array("all");
function close_club($settings, $objets){	
	$bdd = $objets['bdd'];
	if(!isset($objets['user_info']['autorisations']['bde']))
	{
		$retour = array(
			'error' => 1,
			'error_msg' => 'Accès refusé'
		);
		return $retour;
	}
	else
	{
		$rep = $bdd->query("SELECT id_gerant FROM clubs WHERE id=".$settings['id']);
		foreach ($rep as $r)$id_ancien_compte=$r['id_gerant'];
		$bdd->query("DELETE FROM calendrier WHERE id_club=".addslashes($settings['id']));
		$bdd->query("DELETE FROM clubs WHERE id=".addslashes($settings['id']));
		$bdd->query("UPDATE membres SET grade=0 WHERE id=".$id_ancien_compte." AND id NOT IN (SELECT id_gerant FROM clubs)");	
		return array("error" => 0);
	}
}
