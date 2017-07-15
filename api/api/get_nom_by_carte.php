<?php
/*
	get_nom_by_carte.php

	ENTREE
		numero: carte de l'utilisateur dont on veut connaitre le nom
					
	SORTIE:
		le nom de l'utilisateur
	AUTORISATION:
		all
*/



$autorise = array("zz", "bde");
function get_nom_by_carte($settings, $objets){
	$retour = "null";
	if(!isset($settings['numero']))return array($retour);
	$bdd = $objets['bdd'];
	$nom = $bdd->query("SELECT nom, prenom, surnom FROM membres WHERE numero = '".addslashes($settings['numero'])."'");
	foreach($nom as $n)
	{
		$retour = utf8_encode($n['prenom']) . "  " . utf8_encode($n['nom']);
		if($n['surnom']!=NULL)$retour .= " (" . utf8_encode($n['surnom']) .")";
	}
	
	return array($retour);
}
?>