<?php
/*
	modifier_partenaire.php
	Modifie un article
	
	ENTREE:
		id:		id de l'article a modifier (Ou 0 pour un ajout)
		img:	url vers l'image
		nom:	Nom de l'article
		description:	Texte de description du partenaire
		
	SORTIES:
		Rien
		
	AUTORISATION:
		bde
*/


function modifier_news($settings, $objets){
	$bdd = $objets['bdd'];	
	if(!isset($objets['user_info']['autorisations']['bde']))return (array("error" => 1, "msg" => 'Action refusée'));
	if($settings['id']=="0"){
		// Ajout
		$bdd->query("INSERT INTO accueil_articles VALUES(NULL, '".utf8_decode(addslashes($settings['nom']))."', ' ', '".utf8_decode(addslashes($settings['description']))."', '".addslashes($settings['img'])."')");
		$retour = array("error" => 0);
	}
	else{
		// Modification
		if(empty($settings['nom']))
		{
			$bdd->query("DELETE FROM partenaires WHERE id=".$settings['id']);
			$retour = array("error" => 0);
		}
		else 
		{
			$bdd->query("UPDATE accueil_articles SET img='".addslashes($settings['img'])."' WHERE id=".$settings['id']);
			$bdd->query("UPDATE accueil_articles SET texte='".utf8_decode(addslashes($settings['description']))."' WHERE id=".$settings['id']);
			$bdd->query("UPDATE accueil_articles SET titre='".utf8_decode(addslashes($settings['nom']))."' WHERE id=".$settings['id']);
			$retour = array("error" => 0);
		}
	}
	
	
	return $retour;
}
?>
