<?php
/*
	change_proprietaire_club.php

	ENTREE
		id: id du club
		mail: mail du nouveau proprietaire
		token: jeton d'identification
		
	SORTIE:
		error: 1 si erreur
		
	AUTORISATION:
		bde
*/

$autorise = array("all");
function change_proprietaire_club($settings, $objets){	
	$bdd = $objets['bdd'];
	
	if(!isset($objets['user_info']['autorisations']['bde']))
	{
		$retour = array(
			'error' => 1,
			'error_msg' => 'Accès refusé'
		);
		return $retour;
	}
	else
	{
		// Recherche du compte
		$id_compte=null;
	    $rep = $bdd->query("SELECT id FROM membres WHERE mail='".$settings['mail']."'");
		foreach($rep as $r)
		{
			$id_compte = $r['id'];
		}	
		if($id_compte == null)
		{// nom, prenom,  mail, promo
			$noms = $bdd->query("SELECT nom FROM clubs WHERE id=".$settings['id']);
			$nom=null;
			foreach($noms as $n)$nom=$n['nom'];
			$settings_ajout = array(
				'token' => $settings['token'],
				'nom' => $nom,
				'prenom' => "Club",
				'mail' => $settings['mail'],
				'promo' => "42",
				'id' => 0
			);
			api("modifier_membre",$settings_ajout);
			$rep = $bdd->query("SELECT id FROM membres WHERE mail='".$settings['mail']."'");
			foreach($rep as $r)
			{
				$id_compte = $r['id'];
			}	
		}
		$rep = $bdd->query("SELECT id_gerant FROM clubs WHERE id=".$settings['id']);
		foreach ($rep as $r)$id_ancien_compte=$r['id_gerant'];
		$bdd->query("UPDATE clubs SET id_gerant=".$id_compte." WHERE id=".$settings['id']);
		$bdd->query("UPDATE membres SET grade=0 WHERE id=".$id_ancien_compte." AND id NOT IN (SELECT id_gerant FROM clubs)");		
		$bdd->query("UPDATE membres SET grade=1 WHERE id=".$id_compte);
	}

	return array("error" => 0);
}
?>
