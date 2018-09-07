<?php
ini_set("display_errors", "1");
/*
	modifier_membre.php
	Modifie un membre
	
	ENTREE:
		id:		id du membre a modifier (Ou 0 pour un ajout)
		nom: 	nom du membre ou SUPPR_MEMBER
		prenom: prenom du membre
		prenom: #flemme
		surnom: #flemme
		mail: 	#flemme
		carte:	#flemme
		promo: 	#flemme
		grade: 	#flemme
		cotisation: 	#flemme
		
	SORTIES:
		Rien
		
	AUTORISATION:
		bde
*/
function modifier_membre($settings, $objets){
	$bdd = $objets['bdd'];	
	if(!isset($objets['user_info']['autorisations']['bde']))return (array("error" => 1, "msg" => 'Action refusée'));
	if($settings['id']=="0"){
		// Ajout
		$last_carte = $bdd->query("SELECT numero FROM membres ORDER BY id DESC LIMIT 1");
		foreach($last_carte as $lc)$carte = $lc['numero'];
	
		while(carte_utilise($carte))$carte++;

		
		$pass = createRandomPassword();

		
		send_mail($settings['mail'], "Création de ton compte BDE", "
			Bonjour ".$settings['prenom']." !<br />
			Suite à ta cotisation, ton compte BDE vient d'être créé, pour y accéder c'est simple, rends-toi sur <a href='http://bde.isima.fr/#zz'>bde.isima.fr</a>.
			<br />
			<br />Voici tes identifiants, pense à changer le mot de passe.
			<br /><strong>Email: </strong> ".$settings['mail']."
			<br /><strong>Mot de passe: </strong> ".$pass."
			<br /><strong>Carte:</strong> ".$carte."

			<br />Sur le site tu peux être identifié par carte ou par mail.
			<br /><em>À quoi sert ma carte ?</em>
			<br />Ta carte BDE te permet de commander au bar sans sortir ton porte-monnaie ! Rends-toi au BDE avec un petit billet, dis que tu veux recharger la carte ".$carte." et tu pourras consommer diverses friandises et boissons avec ta carte BDE, il te suffit simplement de donner ton numéro à la personne qui te sert. Attention on ne sert pas si tu n'as plus d'argent sur ta carte ! (sauf si tu payes en liquide) tu peux consulter ton solde sur le site ou le demander à un membre du BDE.<br /><br/>
		");	
		$bdd->query("INSERT INTO membres VALUES(
			NULL,
			'".utf8_decode(addslashes($settings['nom']))."',
			'".utf8_decode(addslashes($settings['prenom']))."',
			'".$carte."',
			'".md5($pass)."',
			'".addslashes($settings['mail'])."',
			'".addslashes($settings['promo'])."',
			0.0,
			0,
			".annee_scolaire().",
			NULL,".addslashes($settings['telephone'])."
		);");
		

		$retour = array("error" => 0);
	}
	else{
		// Modification
		if($settings['nom']!="SUPPR_MEMBER")
		{
			if(carte_utilise($settings['carte'], $settings['id'])){return array ("error" => 1, "msg"=>"Cette carte est déjà utilisé !");}
			$bdd->query("UPDATE membres SET nom='".utf8_decode($settings['nom'])."' WHERE id='".$settings['id']."'");
			$bdd->query("UPDATE membres SET prenom='".utf8_decode($settings['prenom'])."' WHERE id='".$settings['id']."'");
			$bdd->query("UPDATE membres SET surnom='".utf8_decode($settings['surnom'])."' WHERE id='".$settings['id']."'");
			$bdd->query("UPDATE membres SET numero='".$settings['carte']."' WHERE id='".$settings['id']."'");
			$bdd->query("UPDATE membres SET mail='".$settings['mail']."' WHERE id='".$settings['id']."'");
			$bdd->query("UPDATE membres SET promo='".$settings['promo']."' WHERE id='".$settings['id']."'");
			$bdd->query("UPDATE membres SET grade='".$settings['grade']."' WHERE id='".$settings['id']."'");
			$bdd->query("UPDATE membres SET cotisation='".$settings['cotisation']."' WHERE id='".$settings['id']."'");
			$bdd->query("UPDATE membres SET telephone='".$settings['telephone']."' WHERE id='".$settings['id']."'");
			$retour = array("error" => 0);
		}
		else
		{
			$bdd->query("DELETE FROM logs_solde WHERE id_membre='".$settings['id']."'");
			$bdd->query("DELETE FROM transactions WHERE id_personne='".$settings['id']."'");
			$bdd->query("DELETE FROM membres WHERE id='".$settings['id']."'");
			$retour = array("error" => 0);
		} 
		/*
			TODO:
				si nom == SUPPR_MEMBER effacer:
					toutes ses transactions
					toutes ses recharges
					son compte
				sinon maj le membre
		*/
	}
	
	
	return $retour;
}
?>
