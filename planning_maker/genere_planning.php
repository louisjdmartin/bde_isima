<?php
	ini_set("display_errors", 1);
	include 'inc/bdd.php';
	function compter_perm($id, $bdd){
		$a = $bdd->query("SELECT p_id, c_poids FROM planning_temp, creneaux WHERE (m_id=".$id." OR m2_id=".$id.") AND planning_temp.c_id=creneaux.c_id");
		$i=0;
		foreach($a as $b)$i+=$b['c_poids'];
		return $i;
	}
	function min_perm($liste_membres, $bdd)
	{
		reset($liste_membres);
		$min = current($liste_membres);
		$nb_min_perm = compter_perm($min, $bdd);
		foreach($liste_membres as $mb)
		{
			$perms=compter_perm($mb, $bdd);
			if($perms<$nb_min_perm){
				$min=$mb;
				$nb_min_perm=$perms;
			}
		}
		return $min;
	}
	$bdd->query("TRUNCATE TABLE planning_temp");
	$creneaux = $bdd->query("SELECT c_id FROM creneaux ORDER BY c_poids DESC");
	foreach($creneaux as $c)
	{
		$liste_membres = array();
		$membres_dispo = $bdd->query("SELECT m_id FROM dispos WHERE c_id=".$c['c_id']." ORDER BY RAND()");
		foreach($membres_dispo as $mb){
			$liste_membres[] = $mb['m_id'];
		}
		$member1 = min_perm($liste_membres, $bdd);
		$liste_membres = array_diff($liste_membres, array($member1));
		if(count($liste_membres))
			$member2 = min_perm($liste_membres, $bdd);
		else
			$member2 = "NULL";
		$bdd->query("INSERT INTO planning_temp VALUES (NULL, ".$c['c_id'].", ".$member1.", ".$member2.")");
	}
	header('location:affiche_temp.php');
?>
