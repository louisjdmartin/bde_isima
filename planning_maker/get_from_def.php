<?php include "inc/bdd.php";
	$bdd->query("TRUNCATE TABLE planning_temp");
	$p=$bdd->query("SELECT * FROM planning_def");
	foreach ($p as $s)
	{
		$bdd->query("INSERT INTO planning_temp VALUES (NULL, ".$s['c_id'].", ".$s['m_id'].", ".$s['m2_id'].")");
	}
	header("location:./affiche_temp.php");
