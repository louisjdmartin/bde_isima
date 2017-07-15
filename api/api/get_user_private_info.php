<?php
/*
	get_user_private_infos.php
	Retourne toutes les infos d'un utilisateur (sauf mot de passe):
	id, assos, autorisations, nom, prenom, mail, carte
	
	ENTREE
		id identifiant de l'utilisateur dont on veut connaitre les infos
			
	SORTIE:
		Si $settings['id'] == $objet['uti_id'] ou $objets['user_info']['autorisations'] == 'bde' ou $objets['user_info']['autorisations'] == 'root'
			id, assos, autorisations, nom, prenom, mail, carte
		Sinon 
			erreur
	AUTORISATION:
		zz bde
*/



$autorise = array("zz", "bde");
function get_user_private_infos($settings, $objets){
	/*
		Script
	*/
	return array($objets);
}
?>