<?php
/*
	add_evt.php
	Ajoute un événement avec inscription
	
	ENTREE:
		token, id_club, nom, places, limite [date limite inscription], date, bde [true=paiement par carte BDE possible]
		
	SORTIES:
		id de l'insertion
		error à 0 si réussite
		
	AUTORISATION:
		bde club
*/


function add_evt($settings, $objets){
	$bdd = $objets['bdd'];	

	
	if(club_autorise($settings['id_club'], $objets['user_info']))
	{
		$bdd->query("INSERT INTO evt_evenements VALUES 
		(
			NULL,
			'".utf8_decode(addslashes($settings['nom']))."',
			'".utf8_decode(addslashes($settings['id_club']))."',
			'".utf8_decode(addslashes($settings['places']))."',
			".($settings['bde']=='true' ? 1:0).",
			'".utf8_decode(addslashes($settings['limite']))."',
			'".utf8_decode(addslashes($settings['date']))."',
                        0.0
			
		)");
		$id = $bdd->lastInsertId();	
		$retour = array("error" => "0", "id" => $id);
	}
	else $retour= array("error" => "1");
	
	
	return $retour;
}
?>
