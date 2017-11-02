<?php
/*
	get_evt.php

	ENTREE
		token
		id_evt
	SORTIE:
		error
		nom
		date_insc
		date_evt
		carte_bde
		places
		
	AUTORISATION:
		club
*/



$autorise = array("zz", "bde");
function get_evt($settings, $objets){
	if(!isset($objets['user_info']['autorisations']['club']))return array("error" => 1, "error_msg" => "Accès refusé");

	if(!isset($settings['id_evt']) || !is_numeric($settings['id_evt'])) return array("error" => 1, "error_msg" => "Paramètre non valide");

	$event = $objets['bdd']->query("SELECT nom, date_limite_commande, date_event, carte_bde_possible, nb_places_max FROM evt_evenements WHERE id = ".$settings['id_evt'])->fetch();

	return array(
		"error" => 0,
		"nom" => utf8_encode($event['nom']),
		"date_insc" => $event['date_limite_commande'],
		"date_evt" => $event['date_event'],
		"carte_bde" => $event['carte_bde_possible'],
		"places" => $event["nb_places_max"]
	
	);
	
}
