<?php
ini_set("display_errors", "1");

try{
        $bdd = new PDO('mysql:host=localhost;dbname=bde', 'isidroid', 'uedtmCBTL_B6');
}catch(Exception $e){
        //différents codes de retour suivant l'erreur (-9997 : pas de paramètre numCarte, -9998 : erreur de connexion à la bdd, -9999 : carte inexistante)
        $retour['solde']=-9998;
}

if(isset($_GET['numCarte'])){
        $table = $bdd->prepare('SELECT solde, nom, prenom, surnom FROM membres WHERE numero=?'); 
        $table->execute(array($_GET['numCarte'])); 
        $tupleSolde = $table->fetch();
        if(!isset($tupleSolde['solde'])){
                $retour['solde']=-9999;
        }else{
                $retour['solde']=$tupleSolde['solde'];
                $retour['surnom']=utf8_encode($tupleSolde['surnom']);
                $retour['prenom']=utf8_encode($tupleSolde['prenom']);
                $retour['nom']=utf8_encode($tupleSolde['nom']);
        }
}else{
        $retour['solde']=-9997;
}

echo json_encode($retour);

// fermer proprement la connexion à la base sauf si parametre pour connexion live
//d'après la documentation php : http://php.net/manual/en/pdo.connections.php
$table=null;
$bdd = null;
?>