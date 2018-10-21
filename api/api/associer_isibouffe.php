<?php
/*
	associer_isibouffe.php
	Retourne toutes les infos des clubs
	
	ENTREE:
		id_isibouffe, token

	SORTIE:
		aucune
		
	AUTORISATION:
		all
*/


function associer_isibouffe($settings, $objets){

	$bdd = $objets['bdd'];
	if(!isset($objets['user_info']['uti_id']))return array("error" => "2");
	$bdd->query("DELETE FROM isibouffe_link WHERE id_bde=".$objets['user_info']['uti_id']);
	if($settings['id_isibouffe']!=0)
		$bdd->query("INSERT INTO isibouffe_link VALUES (".$objets['user_info']['uti_id'].",".intval($settings['id_isibouffe']).")");
	return array("error"=>0);

}
