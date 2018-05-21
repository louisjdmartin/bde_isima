<?php
/*
	get_log_recharges.php

	ENTREE
		numero: carte de l'utilisateur dont on veut connaitre le solde (si vide retourne son propre solde)
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
function get_log_consos($settings, $objets){
	$bdd = $objets['bdd'];
	$limit = 10;
	if(isset($settings['nombre']) AND is_numeric($settings['nombre']))$limit = $settings['nombre'];
	if(!isset($objets['user_info']['autorisations']['bde']))unset($settings['numero']);
	if($objets['user_info']['uti_id']!=NULL and !isset($settings['numero']))
	{
		$recharges = $bdd->query("SELECT transactions.timestamp, transactions.anciensolde, articles.nom, articles.tarif FROM transactions, articles WHERE transactions.id_personne=".$objets['user_info']['uti_id']." AND articles.id=transactions.id_article ORDER BY transactions.timestamp DESC LIMIT 0, $limit");
	}else if(isset($settings['numero']) and isset($objets['user_info']['autorisations']['bde']))
	{
		$recharges = $bdd->query("SELECT transactions.timestamp, transactions.anciensolde, articles.nom, articles.tarif FROM transactions, articles, membres WHERE transactions.id_personne= membres.id AND membres.numero = ".$settings['numero']." AND articles.id=transactions.id_article ORDER BY timestamp DESC LIMIT 0, $limit");
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
