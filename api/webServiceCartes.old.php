<?php
ini_set("display_errors", "1");
// il y a une ligne de connexion en trop
//$bdd = new PDO('mysql:host=bouscatel.isima.fr;dbname=bde', 'isidroid', 'uedtmCBTL_B6', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

try{
	$bdd = new PDO('mysql:host=localhost;dbname=bde', 'isidroid', 'uedtmCBTL_B6'); // Appel => Localhost BDD => bde
}catch(Exception $e){
	//die('Erreur lors de la connexion à la base de données');
	//différents codes de retour suivant l'erreur (-9997 : pas de paramètre numCarte, -9998 : erreur de connexion à la bdd, -9999 : carte inexistante)
	$retour['solde']=-9998;
}

// $_GET me semble pas mal aussi => plus performant que le POST
// ce serait cool de verifier que numCarte est fourni isset() empty()
// pour eviter de faire une requete
if(isset($_GET['numCarte'])){
	$table = $bdd->prepare('SELECT solde, nom, prenom, surnom FROM membres WHERE numero=?'); // Table => membres
	$table->execute(array($_GET['numCarte'])); // => Manque parenthèse
	$tupleSolde = $table->fetch();// $tupleSolde->fetch();
	if(!isset($tupleSolde['solde'])){
		$retour['solde']=-9999;
	}else{
		$retour['solde']=$tupleSolde['solde'];
		if($tupleSolde['surnom']==NULL){ //Si l'utilisateur n'a pas de surnom
			$retour['personne']=utf8_encode($tupleSolde['prenom']) . " " . utf8_encode($tupleSolde['nom']);
		}else{
			$retour['personne']=utf8_encode($tupleSolde['surnom']);
		}
	}
}else{
	$retour['solde']=-9997;
}

// je mettrai un montant négatif en cas d'erreur
echo json_encode($retour);

// fermer proprement la connexion à la base sauf si parametre pour connexion live
//d'après la documentation php : http://php.net/manual/en/pdo.connections.php
$table=null;
$bdd = null;
?>
