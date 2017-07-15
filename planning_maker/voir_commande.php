<?php
	$bdd = new PDO('mysql:host=localhost;dbname=python', 'louis','louismartin');
?>
<!DOCYTPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Commandes | Liste BliZZard</title>
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="https://code.getmdl.io/1.2.1/material.blue-cyan.min.css" />
		<link rel="stylesheet" href="../blizzard/pizzas/style.css">
		<script defer src="https://code.getmdl.io/1.2.1/material.min.js"></script>
		
		<meta name="msapplication-TileColor" content="#0000FF"/>		
		<meta name="theme-color" content="#0000FF">		
		<meta name="viewport" content="initial-scale=1.0 maximum-scale=1.0" >

	</head>
	
	<body><div id="body">
		<img class='logo' alt="BLIZZARD" src="../blizzard/pizzas/BliZZard_small.png" />
		<header>
			<h4>Commandes</h4>
			<small><em>Pour bloquer les commandes, et empêcher qu'on en redemande depuis le site visiteur, demande moi ;-)</em></small>
		</header>
		<hr />
		
		<form id="form">
			<select name="voir" onchange="document.getElementById('form').submit()">
				<option value="nochoice">Voir les commandes pour...</option>
				<option>pizzas</option>
				<option>tartiflette</option>
				<option>blanquette</option>
			</select>
			CHOIX: <?php echo $_GET['voir']; ?>
		</form>
		
		<?php
			if($_GET['voir']=="pizzas"){
				require("../blizzard/pizzas/input.php");
				$liste = array_merge ( $liste_pizza, $liste_pizza2, $liste_pizza3);
				$pizzas = $bdd->query("SELECT * FROM pizzas ORDER BY pizza");
				$last="";
				$c=0;
				echo "<strong>Toutes les pizzas:</strong><br />";
				foreach($pizzas as $pizz)
				{
					if($last != $pizz['pizza'])
					{
						if($c!=0)echo $liste[$last].": ".$c."<br />";
						$last = $pizz['pizza'];
						$c=0;
					}
					$c++;
				}
				echo $liste[$pizz['pizza']].": ".$c."<br />";
				
				$pizzas = $bdd->query("SELECT * FROM pizzas ORDER BY nom");
				$last="";
				$c=0;
				
				echo "<strong>PIZZAS HORS SITE:</strong>
				<br />Kevin Bourgeix carte 620 et 18: Signature Raclette
				
				";
				echo '<hr /><table style="width:100%" class="mdl-data-table mdl-js-data-table"><thead><th class="mdl-data-table__cell--non-numeric">Nom</th><th class="mdl-data-table__cell--non-numeric">Pizza</th><th class="mdl-data-table__cell--non-numeric">Paiement</th><th class="mdl-data-table__cell--non-numeric">Carte</th></thead>';
				foreach($pizzas as $pizz)
				{
					echo "<tr><td class='mdl-data-table__cell--non-numeric'>".htmlentities($pizz["nom"])."</td><td class='mdl-data-table__cell--non-numeric'>".$liste[$pizz["pizza"]]."</td><td class='mdl-data-table__cell--non-numeric'>".$pizz["payment"]."</td><td class='mdl-data-table__cell--non-numeric'>".$pizz["carte"]."</td></tr>";
				}
				echo "</table>";
			}
			if($_GET['voir']=="tartiflette"){
				$pizzas = $bdd->query("SELECT * FROM tartiflette ORDER BY nom");
				echo '<table style="width:100%" class="mdl-data-table mdl-js-data-table"><thead><th class="mdl-data-table__cell--non-numeric">Nom</th></thead>';
				$c=0;
				foreach($pizzas as $pizz)
				{
					echo "<tr><td class='mdl-data-table__cell--non-numeric'>".htmlentities($pizz["nom"])."</td></tr>";
					$c++;
				}
				echo "</table>TOTAL:$c";
			}
			if($_GET['voir']=="blanquette"){
				$pizzas = $bdd->query("SELECT * FROM blanquette ORDER BY nom");
				echo '<table style="width:100%" class="mdl-data-table mdl-js-data-table"><thead><th class="mdl-data-table__cell--non-numeric">Nom</th></thead>';
				$c=0;
				foreach($pizzas as $pizz)
				{
						$c++;
					echo "<tr><td class='mdl-data-table__cell--non-numeric'>".htmlentities($pizz["nom"])."</td></tr>";
				}
				echo "</table>TOTAL:$c";
			}
		?>
	</div></body>
</html>