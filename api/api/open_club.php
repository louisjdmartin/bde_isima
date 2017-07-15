<?php
/*
	open_club.php

	ENTREE
		nom: nom du nouveau club
		mail: mail du nouveau proprietaire
		token: jeton d'identification
		
	SORTIE:
		error: 1 si erreur
		id: numéro du nouveau club
		
	AUTORISATION:
		bde
*/

$autorise = array("all");
function open_club($settings, $objets){	
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
			$nom = $settings['nom'];
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
		$bdd->query("UPDATE membres SET grade=1 WHERE id=".$id_compte);
		$bdd->query("INSERT INTO clubs VALUES 
					(NULL, 
					$id_compte, 
					'../images/logo.png', 
					'".utf8_decode(addslashes($settings['nom']))."', 
					'Ce club est neuf ! La description arrive ;-)',
					'Ce club est neuf ! La description arrive ;-)',
					'".date("y-m-d h:i:s")."',
					1,
					NULL,NULL,NULL)");
		$id = $bdd->lastInsertId();	
	}

	return array("error" => 0, "id" => $id);
}
?>
