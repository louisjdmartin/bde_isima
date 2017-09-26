<?php

require 'fonctions.php';



// DEBITER UN ZZ EN RENTRANT SA CONSOMMATION


//calcul prix total

$info_article = $donnees->query('SELECT * FROM isibouffe_article WHERE id_article='.addslashes($_GET['id_article'])); //addslashes empêche les injections SQL

$info2 = $info_article->fetch();


$total=$_GET['quantite']*$info2['prix_article'];

$info_article->closeCursor();



//calcul nouveau solde

$info_zz = $donnees->query('SELECT * FROM isibouffe_zz WHERE id='.addslashes($_GET['id_zz'])); //addslashes empêche les injections SQL

$info3 = $info_zz->fetch();

$nouveau_solde = $info3['solde']-$total;



//mise à jour nouveau solde


$donnees->query('UPDATE isibouffe_zz SET solde = '.$nouveau_solde.' WHERE id='.addslashes($_GET['id_zz']));






//ajout d'une ligne dans l'historique

$donnees->query('INSERT INTO isibouffe_historique (id_zz,solde,id_article,quantite) VALUES ('.$_GET['id_zz'].','.$nouveau_solde.','.$_GET['id_article'].','.$_GET['quantite'].')');






$info_zz->closeCursor();

header("location:rechercher_zz.php?id_zz=".$_GET['id_zz']);


?>



















































