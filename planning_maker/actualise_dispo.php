<?php
	include "inc/bdd.php";
	if(empty($_POST['id'])) die();
	$bdd->query("DELETE FROM dispos WHERE m_id=".$_POST['id']);
	$creneaux = $bdd->query("SELECT c_id FROM creneaux");
	foreach($creneaux as $c)
	{
		if(isset($_POST['dispo_'.$c['c_id']]) AND $_POST['dispo_'.$c['c_id']]=='on')
			$bdd->query("INSERT INTO dispos VALUES (NULL, ".$c['c_id'].", ".$_POST['id']." )");
	}
	$bdd->query("UPDATE membres SET last_modif = NOW() WHERE m_id = '".$_POST['id']."'");
	header("location:genere_planning.php");
?>
