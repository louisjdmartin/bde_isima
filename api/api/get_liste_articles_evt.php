<?php
/*
	get_liste_articles_evt.php

	ENTREE
		id_event
					
	SORTIE:
		tout
	AUTORISATION:
		all
*/



$autorise = array("zz", "bde");
function get_liste_articles_evt($settings, $objets){
	$bdd = $objets['bdd'];
	
	if(!isset($settings['id_event']))return array("error" => 1);
	
	$liste = $bdd->query("
		SELECT * FROM evt_listearticles, evt_articles 
		WHERE 
		evt_listearticles.id_event = '".addslashes($settings['id_event'])."'
		AND evt_listearticles.id_article = evt_articles.id
	");
		
	$retour = array();
	$retour["nb_elt"]=0;
	foreach ($liste as $r)
	{
		$dispo = $r['qte_dispo'];
		if($dispo == 0){ /*Qté infini disponible*/
			$dispo="infini";
			$r['qte_dispo']="infini";
		}
		else 
		{
			$commandes = $bdd->query("SELECT SUM(qte) AS qte_achete FROM evt_commandes WHERE id_article = '".$r['id']."' AND id_event = '".addslashes($settings['id_event'])."'");
		
			foreach($commandes as $c)$dispo -= $c['qte_achete'];
		}		
		$retour['liste'][] = array(
			"id" => $r['id'],
			"qte_max" => $r['qte_dispo'],
			"qte_dispo" => $dispo,
			"nom" => utf8_encode($r['nom']),
			"prix" => utf8_encode($r['prix'])
		);
		$retour["nb_elt"]++;
	}
	return $retour;
}
?>
