<?php
/*
	get_liste_articles.php

	ENTREE
		numero: carte de l'utilisateur dont on veut connaitre le nom
					
	SORTIE:
		le nom de l'utilisateur
	AUTORISATION:
		all
*/



$autorise = array("zz", "bde");
function get_liste_articles($settings, $objets){
	$bdd = $objets['bdd'];
	$articles = $bdd->query("SELECT * FROM articles");
	$retour = array();
	$retour["nb_elt"]=0;
	foreach ($articles as $r)
	{
		$img = $r['img'];
		if(troll_mode($objets))$img = "../easter_eggs/cogonixkill/".rand(1,9).".jpg";
		$retour['liste'][] = array(
			"id" => $r['id'],
			"nom" => utf8_encode($r['nom']),
			"tarif" => utf8_encode($r['tarif']),
			"tarif_nc" => utf8_encode($r['tarif_non_cotisant']),
			"img" => $img
		);
		$retour["nb_elt"]++;
	}
	
	return $retour;
}
?>
