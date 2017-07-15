<?php
/*
	encaisser_article.php
	Encaisse un article
	
	ENTREE:
		carte: carte d'un membre
		id_article: article a encaisser
		token: jeton d'authentification
		
	SORTIES:
		reussi = true ou false selon echec (ou pas)
		
	AUTORISATION:
		bde
*/


function encaisser_article($settings, $objets){
	$bdd = $objets['bdd'];	
	if(isset($objets['user_info']['autorisations']['bde']) and isset($settings['id_article']) and isset($settings['carte']) and is_numeric($settings['id_article']) and is_numeric($settings['carte']))
	{
		$infos = $bdd->query("SELECT id, solde, mail, prenom FROM membres WHERE numero=".$settings['carte']);
		foreach($infos as $i){
			$id = $i['id'];
			$ancien_solde = $i['solde'];
			$mail = $i['mail'];
			$prenom = $i['prenom'];
		}
		$infos_art = $bdd->query("SELECT tarif, nom FROM articles WHERE id=".addslashes($settings['id_article']));
		foreach($infos_art as $i){
			$solde = $ancien_solde - $i['tarif'];
			$tarif = $i['tarif'];
			$nom = utf8_encode($i['nom']);
			if($solde<0 && $ancien_solde>=0)
				send_mail($mail, "[BDE] Ton solde est devenu négatif !", "Bonjour $prenom, <br /> Suite à l'achat de <em>$nom</em> ton solde sur ta carte BDE est désormais négatif, il est actuellement de <strong style='color:red'>$solde euros</strong>, il te faut donc recharger ta carte, si tu ne le fais pas, le BDE se réserve le droit de ne plus te servir.<br />Rester dans le négatif est une perte d'argent pour le BDE qui ne peut plus investir dans du nouveau matériel ou subventionner des clubs ou des événements.<br /><br />Merci pour ta comprehension, à bientôt !<br />");
		}
		$bdd->query("INSERT INTO transactions VALUES (NULL, '".$objets['user_info']['uti_id']."','".$id."','".addslashes($settings['id_article'])."', CURRENT_TIMESTAMP, '".$ancien_solde."')");
		$bdd->query("UPDATE membres SET solde = '$solde' WHERE id=".$id);
		
		return array("reussi" => true, "nom" => $nom, "tarif" => $tarif, "ancien_solde" => $ancien_solde, "solde" => $solde);
	}
	else return array("reussi" => false);
	
	
	return $retour;
}
?>
