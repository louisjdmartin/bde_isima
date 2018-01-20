<?php
/*
	get_club.php
	Retourne toutes les infos des clubs
	
	ENTREE:
		id

	SORTIE:
		numero
		
	AUTORISATION:
		all
*/


function get_carte_by_id($settings, $objets){

	$bdd = $objets['bdd'];
	if(isset($settings['id']) && is_numeric($settings['id'])){
		$numero = $bdd->query('SELECT numero FROM membres WHERE id='.$settings['id'])->fetch()['numero'];
		return array("numero" => $numero, "error" => 0);
	}else return array("error" => "1");

}
