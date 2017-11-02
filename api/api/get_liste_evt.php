<?php
/*
	get_liste_evt.php

	ENTREE
		id_club, si non défini, renvoie tout les evenements ) venir
					
	SORTIE:
		tout
	AUTORISATION:
		all
*/



$autorise = array("zz", "bde");
function get_liste_evt($settings, $objets){
	$bdd = $objets['bdd'];
	
	if(!isset($settings['id_club']))$evt = $bdd->query("SELECT * FROM evt_evenements WHERE date_limite_commande>NOW() ORDER BY date_event DESC");
	
	else $evt = $bdd->query("SELECT * FROM evt_evenements WHERE id_club='".addslashes($settings['id_club'])."' ORDER BY date_event DESC");
		
	$retour = array();
	$retour["nb_elt"]=0;
	foreach ($evt as $r)
	{
		$retour['liste'][] = array(
			"id" => $r['id'],
			"id_club" => $r['id_club'],
			"places" => $r['nb_places_max'],
			"carte_bde_possible" => $r['carte_bde_possible'],
			"nom" => utf8_encode($r['nom']),
			"date_limite_commande" => utf8_encode($r['date_limite_commande']),
			"date_event" => utf8_encode($r['date_event'])
		);
		$retour["nb_elt"]++;
	}
	return $retour;
}
?>
