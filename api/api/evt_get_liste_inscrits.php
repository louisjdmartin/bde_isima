<?php
/*
	evt_get_liste_inscrits.php

	ENTREE
		token
		id_evt: id de l'événement pour lequel on veut connaitre la liste
		order: si vide, par ordre alphabetique sinon "commande" pour afficher par ordre de commande
	SORTIE:
		error
		liste
	AUTORISATION:
		club
*/



$autorise = array("zz", "bde");
function evt_get_liste_inscrits($settings, $objets){
	$bdd = $objets['bdd'];

	
	$evt = $bdd->query("SELECT id_club FROM evt_evenements WHERE id='".addslashes($settings['id_evt'])."' ORDER BY date_event DESC");
	$id_club=-1;
	foreach($evt as $e)$id_club=$e['id_club'];
	
	if($id_club!=-1 AND club_autorise($id_club, $objets['user_info'])){
		$liste = array();
		$orderby = "membres.prenom";
		if(isset($settings['order']) && $settings['order']=='commande')$orderby = "evt_commandes.id";
		
		$liste_inscrit = $bdd->query("SELECT evt_commandes . * , membres.nom, membres.prenom, membres.surnom, evt_articles.nom AS nom_article
										FROM  `evt_commandes` , membres, evt_articles
										WHERE evt_commandes.id_membre = membres.id
										AND evt_commandes.id_article = evt_articles.id
										AND id_event =".$settings['id_evt']." ORDER BY ".$orderby);
		
		foreach($liste_inscrit as $l){
			$liste[] = array(
				"id" => $l['id'],
				"id_membre" => $l['id_membre'],
				"paiement" => $l['paiement'],
				"qte" => $l['qte'],
				"qte_paye" => $l['qte_paye'],
				"nom_membre" => utf8_encode($l['nom_membre']),
				"nom_article" => utf8_encode($l['nom_article']),
				"commentaire" => utf8_encode($l['commentaire']),
				"nom" => utf8_encode($l['nom']),
				"prenom" => utf8_encode($l['prenom']),
				"surnom" => utf8_encode($l['surnom'])
			);
		}
		
		
	}
	
	
	
	return array("error" => 0, "liste" => $liste);
}
?>
