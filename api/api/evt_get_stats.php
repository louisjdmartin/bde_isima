<?php
/*
	evt_get_stats.php

	ENTREE
		token
		id_evt
	SORTIE:
		total_gain
		total_gain_bde
		liste[
			nom_article
			qte
			gain
		]
		taille_liste
	AUTORISATION:
		club
*/



$autorise = array("zz", "bde");
function evt_get_stats($settings, $objets){
	$bdd = $objets['bdd'];
	if(!isset($objets['user_info']['autorisations']['club']))return array("error" => 1, "error_msg" => "Accès refusé");

	if(!isset($settings['id_evt']) || !is_numeric($settings['id_evt'])) return array("error" => 1, "error_msg" => "Paramètre non valide");


	$gains_bde = $bdd->query("SELECT total_gain_carte FROM evt_evenements WHERE id=".$settings['id_evt'])->fetch()['total_gain_carte'];


	$liste_commandes = $bdd->query("SELECT SUM(evt_commandes.qte)*evt_articles.prix AS gain, SUM(evt_commandes.qte) AS qte , evt_articles.nom
									FROM evt_commandes, evt_articles
									WHERE
										evt_commandes.id_article = evt_articles.id
									AND evt_commandes.id_event = ".$settings['id_evt']."
									GROUP BY evt_commandes.id_article
									");

	$liste = array();
	$gains = 0;
	$taille_liste = 0;
	foreach($liste_commandes as $commande){
		$liste[] = array(
			"nom_article" => $commande['nom'],
			"qte" => $commande['qte'],
			"gain" => $commande['gain']
		);
		$gains += $commande['gain'];
		$taille_liste ++;
	}



	return array(
		"error" => 0, 
		"total_gain_bde" => $gains_bde,
		"total_gain" => $gains,
		"liste" => $liste,
		"taille_liste" => $taille_liste
	);
}
