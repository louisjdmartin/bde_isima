<?php
/*
	evt_copie.php

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
function evt_copie($settings, $objets){
	if(!isset($objets['user_info']['autorisations']['club']))return array("error" => 1, "error_msg" => "Accès refusé");

	if(!isset($settings['id_evt']) || !is_numeric($settings['id_evt'])) return array("error" => 1, "error_msg" => "Paramètre non valide");


	$bdd = $objets['bdd'];

	
	$event = $bdd->query("SELECT * FROM evt_evenements WHERE id=".$settings['id_evt'])->fetch();
	$bdd->query("INSERT INTO evt_evenements VALUES 
	(
		NULL,
		'".(addslashes($event['nom']))."',
		'".(addslashes($event['id_club']))."',
		'".(addslashes($event['nb_places_max']))."',
		'".(addslashes($event['carte_bde_possible']))."',
		'".(addslashes($settings['date_limite_insc']))."',
		'".(addslashes($settings['date_event']))."',
                    0.0
		
	)");

	$id = $bdd->lastInsertId();	
	$liste_article = $bdd->query("SELECT * FROM evt_listearticles WHERE id_event=".$settings['id_evt']);
	foreach ($liste_article as $a)$bdd->query("INSERT INTO evt_listearticles VALUES ($id, ".$a['id_article'].", ".$a['qte_dispo'].")");
	return array("error" => "0", "id" => $id);

	
}
