<?php
/*
	change_passwd.php

	ENTREE
		mail: mail associé au compte
		mode: genere-token, change_passwd
			=> genere-token envoie le mail de reinitialisation
			=> change_passwd change le mot de passe, necessite d'ajouter 
		Si mode=change_passwd:
			token: jeton de reinitialisation du mot de passe ou mot de passe actuel du compte
			pwd: nouveau mot de passe
			clear_all_token: si true alors efface toutes les sessions actives
		
	SORTIE:
		error: permet de savoir si reussi ou non
		
	AUTORISATION:
		all
*/
$autorise = array("all");
function change_passwd($settings, $objets){
	$bdd = $objets['bdd'];
	if(!isset($settings['mode']))return array("error" => 1, "error_msg" => "mode manquant !");
	if($settings['mode']=='genere-token' and isset($settings['mail']))
	{
		$token = "pwd_change_".uniqid();
		$cond = "mail = '".addslashes($settings['mail'])."'";
		$comptes = $bdd->query("SELECT id FROM membres WHERE ".$cond);
		$expiration = time()+3600;
		foreach($comptes as $c)
		{
			$bdd->query("INSERT INTO token VALUES ('".$token."','".$c['id']."','".$expiration."')");
			
			$contenu = "
				Bonjour,<br />
				Tu as demandé à ré-initialiser ton mot de passe suite à un oubli de celui-ci, pour cela, utilise le lien ci-dessous (valable 1h).<br />
				<a href='http://".$_SERVER['HTTP_HOST']."/espace_ZZ/?token=".$token."&from=change_pwd'>".$_SERVER['HTTP_HOST']."/espace_ZZ/?token=".$token."&from=change_pwd</a><br /><br />
			";
			send_mail($settings['mail'], "[BDE] Mot de passe oublié", $contenu);
			
			return array("error" => 0);
		}
		return array("error" => 1, "error_msg" => "Aucun compte trouvé");
	}
	if($settings['mode']=='change_passwd' and isset($settings['pwd'])){
		$valide = false;
		if(substr($settings['token'],0,11)=='pwd_change_'){
			$token = $bdd->query("SELECT account FROM token WHERE token='".addslashes($settings['token'])."'");
			foreach($token as $t){
				$valide = true;
				$id = $t['account'];
			}
		}
		else{
			$cond = "mail = '".addslashes($settings['mail'])."'";
			$comptes = $bdd->query("SELECT mdp, id FROM membres WHERE ".$cond);
			foreach($comptes as $c)
			{
				if(md5($settings['token'])==$c['mdp'])
				{
					$valide = true;
					$id = $c['id'];
				}
			}
		}
		if($valide)
		{
			$bdd->query("UPDATE membres SET mdp='".md5($settings['pwd'])."' WHERE id=".$id);
			if($settings['clear_all_token']=='true')$bdd->query("DELETE FROM token WHERE account=".$id);
			return array("error" => 0);
		}
	}
	return array("error" => 1, "error_msg" => "Impossible d'effectuer l'action demandée, vérifiez les paramètres");
}