<?php
/*
	get_log_recharges.php

	ENTREE
		token : token d'identification
		nombre: nombre de recharges que l'on souhaite voir (10 si vide)
					
	SORTIE:
		Retourne les 10 dernières consos
			si $objets['user_info']['autorisations'] contient 'bde' retourne le solde du compte choisi
			sinon retourne son propre solde
		Si non authentifié retourne erreur
	AUTORISATION:
		zz bde
*/



$autorise = array("zz", "bde");
function get_log_consos_isibouffe($settings, $objets){
	$bdd = $objets['bdd'];
	$limit = 10;
	if(isset($settings['nombre']) AND is_numeric($settings['nombre']))$limit = $settings['nombre'];
	if(!isset($objets['user_info']['autorisations']['bde']))unset($settings['numero']);
	if($objets['user_info']['uti_id']!=NULL)
	{
		$id_isibouffe=$bdd->query("SELECT id_isibouffe FROM isibouffe_link WHERE id_bde=".$objets['user_info']['uti_id'])->fetch()['id_isibouffe'];
		$recharges = $bdd->query("SELECT isibouffe_article.prix_article AS tarif, isibouffe_historique.date AS timestamp, isibouffe_article.nom_article AS nom, isibouffe_historique.solde AS anciensolde
					 FROM isibouffe_historique, isibouffe_article 
					 WHERE isibouffe_historique.id_zz=".$id_isibouffe." AND isibouffe_historique.id_article=isibouffe_article.id_article ORDER BY isibouffe_historique.date DESC LIMIT 0, $limit");
	}
	else return array("error" => 1, "msg" => "Action refusé !", "nb_elt" => 0, "liste" => array());
	$retour = array();
	$retour["nb_elt"]=0;
	foreach($recharges as $r){
		$retour['liste'][] = array(
			"tarif" => $r['tarif'],
			"date" => utf8_encode($r['timestamp']),
			"article" => utf8_encode($r['nom']),
			"anciensolde" => utf8_encode($r['anciensolde'])
		);
		$retour["nb_elt"]++;
	}
	
	return $retour;
}
?>
