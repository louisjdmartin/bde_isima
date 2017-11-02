<?php
/*
	evt_inscription.php

	ENTREE
	
		id_evt: id de l'événement pour lequel on s'inscrit
	SORTIE:
		places	

	AUTORISATION:
		zz
*/



$autorise = array("zz", "bde");
function evt_places_dispo($settings, $objets){
	$bdd = $objets['bdd'];

	$places = $bdd->query("SELECT nb_places_max FROM evt_evenements WHERE id=".$settings['id_evt']);
	foreach($places as $p){
		if($p['nb_places_max']>0){
			$utilise = $bdd->query("SELECT SUM(qte) AS total FROM evt_commandes	WHERE id_event=".$settings['id_evt']);
			foreach($utilise as $u){
				if(!is_numeric($u['total']))$total_qte = 0;
				else $total_qte = $u['total'];
				$places = $p['nb_places_max']-$total_qte;
			}
		}
		else $places='infini';
	}
	return array("places" => $places);
	
}
?>
