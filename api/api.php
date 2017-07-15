<?php
/*
	API BDE
	Fonctionnement:
		Appel d'un fonction via php:
			api("nom_de_la_fonction", $settings);
			$settings contient les paramètres
		
		Appel d'une fonction via HTTP:
			Appeller le fichier /ajax/nom_de_la_fonction
			Passer en GET ou POST tout les paramètres
			Retourne au format JSON
*/

// ini_set("display_errors" , "1");


	global $bdd;	
        require dirname(__FILE__) ."/config.conf.php";
	$bdd = new PDO(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);	
		
	// $bdd = new PDO('mysql:host=localhost;dbname=bdd_bde', 'root', '');		
	include "fonctions.php";
	if(isset($_COOKIE['token'])) $_SESSION['token'] = $_COOKIE['token'];
	function authentification($token){
		global $bdd;
		$bdd->query("DELETE FROM token WHERE expiration<".time());
		$auth = $bdd->query ('SELECT grade, id, numero, nom, prenom, surnom, mail, expiration FROM membres JOIN token WHERE token.account=membres.id AND token.token = "'.addslashes($token).'"');
		$retour = array(
			"autorisations" => NULL,
			"uti_id" => NULL,
			"carte" => NULL,
			"nom" => NULL,
			"prenom" => NULL,
			"surnom" => NULL,
			"expiration" => NULL
		);
		
		foreach ($auth as $a)
		{
			$retour['autorisations'] = array("ZZ" => "ZZ");
			if($a['grade']>0)$retour['autorisations']['club'] = "club";
			if($a['grade']>1)$retour['autorisations']['bde'] = "bde";
			$retour['uti_id']	= $a['id'];
			$retour['carte'] 	= $a['numero'];
			$retour['nom'] 		= utf8_encode($a['nom']);
			$retour['prenom'] 	= utf8_encode($a['prenom']);
			$retour['surnom'] 	= utf8_encode($a['surnom']);
			$retour['mail'] 	= $a['mail'];
			$retour['expiration'] 	= $a['expiration'];
		}
		
		return $retour;
	}

	function api($fonction, $settings=array()){
		global $bdd;
		
		// On récupère les infos du membre à partir du token
		if(!isset($settings['token']))$settings['token']=NULL;
		$authentification = authentification($settings['token']);
		
		// On récupère le fichier d'API necessaire
		if(is_file (dirname(__FILE__) ."/api/".$fonction.".php"))
		{
			include_once dirname(__FILE__) . "/api/".$fonction.".php";
		}
		else return array("error" => "Fonction non définie");
		
		//On génère les objets utilisables
		$objets=array(
			"bdd" => $bdd,
			"user_info" => $authentification
		);
		
		//On execute
		$retour =  $fonction($settings, $objets);
		return $retour;	
	}
	
	function ajax_api($fonction, $settings){
		return json_encode(api($fonction, $settings));
	}
	
	function club_autorise($id_club, $user_info){
		global $bdd;
		$autoriser = false;
		// Vérification des autorisations:
		// SI BDE alors autorisé
		// SI CLUB alors vérifier qu'on est le gérant
		if(isset($user_info['autorisations']['bde']))$autoriser = true;
		else if(isset($user_info['autorisations']['club']))
		{
			$rep = $bdd->query('SELECT id FROM clubs WHERE id="'.utf8_decode(addslashes($id_club)).'" AND id_gerant="'.$user_info['uti_id'].'"');
			if(count($rep))$autoriser = true;
		}
		return $autoriser;
	}

?>
