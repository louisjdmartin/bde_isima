<?php
/*
	Fonction ajax.php
	Récupère le nom de fonction puis appelle l'API
	FONCTIONNE VIA URL REWRITING OU LIENS SYMBOLIQUE
*/

	require 'api.php';
	$url = $_SERVER["REQUEST_URI"];
	$url_frag = explode("/", $url);
	$fonction_et_get = end($url_frag);
	$fonction_et_get = explode("?", $fonction_et_get);
	$fonction = $fonction_et_get[0];
	echo ajax_api($fonction, $_REQUEST);
?>