<?php
	session_start();
	include("../api/api.php");
	$bdd->query("DELETE FROM token WHERE token=".addslashes($_SESSION['token']));
	session_destroy();
	setcookie("token", "", 0, "/", null, false, true);
	header("location:..");
?>
