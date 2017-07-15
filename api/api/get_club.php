<?php
/*
	get_club.php
	Retourne toutes les infos des clubs
	
	ENTREE:
		id: id du club dont on veut les infos

	SORTIES:
		toutes les infos sur les clubs
		
	AUTORISATION:
		all
*/


function get_club($settings, $objets){
	/*
		Script
	*/
	$retour = array("error" => 1, "error_msg" => "Le paramètre 'id' n'est pas numérique !");
	if(is_numeric($settings['id']))
	{
		$base = $objets['bdd'];
		$request = $base->query("SELECT * FROM clubs WHERE id=".$settings['id']);
		$retour = array("error" => 0);
		$retour["nb_elt"] = 0;
		foreach ($request as $r)
		{
			$retour['liste'][] = array(
				"id" => $r['id'],
				"id_gerant" => $r['id_gerant'],
				"img" => $r['img'],
				"nom" => utf8_encode($r['nom']),
				"description_courte" => utf8_encode($r['description_courte']),
				"presentation" => utf8_encode($r['presentation']),
				"last_edit" => utf8_encode($r['last_edit']),
				"is_active" => utf8_encode($r['is_active']),
				"facebook" => utf8_encode($r['facebook']),
				"twitter" => utf8_encode($r['twitter']),
				"googleplus" => utf8_encode($r['googleplus'])
			);
			$retour["nb_elt"]++;
		}
	}
	return $retour;
}
?>
