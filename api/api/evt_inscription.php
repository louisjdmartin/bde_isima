<?php
/*
	evt_inscription.php

	ENTREE
		token : token d'identification
		id_evt: id de l'événement pour lequel on s'inscrit
		bde: 1 si on paye par carte
		liste : liste contenant dans chaque élément 1 commande:
			liste[i] contient:
				liste[i][art_id]		
				liste[i][qte]		
				liste[i][commentaire]	
		other: 1 si on veut commander pour quelqu'un d'autre [BDE & CLUB seulement]
		si other = 1 ET membre club ou BDE alors ajouter la valeur other_name
	SORTIE:
		Retourne error à 1 ou 0
		Si un seul élément de la liste contient une erreur, toute l'inscription est non valide.		

	AUTORISATION:
		zz
*/



$autorise = array("zz", "bde");
function evt_inscription($settings, $objets){
	$bdd = $objets['bdd'];

	$err = false;
	$err_msg = "";

	// ================ ETAPE 1 VERIFICATION DES DONNEES ================
	
	if(!isset($settings['liste']))
	{
		$err = true;
		$err_msg .= "Vous devez commander au moins 1 article\n";
	}
	
	// Vérification authentification
	if($objets['user_info']['uti_id']==NULL)
	{
		$err = true;
		$err_msg .= "Impossible de vous identifier, vérifiez le token passé en paramètre\n";
	}

	// Vérification droits
	if($settings['other'] == '1' && !isset($objets['user_info']['autorisations']['club']))
	{
		$err = true;
		$err_msg .= "Vous devez être BDE ou un club pour inscrire quelqu'un d'autre !\n";	
	}else if ($settings['other'] == '1' && $settings['bde'] == '1'){
		$err = true;
		$err_msg .= "Vous ne pouvez pas encaisser par carte BDE si vous enregistrez quelqu'un d'autre\n";		
	}
	if($settings['other'] == '2' && !isset($objets['user_info']['autorisations']['club']))
	{
		$err = true;
		$err_msg .= "Vous devez être BDE ou un club pour inscrire quelqu'un d'autre !\n";
	
	}else if ($settings['other'] == '2' && !is_numeric($settings['other_name'])){
		$err = true;
		$err_msg .= "Le numéro de carte doit être un nombre\n";		
	}if ($settings['other'] == '2' && is_numeric($settings['other_name'])){
		$objets['user_info']['uti_id'] = $bdd->query("SELECT id FROM membres WHERE numero=".$settings['other_name'])->fetch()['id'];	
	}
	
	if(empty($settings['other_name']) && $settings['other'] == '1' && isset($objets['user_info']['autorisations']['club']))
	{
		$err = true;
		$err_msg .= "Vous devez saisir le nom de la personne que vous inscrivez\n";	
	}
	// Vérification inscription possible
	if(!is_numeric($settings['id_evt'])){
		$err = true;
		$err_msg .= "L'id de l'événement doit être numérique\n";
	}	
	else{
		$evt = $bdd->query("SELECT * FROM evt_evenements WHERE id=".$settings['id_evt']);
		$err_evt = true;
		foreach($evt as $e){
			$err_evt = false;
			if(time() > strtotime($e['date_limite_commande']))
			{
				$err = true;
				$err_msg .= "Date limite d'inscription passé\n";		
			}
			if($e['carte_bde_possible'] == '0' && $settings['bde'] == '1'){
				$err = true;
				$err_msg .= "Vous ne pouvez pas payer par carte BDE\n";			
			}
		}
		if($err_evt){
			$err = true;
			$err_msg.= "Impossible de trouver l'événement\n";
		}
	}


	if($err){
		return array("error" => 1, "error_msg" => $err_msg);
	}

	$total = 0;
	$qte_totale = 0;

	// Vérification liste envoyé
	foreach($settings['liste'] as $courant)
	{
		if(!is_numeric($courant['art_id'])){
			$err = true;
			$err_msg .= "Les numéros d'articles doivent être numériques !\n";
		}
		elseif(!is_numeric($courant['qte']) || $courant['qte']<1 || !ctype_digit($courant['qte'])){
			$err = true;
			$err_msg .= "La valeur de la quantité n'est pas correcte\n";	
		}
		else 
		{
			$art = $bdd->query("SELECT * FROM evt_listearticles, evt_articles WHERE id_event=".$settings['id_evt']." AND id_article=".$courant['art_id']." AND id=".$courant['art_id']);
			$err_art = true;
			foreach($art as $a){
				$err_art = false;
				$total += $courant['qte'] * $a['prix'];
				$qte_totale += $courant['qte'];
				$dispo = $a['qte_dispo'];
				if($dispo == 0){ /*Qté infini disponible*/
					$dispo=1000;
				}
				else {$commandes = $bdd->query("SELECT SUM(qte) AS qte_achete FROM evt_commandes WHERE id_article = '".$courant['art_id']."'");
		
					foreach($commandes as $c)$dispo -= $c['qte_achete'];
		
					if($dispo < $courant['qte']){
						$err = true;
						$err_msg .= "L'article n'est plus disponible\n";
					}
				}

			}
			if($err_art){
				$err = true;
				$err_msg .= "Cet article n'existe pas !\n";
			}
		}

	}

	// Vérification assez de places restante
	$places = $bdd->query("SELECT nb_places_max FROM evt_evenements WHERE id=".$settings['id_evt']);
	foreach($places as $p){
		if($p['nb_places_max']>0){
			$utilise = $bdd->query("SELECT SUM(qte) AS total FROM evt_commandes	WHERE id_event=".$settings['id_evt']);
			foreach($utilise as $u){
				if(!is_numeric($u['total']))$total_qte = 0;
				else $total_qte = $u['total'];
				if($p['nb_places_max']-$total_qte < $qte_totale){
					$err = true;
					$err_msg .= "Il n'y a pas assez de places restantes\n";
				}			
			}
		}
	}

	// Vérification aucune commande déjà passé
	if($settings['other'] != "1"){
	  $commandes = $bdd->query("SELECT id FROM evt_commandes WHERE nom_membre LIKE '' AND id_event=".$settings['id_evt']." AND id_membre=".$objets['user_info']['uti_id']." LIMIT 1");
		foreach($commandes as $a){
			$err = true;
			$err_msg.= "Vous avez déjà commandé, annulez la commande avant de passer une nouvelle commande\n";
		}	
	}
	// Vérification du solde BDE si on paye par carte
	if($settings['bde'] == '1'){
		$solde = $bdd->query("SELECT solde FROM membres WHERE id=".$objets['user_info']['uti_id']);
		foreach($solde as $s){
			if($s['solde']<$total){
				$err = true;
				$err_msg .= "Solde BDE insuffisant !\n";
			}
		}
	}else $settings['bde'] = '0';

	if($err)return array("error" => "1", "error_msg" => $err_msg);
	// ================ ETAPE 2 ENREGISTREMENT DES COMMANDES ================
	else foreach($settings['liste'] as $courant){

		$other_name = "";
		if($settings['other']=='1')$other_name = $settings['other_name'];

		$bdd->query("INSERT INTO evt_commandes VALUES(
			NULL,
			".$settings['id_evt'].",
			".$objets['user_info']['uti_id'].",
			'".utf8_decode(addslashes($other_name))."',	
			".$courant['art_id'].",
			".$settings['bde'].",
			".$courant['qte'].",
			0, 
			'".utf8_decode(addslashes($courant['commentaire']))."'
		)");
	}
	
	return array("error" => 0);
	
}
?>
