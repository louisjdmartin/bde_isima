<?php
ini_set("display_errors", "1");
//script pour se connecter à la bdd et autres fonctions


try
{
	$donnees = new PDO('mysql:host=localhost;dbname=bde;charset=utf8', 'bde', '***REMOVED***');
	
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}


?>
