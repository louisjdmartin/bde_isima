<?php
/*
	modifier_event.php
	Modifie un article
	
	ENTREE:
		id:		id de l'événement a modifier (Ou 0 pour un ajout)
		id_club:id du club associé (si id==0)
		nom:	Nom de l'événement
		description: description de l'événement
		date_deb,date_fin: Dates de début et fin au format AAAA-MM-JJ HH:MM
		
	SORTIES:
		error à 1 si echec
		
	AUTORISATION:
		bde, club
*/


function modifier_event($settings, $objets){
	$bdd = $objets['bdd'];
	if($settings['id']=="0"){
		// Ajout si autorisé
		if(club_autorise($settings['id_club'],$objets['user_info'])){
			// Champs dans la BDD id, id_club, jour, mois, annee, debut, fin, titre, evenement, last_edit, is_active
			// C'est quoi cette table naze ? et obligé de la garder sinon ISIDROID ça marche plus :-P
			$jour = date('d', strtotime($settings['date_deb']));
			$mois = date('m', strtotime($settings['date_deb']));
			$annee= date('Y', strtotime($settings['date_deb']));
			$bdd->query("INSERT INTO calendrier VALUES(
				NULL,
				".$settings['id_club'].",
				'$jour', '$mois', '$annee',
				'".addslashes($settings['date_deb'])."',
				'".addslashes($settings['date_fin'])."',
				'".utf8_decode(addslashes($settings['nom']))."',
				'".utf8_decode(addslashes($settings['description']))."',
				'".date("Y-m-d h:i:s")."', 1);
			");		
			$retour = array("error" => 0);
		}
		else $retour = array("error" => 1, "msg" => "Action refusé");
	}
	else{
		// Modification
		if(empty($settings['nom']))
		{
			$bdd->query("DELETE FROM calendrier WHERE id=".$settings['id']);
			$retour = array("error" => 0);
		}
		else 
		{
			$clubs = $bdd->query("SELECT id_club FROM calendrier WHERE id=".$settings['id']);
			foreach ($clubs as $c)$id_club = $c['id_club'];

			$jour = date('d', strtotime($settings['date_deb']));
			$mois = date('m', strtotime($settings['date_deb']));
			$annee= date('Y', strtotime($settings['date_deb']));
			if(club_autorise($id_club,$objets['user_info']))$bdd->query("UPDATE calendrier SET
				jour = '$jour', mois = '$mois', annee = '$annee',
				debut = '".addslashes($settings['date_deb'])."',
				fin = '".addslashes($settings['date_fin'])."',
				titre = '".utf8_decode(addslashes($settings['nom']))."',
				evenement = '".utf8_decode(addslashes($settings['description']))."',
				last_edit = '".date("Y-m-d h:i:s")."' WHERE id=".$settings['id']."
			");		
			$retour = array("error" => 0);
		}
	}
	
exec('date +%s > /var/www/clients/client1/web4/home/bde/www/api/lastmodifevents.txt');	
	return $retour;
}
?>
