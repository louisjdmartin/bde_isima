<?php
/*
	recharge_carte.php
	Encaisse un article
	
	ENTREE:
		carte: carte d'un membre
		montant: Montant de la recharge
		token: jeton d'authentification
		
	SORTIES:
		reussi = true ou false selon echec (ou pas)
		
	AUTORISATION:
		bde
*/


function recharge_carte($settings, $objets){
	$bdd = $objets['bdd'];	
	if(isset($objets['user_info']['autorisations']['club']) and isset($settings['montant']) and isset($settings['carte']) and is_numeric($settings['montant']) and is_numeric($settings['carte']))
	{
		$settings['montant'] = str_replace("," , ".", $settings['montant']);
		$infos = $bdd->query("SELECT id, solde, mail, prenom FROM membres WHERE numero=".$settings['carte']);
		foreach($infos as $i){
			$id = $i['id'];
			$ancien_solde=$i['solde'];
			$mail = $i['mail'];
			$prenom = $i['prenom'];
			$solde = $i['solde'] + $settings['montant'];
			if($solde<0 && $ancien_solde>=0)
				send_mail($mail, "[BDE] Ton solde est devenu négatif !", "Bonjour $prenom, <br /> Ton solde sur ta carte BDE est désormais négatif, il est actuellement de <strong style='color:red'>$solde euros</strong>, il te faut donc recharger ta carte, si tu ne le fais pas, le BDE se réserve le droit de ne plus te servir.<br />Rester dans le négatif est une perte d'argent pour le BDE qui ne peut plus investir dans du nouveau matériel ou subventionner des clubs ou des événements.<br /><br />Merci pour ta compréhension, à bientôt !<br />");
		}
		$bdd->query("UPDATE membres SET solde = '$solde' WHERE id=".$id);
		$bdd->query("INSERT INTO logs_solde VALUES (NULL, '".$objets['user_info']['uti_id']."','".$id."','".addslashes($settings['montant'])."', CURRENT_TIMESTAMP)");
		
		return array("reussi" => true, "solde" => $solde);
	}
	else return array("reussi" => false);
	
	
	return $retour;
}
?>
