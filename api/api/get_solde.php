<?php
/*
	get_solde.php

	ENTREE
		numero : carte de l'utilisateur dont on veut connaitre le solde (si vide retourne son propre solde)
		token : token d'identification
					
	SORTIE:
		Retourne le solde
			si $objets['user_info']['autorisations'] contient 'bde' retourne le solde du compte id
			sinon retourne son propre solde
		Si non authentifié retourne erreur
	AUTORISATION:
		zz bde
*/



$autorise = array("zz", "bde");
function get_solde($settings, $objets){
	$bdd = $objets['bdd'];
	if($objets['user_info']['uti_id']!=NULL and (!isset($objets['user_info']['autorisations']['bde']) or !isset($settings['numero'])))
	{
		$solde = $bdd->query("SELECT solde FROM membres WHERE id=".$objets['user_info']['uti_id']);
	}else if(isset($objets['user_info']['autorisations']['bde']) AND isset($settings['numero']))
	{
		$solde = $bdd->query("SELECT solde,cotisation FROM membres WHERE numero=".$settings['numero']);
	}
	else return array("error" => 1, "msg" => "Action refusé !");
	$sortie=NULL;
	foreach($solde as $s){
		$sortie = $s['solde'];
		$cotis = $s['cotisation'];
	}
	
	return array("solde" => $sortie, "cotisation" => $cotis);
}
?>