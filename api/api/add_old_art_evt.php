<?php
/*
	add_old_art_evt.php

	ENTREE
		token, id_evt, id_article
					
	SORTIE:
		tout
	AUTORISATION:
		all
*/



$autorise = array("zz", "bde");
function add_old_art_evt($settings, $objets){
	$bdd = $objets['bdd'];
	if(!isset($settings['id_evt']) OR !is_numeric($settings['id_evt']))return array("error" => 1);
	
	$evt = $bdd->query("SELECT id_club FROM evt_evenements WHERE id='".addslashes($settings['id_evt'])."' ORDER BY date_event DESC");
	$id_club=-1;
	foreach($evt as $e)$id_club=$e['id_club'];
	
	if($id_club!=-1 AND club_autorise($id_club, $objets['user_info'])){
		
		$bdd->query("INSERT INTO evt_listearticles VALUES (".$settings['id_evt'].", ".$settings['id_article'].", ".$settings['qte'].")");
	
		$retour = array("error" => 0);
		
	}else $retour = array("error" => 1);
	return $retour;
}
?>
