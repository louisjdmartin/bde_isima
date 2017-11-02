<?php
/*
	evt_annuler_inscription_club.php

	ENTREE
		token
		id_cmd
	SORTIE:
		error
	AUTORISATION:
		zz
*/



$autorise = array("zz", "bde");
function evt_annuler_inscription_club($settings, $objets){
	$bdd = $objets['bdd'];

	if(isset($objets['user_info']['autorisations']['club']))$bdd->query("DELETE FROM evt_commandes WHERE id=".addslashes($settings['id_cmd']));
	
	return array("error" => 0);
}
?>
