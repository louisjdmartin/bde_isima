<?php
require '../../../api/api.php';
$liste = api("evt_get_liste_inscrits", array("token" => $_GET['token'], "id_evt" => $_GET['id']));
echo "<body onload='window.print()'><meta charset='utf-8'>
<style>tr,td,table{border-collapse:collapse;border:1px solid black; padding:16px;}</style>
<table style='width:100%'> <tr>
                        <td>#</td>
                        <td>Nom</td>
                        <td>Article</td>
                        <td>Qte</td>
                        <td>Qte payé</td>
                        <td>Paiement</td>
                        <td>Commentaires</td>
                        <td>Notes</td>
                </tr>";
foreach($liste['liste'] as $l){
  if(!empty($l['nom_membre']))$nom = $l['nom_membre'];
  else $nom = $l['prenom']." ".$l['nom'];


                echo "<tr>
                        <td>".$l['id']."</td>
                        <td>".$nom."</td>
                        <td>".$l['nom_article']."</td>
                        <td>".$l['qte']."</td>
                        <td>".$l['qte_paye']."</td>
                        <td>".($l['paiement']=="1" ? "Carte BDE":"&nbsp;")."</td>
                        <td>".$l['commentaire']."</td>
                        <td>&nbsp;</td>
                </tr>
                ";

}
