<?php
/*
	get_liste_clubs.php
	Retourne la liste des clubs actifs
	ENTREE:
		aucune
		
	SORTIES:
		Tableau ou chaque entrée contient
		id, img, nom, description_courte, last_edit, is_active, facebook, twitter, googleplus
		
	AUTORISATION:
		all
*/

function get_liste_clubs_actifs($settings, $objets){
	/*
		Script
		$objets['bdd']
	*/
	$base = $objets['bdd'];
	$request = $base->query("SELECT id, img, nom, description_courte, last_edit, is_active, facebook, twitter, googleplus FROM clubs WHERE is_active=1 ORDER BY id");
	$retour = array("error" => 0);
	$retour["nb_elt"] = 0;
	foreach ($request as $r)
	{
		$retour['liste'][] = array(
				"id" => $r['id'],
				"img" => $r['img'],
				"nom" => utf8_encode($r['nom']),
				"description_courte" => utf8_encode($r['description_courte']),
				"last_edit" => utf8_encode($r['last_edit']),
				"is_active" => utf8_encode($r['is_active']),
				"facebook" => utf8_encode($r['facebook']),
				"twitter" => utf8_encode($r['twitter']),
				"googleplus" => utf8_encode($r['googleplus'])
			);
		$retour["nb_elt"]++;
	}
	return $retour;
}
?>
