<?php
/*
	get_news.php
	Retourne les dernières news
	
	ENTREE:
		debut, nombre = Fonctionnent comme "LIMIT debut, nombre" en SQL
		Si aucune entrée OU entrées non numériques: la requête SQL utilisera LIMIT 0,5
		
	SORTIES:
		Liste d'actualitées
		
	AUTORISATION:
		all
*/


function get_news($settings, $objets){
	$bdd = $objets['bdd'];
	$debut = 0;
	$nombre= 5;
	if(isset($settings['debut']) && is_numeric($settings['debut']))$debut = $settings['debut'];
	if(isset($settings['nombre']) && is_numeric($settings['nombre']))$nombre = $settings['nombre'];
	
	$news = $bdd->query("SELECT * FROM accueil_articles ORDER BY id DESC LIMIT $debut,$nombre");
	if(isset($settings['id'])) $news = $bdd->query("SELECT * FROM accueil_articles WHERE id=".addslashes($settings['id']));
	$retour = array();
	$retour["nb_elt"]=0;
	foreach ($news as $r)
	{
		$retour['liste'][] = array(
			"id" => $r['id'],
			"titre" => utf8_encode($r['titre']),
			"texte" => utf8_encode($r['texte']),
			"img" => $r['img']
		);
		$retour["nb_elt"]++;
	}
	return $retour;
}
?>
