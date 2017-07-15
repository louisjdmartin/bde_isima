<?php
/*
	proprietaire_club.php

	ENTREE
		id: id du club
		
	SORTIE:
		id: id du compte proprietaire ou NULL
		nom: Nom / prénom du gérant
		mail: mail du gérant
		nom_club: nom du club
		
	AUTORISATION:
		all
*/

$autorise = array("all");
function proprietaire_club($settings, $objets){	
	$bdd = $objets['bdd'];
	
	$retour['id'] = NULL;
	$retour['nom']= NULL;
	$retour['mail']=NULL;
	$retour['nom_club']=NULL;

	$requete = $bdd->query("SELECT clubs.nom AS nom_club,membres.nom,membres.prenom,membres.id,membres.mail FROM membres JOIN clubs ON membres.id=clubs.id_gerant WHERE clubs.id=".$settings['id']);	
	foreach($requete as $r)
	{
		$retour['id'] = $r['id'];
		$retour['nom']= utf8_encode($r['nom']." ".$r['prenom']);
		$retour['mail']=$r['mail'];
		$retour['nom_club']=$r['nom_club'];
	}
	//print_r($retour);
	return $retour;
}
?>
