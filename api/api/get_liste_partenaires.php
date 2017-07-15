<?php
/*
	get_liste_partenaires.php
	Retourne la liste des partenaires
	ENTREE:
		aucune ou id si on veut qu'un seul partenaire
		
	SORTIES:
		Tableau ou chaque entrée contient
		id, img, nom, description
		
	AUTORISATION:
		all
*/

function get_liste_partenaires($settings, $objets){
	/*
		Script
		$objets['bdd']
	*/
	$base = $objets['bdd'];
	$request = $base->query("SELECT * FROM partenaires ORDER BY id");
	if(isset($settings['id']) && is_numeric($settings['id']))$request = $base->query("SELECT * FROM partenaires WHERE id=".$settings['id']);
	$retour = array("error" => 0);
	$retour["nb_elt"] = 0;
	foreach ($request as $r)
	{
		$retour['liste'][] = array(
				"id" => $r['id'],
				"img" => $r['img'],
				"nom" => utf8_encode($r['nom']),
				"description" => utf8_encode($r['description'])
			);
		$retour["nb_elt"]++;
	}
	return $retour;
}
?>
