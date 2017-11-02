<?php
/*
	get_info_evt.php

	ENTREE
		id
					
	SORTIE:
		tout
	AUTORISATION:
		all
*/



$autorise = array("zz", "bde");
function get_info_evt($settings, $objets){
	$bdd = $objets['bdd'];
	
	if(!isset($settings['id']))return array("error" => 1);
	
	$evt = $bdd->query("SELECT * FROM evt_evenements WHERE id='".addslashes($settings['id'])."' ORDER BY date_event DESC");
		
	$retour = array("error" => 1, "error_msg" => "Impossible de trouver l'événement recherché !");
	foreach ($evt as $r)
	{
		$retour = array(
			"error" => 0,
			"id" => $r['id'],
			"id_club" => $r['id_club'],
			"places" => $r['nb_places_max'],
			"carte_bde_possible" => $r['carte_bde_possible'],
			"nom" => utf8_encode($r['nom']),
			"date_limite_commande" => utf8_encode($r['date_limite_commande']),
			"date_event" => utf8_encode($r['date_event'])
		);
	}
	return $retour;
}
?>
