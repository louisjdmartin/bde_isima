<?php
/*
	evt_inscription.php

	ENTREE
		token
		id_evt: id de l'événement pour lequel on s'inscrit
	SORTIE:
		bool
		liste	

	AUTORISATION:
		zz
*/



$autorise = array("zz", "bde");
function evt_deja_inscrit($settings, $objets){
	$bdd = $objets['bdd'];
	$bool = false;
	$liste = array();

	$commandes = $bdd->query("SELECT nom, prix, qte, commentaire FROM evt_commandes, evt_articles WHERE evt_commandes.id_article = evt_articles.id AND nom_membre ='' AND evt_commandes.id_event=".$settings['id_evt']." AND id_membre=".$objets['user_info']['uti_id']."");
	foreach($commandes as $a){
		$bool=true;
		$liste[] = array("nom" => utf8_encode($a['nom']),
				 "prix" => $a['prix'],
				 "qte" => $a['qte'],
				 "commentaire" => htmlentities(utf8_encode($a['commentaire'])));
	}	
	
	return array("bool" => $bool, "liste" => $liste);
}
?>
