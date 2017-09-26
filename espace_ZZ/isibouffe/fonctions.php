<?php
ini_set("display_errors", "1");
//script pour se connecter à la bdd et autres fonctions


try
{
	$donnees = new PDO('mysql:host=localhost;dbname=isibouffe;charset=utf8', 'root', 'root');
	
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}


?>
