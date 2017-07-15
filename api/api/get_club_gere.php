<?php
/*
	get_club_gere.php

	ENTREE
		token: jeton d'identification
		
	SORTIE:
		liste contenant 
			id: id du club géré par la personne
			nom
	AUTORISATION:
		club
*/

$autorise = array("all");
function get_club_gere($settings, $objets){	
	$bdd = $objets['bdd'];
	
	if(!isset($objets['user_info']['autorisations']['club']))
	{
		$retour = array(
			'error' => 1,
			'error_msg' => 'Accès refusé',
			'id' => null
		);
	}
	else
	{
		$liste = array();
		if(!isset($objets['user_info']['autorisations']['bde']))
			$rep = $bdd->query('SELECT id,  nom FROM clubs WHERE id_gerant='.$objets['user_info']['uti_id']);
		else
			$rep = $bdd->query('SELECT id,nom FROM clubs');
		foreach($rep as $r) $liste[] = array("id" =>$r['id'], 'nom' => $r['nom']);
		return array('liste' => $liste, 'nb_elt' => count($liste));
	}

	return array("error" => 1, 'id'=>null);
}
?>
