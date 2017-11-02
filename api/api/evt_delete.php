<?php
/*
	evt_delete.php

	ENTREE
		token
		id_evt
		date_limite_insc
		date_event
	SORTIE:
		error
		
	AUTORISATION:
		club
*/



$autorise = array("zz", "bde");
function evt_delete($settings, $objets){
	if(!isset($objets['user_info']['autorisations']['club']))return array("error" => 1, "error_msg" => "Accès refusé");

	if(!isset($settings['id_evt']) || !is_numeric($settings['id_evt'])) return array("error" => 1, "error_msg" => "Paramètre non valide");


	$bdd = $objets['bdd'];

	
	$bdd->query("DELETE FROM evt_listearticles WHERE id_event=".$settings['id_evt']);
	$bdd->query("DELETE FROM evt_evenements WHERE id=".$settings['id_evt']);
	
	return array("error" => "0");

	
}
