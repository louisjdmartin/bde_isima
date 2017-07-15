<?php


$bdd = new PDO('mysql:host=localhost;dbname=bde', 'isidroid', 'uedtmCBTL_B6', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

try{
	$bdd = new PDO('mysql:host=localhost;dbname=bde', 'isidroid', 'uedtmCBTL_B6');
}catch(Exception $e){
	die('Erreur lors de la connection à la base de données');
}

$table = $bdd->prepare('SELECT solde FROM bde WHERE numero=?');
$table->execute(array($_POST['numCarte']);

$tupleSolde->fetch();
$solde=$tupleSolde['solde'];

echo json_encode($solde);

?>
