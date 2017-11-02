<?php
/*
	evt_change_settings.php

	ENTREE
		token
		id_evt
		mode
		val
	SORTIE:
		error
		
	AUTORISATION:
		club
*/



$autorise = array("zz", "bde");
function evt_change_settings($settings, $objets){
	if(!isset($objets['user_info']['autorisations']['club']))return array("error" => 1, "error_msg" => "Accès refusé");

	if(!isset($settings['id_evt']) || !is_numeric($settings['id_evt'])) return array("error" => 1, "error_msg" => "Paramètre non valide");


	$bdd = $objets['bdd'];

	
	if($settings['mode'] == 'nom')$bdd->query('UPDATE evt_evenements SET nom="'.utf8_decode(addslashes($settings['val'])).'" WHERE id='.$settings['id_evt']);

	if($settings['mode'] == 'carte')$bdd->query('UPDATE evt_evenements SET carte_bde_possible="'.utf8_decode(addslashes($settings['val'])).'" WHERE id='.$settings['id_evt']);

	if($settings['mode'] == 'places')$bdd->query('UPDATE evt_evenements SET nb_places_max="'.utf8_decode(addslashes($settings['val'])).'" WHERE id='.$settings['id_evt']);


	return array("error" => 0);
	
}
