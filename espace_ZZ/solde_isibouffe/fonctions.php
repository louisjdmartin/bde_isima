<?php
ini_set("display_errors", "1");
//script pour se connecter à la bdd et autres fonctions
	require "../../api/config.conf.php";

try
{
	$donnees = new PDO(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
	
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}


?>
