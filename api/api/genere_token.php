<?php
/*
	genere_token.php

	ENTREE
		login: mail ou carte
		pass: mot de passe
		expiration: date d'expiration (timestamp) (si vide, $expiration = time()+24*3600)
		
	SORTIE:
		token: jeton d'authentification à utiliser sur les autres fonctions
		expiration: date d'expiration (timestamp)
		error: si le token n'a pas pu être généré
		
	AUTORISATION:
		all
*/

$autorise = array("all");
function genere_token($settings, $objets){	
	$bdd = $objets['bdd'];
	
	$retour = array("error" => 1, "msg" => "Ce compte n'existe pas, vérifiez le mail ou le numéro de carte");
	if(!isset($settings['login']) OR !isset($settings['pass']))return $retour;
	
	if(is_numeric($settings['login']))$cond = "numero = ".$settings['login'];
	else $cond = "mail = '".addslashes($settings['login'])."'";
	$comptes = $bdd->query("SELECT mdp, id FROM membres WHERE ".$cond);
	foreach($comptes as $c)
	{
		if(md5($settings['pass'])==$c['mdp'])
		{
			$token = uniqid();
			$expiration = time()+24*3600;
			if(isset($settings['expiration']) && is_numeric($settings['expiration']))$expiration = intval($settings['expiration']);
			$retour = array(
				"error" => 0,
				"token" => $token,
				"expiration" => $expiration
			);
			$bdd->query("INSERT INTO token VALUES ('".$token."','".$c['id']."','".$expiration."')");
		}
		else 
		{
			$retour = array(
				"error" => 1,
				"msg" => "Mot de passe incorrect"
			);
		}
	}
	return $retour;
}
?>