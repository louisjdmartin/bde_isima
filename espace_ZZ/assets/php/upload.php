<?php
session_start();
require "../../../api/api.php";
$user = authentification($_SESSION['token']);
if(!isset($user['autorisations']['club']))die("Vous devez être BDE ou club pour acceder a cette fonction !<br />Si vous êtes identifié en tant que BDE avec le mode 'rester connecté' ouvrez la page une page quelquonque (gestion de cartes/d'articles... ) pour re-initialiser la session ");

if(!empty($_FILES['file']['name'])){
	if ($_FILES['file']['error'] > 0)die("<h2>Erreur lors du transfert !</h2><p>Cela peut etre cause par un fichier trop gros</p>");
	$extensions_valides = array( 'jpg' , 'jpeg', 'png');
	$extension_upload = strtolower(  substr(  strrchr($_FILES['file']['name'], '.')  ,1)  );
	if ( in_array($extension_upload,$extensions_valides) ){		 
		$nom =  uniqid().'.'.$extension_upload;
		$resultat = move_uploaded_file($_FILES['file']['tmp_name'],"../../images/uploads/".$nom);
		echo "/espace_ZZ/images/uploads/".$nom;
	}		
	die();
}
