<?php
	include "inc/bdd.php";
	$bdd->query("TRUNCATE TABLE planning_def");
	$p=$bdd->query("SELECT * FROM planning_temp");
	foreach ($p as $s)
	{
		$bdd->query("INSERT INTO planning_def VALUES (NULL, ".$s['c_id'].", ".$s['m_id'].", '".$s['m2_id']."')");
	}
	header("location:./voir_planning.php");
