<?php

ini_set("display_errors","1");
if(isset($_GET['table'])){
	try
	{
		// On se connecte à MySQL
		$bdd = new PDO('mysql:host=localhost;dbname=bde', 'bde','***REMOVED***');
	}
	catch(Exception $e)
	{
		// En cas d'erreur, on arrête tout
		die('Erreur : '.$e->getMessage());
	}
	
	$bdd->query('SET CHARACTER SET utf8');
	 
	 // Si on demande les infos de la table clubs
	if($_GET['table'] == "clubs"){ 
		// On récupère tout le contenu de la table

		if (isset($_GET['after']))
		{
			$after = $_GET['after'];

			$after = date("Y-m-d H:i:s", $after);
			$reponse = $bdd->query('SELECT id, img, nom, description_courte, presentation, is_active, facebook, twitter, googleplus FROM clubs WHERE last_edit > "'. $after .'"');
		}
		else
		{
			$reponse = $bdd->query('SELECT id, nom, CONCAT("'.$_SERVER['HTTP_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'",img) AS img, description_courte, presentation, is_active, facebook, twitter, googleplus FROM clubs');
		}
		
	} else if($_GET['table'] == "events"){
		if (isset($_GET['after']))
		{
			$after = $_GET['after'];
			$after = date("Y-m-d H:i:s", $after);
			// Si on précise after, on retourne les infos > à last_edit
			$reponse = $bdd->query('SELECT id, id_club, debut, fin, titre, evenement, is_active FROM calendrier WHERE last_edit > "'. $after .'"');
		}
		else
		{
			// On retourne tout
			$reponse = $bdd->query('SELECT id, id_club, debut, fin, titre, evenement, is_active FROM calendrier');
		}		
	} else {
		die('Mauvais parametre.');
	}
	$rows = array();
	// On remplit le tableau avec chaque objet
	while($r = $reponse->fetchObject()){
		
		$rows[]=$r;
		
	}
	print json_encode($rows);
	$reponse->closeCursor();
}


?>
