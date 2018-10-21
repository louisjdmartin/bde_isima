<?php
/*
	get_log_recharges_isibouffe.php

	ENTREE
		token : token d'identification
		nombre: nombre de recharges que l'on souhaite voir (10 si vide)
					
	SORTIE:
		Retourne les 10 dernières recharges
			si $objets['user_info']['autorisations'] contient 'bde' retourne le solde du compte choisi
			sinon retourne son propre solde
		Si non authentifié retourne erreur
	AUTORISATION:
		zz bde
*/



$autorise = array("zz", "bde");
function get_log_recharges_isibouffe($settings, $objets){
	$bdd = $objets['bdd'];
	$limit = 10;
	if(isset($settings['nombre']) AND is_numeric($settings['nombre']))$limit = $settings['nombre'];

	if($objets['user_info']['uti_id']!=NULL)
	{
		$id_isibouffe=$bdd->query("SELECT id_isibouffe FROM isibouffe_link WHERE id_bde=".$objets['user_info']['uti_id'])->fetch()['id_isibouffe'];
		$recharges = $bdd->query("SELECT recharge, date FROM isibouffe_hist_recharges WHERE id_zz=".$id_isibouffe." ORDER BY date DESC LIMIT 0, $limit");
	}
	else return array("error" => 1, "msg" => "Action refusé !");
	$retour = array();
	$retour["nb_elt"]=0;
	foreach($recharges as $r){
		$retour['liste'][] = array(
			"montant" => $r['recharge'],
			"date" => utf8_encode($r['date'])
		);
		$retour["nb_elt"]++;
	}
	
	return $retour;
}
?>
