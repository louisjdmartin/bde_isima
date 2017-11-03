<?php
/*
	high_score.php

	ENTREE
		token
	SORTIE:
		scores[
			nom_art
			nom_membre_record
			record
			score_actuel
		]
		
	AUTORISATION:
		ZZ
*/



$autorise = array("zz", "bde");
function high_score($settings, $objets){
	if(!isset($objets['user_info']['uti_id']))return array("error" => 1, "error_msg" => "Accès refusé");

	$bdd = $objets['bdd'];

	$articles = $bdd->query("SELECT nom, id FROM articles ORDER BY nom");
	$scores = array();

	foreach ($articles as $a){
		$score_actuel = $bdd->query("SELECT COUNT(transactions.id) AS score FROM membres, transactions, articles WHERE articles.id=transactions.id_article AND membres.id=transactions.id_personne AND membres.id=".$objets['user_info']['uti_id']." AND articles.id=".$a['id']." GROUP BY id_personne, transactions.id_article ORDER BY COUNT(transactions.id), transactions.id_article")->fetch()['score'];

		if(!$score_actuel)$score_actuel = 0;

		$infos_record = $bdd->query("SELECT COUNT(transactions.id) AS score,id_personne, membres.nom, prenom FROM membres, transactions, articles WHERE articles.id=transactions.id_article AND membres.id=transactions.id_personne AND articles.id=".$a['id']." GROUP BY id_personne, transactions.id_article ORDER BY COUNT(transactions.id) DESC LIMIT 1")->fetch();
	
		$record = $infos_record['score'];
		$nom_membre_record = $infos_record['nom']." ".$infos_record['prenom'];


		$scores[] = array(
			"nom_art" => utf8_encode($a['nom']),
			"nom_membre_record" => $nom_membre_record,
			"record" => $record,
			"score_actuel" => $score_actuel
		);	
	}
	return $scores;
}
