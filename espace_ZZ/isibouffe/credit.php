<?php

require 'fonctions.php';

//POUR CREDITER UN ZZ




//calcul nouveau solde

$info_zz = $donnees->query('SELECT * FROM isibouffe_zz WHERE id='.addslashes($_GET['id_zz'])); //addslashes empêche les injections SQL

$info3 = $info_zz->fetch();

$nouveau_solde = $info3['solde']+$_GET['ajout'];



//mise à jour nouveau solde


$donnees->query('UPDATE isibouffe_zz SET solde = '.$nouveau_solde.' WHERE id='.addslashes($_GET['id_zz']));






//ajout d'une ligne dans l'historique

$donnees->query('INSERT INTO isibouffe_hist_recharges (id_zz,recharge) VALUES ("'.$_GET['id_zz'].'","'.$_GET['ajout'].'")');






$info_zz->closeCursor();

header("location:rechercher_zz.php?success=-1&solde=".$nouveau_solde);

?>
