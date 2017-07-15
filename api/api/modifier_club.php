<?php
/*
	modifier_club.php
	Modifie un club
	
	ENTREE:
		token, id, img, nom, description_courte, presentation, facebook, twitter, googleplus
		
	SORTIES:
		error à 0 si réussite
		
	AUTORISATION:
		bde club
*/


function modifier_club($settings, $objets){
	$bdd = $objets['bdd'];	

	
	if(club_autorise($settings['id'], $objets['user_info']))
	{
		$bdd->query("UPDATE clubs
			SET
				img='".utf8_decode(addslashes($settings['img']))."',
				nom='".utf8_decode(addslashes($settings['nom']))."',
				description_courte='".utf8_decode(addslashes($settings['description_courte']))."',
				presentation='".utf8_decode(addslashes($settings['presentation']))."',
				facebook='".utf8_decode(addslashes($settings['facebook']))."',
				twitter='".utf8_decode(addslashes($settings['twitter']))."',
				googleplus='".utf8_decode(addslashes($settings['googleplus']))."',
				last_edit='".date("Y-m-d h:i:s")."'
			WHERE id = '".utf8_decode(addslashes($settings['id']))."'
		");
		$retour = array("error" => "0");
	}
	else $retour= array("error" => "1");
	
	
	return $retour;
}
?>
