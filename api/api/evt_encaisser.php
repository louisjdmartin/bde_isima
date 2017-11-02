<?php
/*
	evt_encaisser.php

	ENTREE
		token
		mode = liquide/carte/event
			liquide => ajouter qte, id_cmd
			bde => ajouter id_cmd, carte
			event => ajouter id_evt
	SORTIE:
		error
	AUTORISATION:
		club
*/



$autorise = array("zz", "bde");
function evt_encaisser($settings, $objets){
	$bdd = $objets['bdd'];
	if(!isset($objets['user_info']['autorisations']['club']))return array("error" => 1, "error_msg" => "Accès refusé");

	if($settings['mode'] == "liquide"){
		$qte_bdd = $bdd->query("SELECT qte_paye FROM evt_commandes WHERE id=".$settings['id_cmd']);
		foreach($qte_bdd as $q)
		{
			$qte = intval($q['qte_paye']) + $settings['qte'];
			$bdd->query('UPDATE evt_commandes SET qte_paye='.$qte.' WHERE id='.$settings['id_cmd']);
		}
		return array("error" => 0);
	}else if($settings['mode'] == 'bde'){
		$qte_bdd = $bdd->query("SELECT qte_paye, qte, id_article, id_event FROM evt_commandes WHERE id=".$settings['id_cmd']);
		foreach($qte_bdd as $q)
		{
			$qte = intval($q['qte']) - intval($q['qte_paye']);
			$bdd->query('UPDATE evt_commandes SET qte_paye='.intval($q['qte']).' WHERE id='.$settings['id_cmd']);
			echo $qte;
			$prix_bdd = $bdd->query("SELECT prix FROM evt_articles WHERE id=".intval($q['id_article']));
			foreach($prix_bdd as $p){
				api("recharge_carte", array(
					"carte" => $settings['carte'],
					"montant" => -1 * $qte * floatval($p['prix']),
					"token" => $settings['token']
				));
				$total_bde = $bdd->query("SELECT total_gain_carte FROM evt_evenements WHERE id=".$q['id_event']);
				$total_bde = $total_bde->fetch();
				$total_gains = floatval($total_bde['total_gain_carte']) + $qte * floatval($p['prix']); 
				$bdd->query("UPDATE evt_evenements SET total_gain_carte='".$total_gains."' WHERE id=".$q['id_event']);
			}	
			
		}
		return array("error" => 0); 
	}else if($settings['mode'] == 'event'){
		$liste = $bdd->query("SELECT evt_commandes.id_membre, membres.numero, evt_commandes.id FROM evt_commandes, membres WHERE evt_commandes.paiement = 1 AND evt_commandes.id_membre = membres.id AND id_event = ".$settings['id_evt']);
		foreach($liste as $l){
		  api("evt_encaisser", array("token" => $settings['token'], 'mode'=> 'bde', 'id_cmd' => $l['id'], 'carte' => $l['numero']));
		}
	}


}
