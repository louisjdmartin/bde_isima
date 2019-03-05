<?php
/*
	modifier_article.php
	Modifie un article
	
	ENTREE:
		id:		id de l'article a modifier (Ou 0 pour un ajout)
		img:	url vers l'image
		nom:	Nom de l'article
		tarif:	Prix de l'article
		
	SORTIES:
		Rien
		
	AUTORISATION:
		bde
*/


function modifier_article($settings, $objets){
	$bdd = $objets['bdd'];	
	if(!isset($objets['user_info']['autorisations']['bde']))return (array("error" => 1, "msg" => 'Action refusée'));
	if(empty($settings['img']) or empty($settings['tarif']))return (array("error" => 1, "msg" => "Informations manquantes !"));
	if($settings['id']=="0"){
		// Ajout
		if(!is_numeric($settings['tarif']))return (array("error" => 1, "msg" => "Le tarif n'est pas numérique !"));
                if(!is_numeric($settings['tarif_nc']))return (array("error" => 1, "msg" => "Le tarif n'est pas numérique !"));
		$bdd->query("INSERT INTO articles VALUES(NULL, '".utf8_decode(addslashes($settings['nom']))."', '".$settings['tarif']."', '".$settings['tarif_nc']."', '".addslashes($settings['img'])."')");
		$retour = array("error" => 0);
	}
	else{
		// Modification
		if(empty($settings['nom']))
		{
			$bdd->query("DELETE FROM transactions WHERE id_article=".$settings['id']);
			$bdd->query("DELETE FROM articles WHERE id=".$settings['id']);
			$retour = array("error" => 0);
		}
		else 
		{
			$bdd->query("UPDATE articles SET img='".addslashes($settings['img'])."' WHERE id=".$settings['id']);
			$bdd->query("UPDATE articles SET tarif='".addslashes($settings['tarif'])."' WHERE id=".$settings['id']);
			$bdd->query("UPDATE articles SET nom='".utf8_decode(addslashes($settings['nom']))."' WHERE id=".$settings['id']);
			$bdd->query("UPDATE articles SET tarif_non_cotisant='".addslashes($settings['tarif_nc'])."' WHERE id=".$settings['id']);
			$retour = array("error" => 0);
		}
	}
	
	
	return $retour;
}
?>
