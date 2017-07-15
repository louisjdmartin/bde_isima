<?php

session_start();
include_once dirname(__FILE__) . "/../../api/api.php";
if(isset($_COOKIE['token'])) $_SESSION['token'] = $_COOKIE['token'];
if(!isset($_SESSION['token'])){
  header("location:../?from=planning_maker#zz");
  die();
}
$user=authentification($_SESSION['token']);
include "bdd.php";
if(!isset($user['autorisations']['bde'])){header("location:../?from=planning_maker#zz");}

	$jours = array("Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche");
	function select($name, $liste, $default = 0){
		$i=0;
		echo "<select name='".$name."'>";
		foreach($liste as $l)
		{
			$d = "";
			if($default == $i)$d="selected";
			echo "<option value=".$i." $d>".$l."</option>";
			$i++;
		}
		echo "</select>";
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf8" />
		<title>Planning Maker</title>
		<meta name="viewport" content="initial-scale=1.0 maximum-scale=1.0" >
		<style>
			a{color:black;text-decoration:none;}
			a.menu
			{
				color:blue;
				display:inline-block;
				margin:8px;
				padding:4px 16px;
				border-radius:3px;
				text-decoration:none;
				transition:.3s;
			}
			a.menu:hover
			{
				box-shadow:1px 1px 5px grey;
				background-color:#DDD;
				cursor:pointer;
			}
			table
			{
				box-shadow:2px 2px 5px black;
				margin-bottom:16px;
				padding:4px;
				font-size:.9em;
			}
			label
			{
				display:inline-block;
				width:150px;
			}
		</style>
		<script>
			function cocher(etat) {
			  var inputs = document.getElementById('form_coche').getElementsByTagName('input');
			  for(i = 0; i < inputs.length; i++) {
				if(inputs[i].type == 'checkbox')
				  inputs[i].checked = etat;
			  }
			}
		</script>
	</head><body>
	<a class="menu" href="http://bde-dev.isima.fr/espace_ZZ">Retour site</a>
	<a class="menu" href="creneaux.php">Gestion des créneaux</a>
	<a class="menu" href="membres.php">Gestion des membres</a>
	<a class="menu" href="dispos.php">Gestion des dispos</a>
	<a class="menu" href="affiche_temp.php">Voir le planning temporaire</a>
	<a class="menu" href="voir_planning.php">Voir le planning definitif</a>
	<a class="menu" href="todo.php">Prochaine MaJ</a>
	<a class="menu" href="algo.php">Algo</a>
	<br />
	
