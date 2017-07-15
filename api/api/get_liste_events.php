<?php
/*
	get_liste_events.php
	Retourne la liste des événements
	
	ENTREE:
		aucune ou id
		si id non vide, renvoie l'événément "id"
	SORTIES:
		Liste des événements
		
	AUTORISATION:
		all
*/


function get_liste_events($settings, $objets){
	$bdd = $objets['bdd'];
	
	$news = $bdd->query("SELECT calendrier.*, clubs.nom as nom_club FROM calendrier, clubs WHERE clubs.id=calendrier.id_club ORDER BY debut");
	if(isset($settings['id']) && is_numeric($settings['id']))
		$news = $bdd->query("SELECT calendrier.*, clubs.nom as nom_club FROM calendrier, clubs WHERE clubs.id=calendrier.id_club AND calendrier.id=".$settings['id']);
	$retour = array();
	$retour["nb_elt"]=0;
	foreach ($news as $r)
	{
		$retour['liste'][] = array(
			"id" => $r['id'],
			"nom" => utf8_encode($r['titre']),
			"club" => utf8_encode($r['nom_club']),
			"id_club" => utf8_encode($r['id_club']),
			"description" => utf8_encode($r['evenement']),
			"debut" => utf8_encode($r['debut']),
			"fin" => utf8_encode($r['fin']),
		);
		$retour["nb_elt"]++;
	}
	return $retour;
}
?>
