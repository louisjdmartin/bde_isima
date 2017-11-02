<?php
/*
	evt_annuler_inscription.php

	ENTREE
		token
		id_evt: id de l'événement pour lequel on annule
	SORTIE:
		error
	AUTORISATION:
		zz
*/



$autorise = array("zz", "bde");
function evt_annuler_inscription($settings, $objets){
	$bdd = $objets['bdd'];

	$bdd->query("DELETE FROM evt_commandes WHERE nom_membre LIKE '' AND id_membre = ".$objets['user_info']['uti_id']." AND id_event=".addslashes($settings['id_evt']));
	
	return array("error" => 0);
}
?>
