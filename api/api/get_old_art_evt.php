<?php
/*
	del_art_evt.php.php

	ENTREE
		id_evt
					
	SORTIE:
		tout
	AUTORISATION:
		all
*/



$autorise = array("zz", "bde");
function get_old_art_evt($settings, $objets){
	$bdd = $objets['bdd'];
	if(!isset($settings['id_evt']) OR !is_numeric($settings['id_evt']))return array("error" => 2);
	
	$evt = $bdd->query("SELECT id_club FROM evt_evenements WHERE id='".addslashes($settings['id_evt'])."' ORDER BY date_event DESC");
	$id_club=-1;
	foreach($evt as $e)$id_club=$e['id_club'];
	
	if($id_club!=-1 AND club_autorise($id_club, $objets['user_info'])){
		$liste = $bdd->query("SELECT * FROM evt_articles WHERE
					id_club = ".$id_club."
					AND
					id NOT IN(SELECT id_article FROM evt_listearticles WHERE id_event = '".addslashes($settings['id_evt'])."')
					");
	
		$retour = array();
		$retour["nb_elt"]=0;
		
		
		foreach ($liste as $r)
		{
			
			$retour['liste'][] = array(
				"id" => $r['id'],
				"nom" => utf8_encode($r['nom']),
				"prix" => utf8_encode($r['prix'])
			);
			$retour["nb_elt"]++;
	}
		
	}else $retour = array("error" => 1);
	return $retour;
}
?>
