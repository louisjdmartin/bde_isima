<?php
/*
  statistiques_campagnes.php
  
  ENTREE
      rien
  SORTIE
      nb_elt = 0 si hors campagnes
      liste[nom_listeux, recharges, consos]
  AUTORISATION:
      bde
*/
$autorise = array("zz", "bde");
function statistiques_campagnes($settings, $objets){
  $bdd = $objets['bdd'];
  $listeux = $bdd->query("SELECT id, nom, prenom FROM membres WHERE grade=3");
  $retour['nb_elt']=0;
  $retour['liste']=array();
  foreach($listeux as $list){
    $retour['nb_elt']++;
    $recharges = $bdd->query("SELECT SUM(montant) AS r FROM logs_solde WHERE id_membre_bde=".$list['id'])->fetch()['r'];
    $transactions = $bdd->query("SELECT COUNT(*) AS t FROM transactions WHERE id_membre_bde=".$list['id'])->fetch()['t'];
    $retour['liste'][] = array("nom_listeux" => $list['nom']." ".$list['prenom'], "recharges" => round($recharges,2), "consos" => $transactions);
  }
  return $retour;
}


