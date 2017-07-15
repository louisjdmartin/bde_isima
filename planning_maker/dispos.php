<?php
include("inc/bdd.php");
include "inc/head.php";


?>

	
	<form id="form" method="GET" action="dispos.php">
		
			<?php
				$liste_membres = $bdd->query("SELECT * FROM membres ORDER BY m_nom");
				foreach($liste_membres as $mb){
					echo "<a class='menu' href='dispos.php?id=".$mb["m_id"]."'>".$mb["m_nom"]."</a>";
				}
			?>
	</form>
	<form method="POST" action="actualise_dispo.php" id="form_coche">
	<?php
		if(isset($_GET['id']))
		{
			echo "<input name='id' type='hidden' value='".$_GET['id']."' />";
			$membres = $bdd->query("SELECT m_nom FROM membres WHERE m_id=".$_GET['id']);
			foreach($membres as $mb)echo "<strong>Selection: </strong>".$mb['m_nom'];
			echo "<a class='menu' onclick='cocher(1)'>Tout cocher</a>";
			echo "<a class='menu' onclick='cocher(0)'>(ou pas)</a><br />";
			function dispo($day, $idmb, $bdd){
				$creneaux = $bdd->query("SELECT * FROM creneaux WHERE c_jour=".$day." ORDER BY c_deb");
				foreach($creneaux as $c){
					$dispo=False;
					$d = $bdd->query("SELECT d_id FROM dispos WHERE c_id=".$c['c_id']." AND m_id=".$idmb."");
					foreach($d as $i)$dispo=True;
					echo "<label for='dispo_".$c['c_id']."'>".$c['c_deb']." &rarr; ".$c['c_fin']."</label> <input type='checkbox' name='dispo_".$c['c_id']."' id='dispo_".$c['c_id']."' ".($dispo ? "checked":"")." /><br />";
				}
			}
			echo "<table style='width:100%;'><tr>";
			echo "<td>Lundi</td><td>Mardi</td><td>Mercredi</td><td>Jeudi</td><td>Vendredi</td><td>Samedi</td><td>Dimanche</td></tr><tr>";
			
			for($i=0;$i<7;$i++){				
				echo "<td>";
				dispo($i, $_GET['id'], $bdd);
				echo "</td>";	
			}
			
			?>
			</table>
			<center><input type="submit" value="Sauvegarder et regénérer le planning temporaire" onclick="document.getElementById('loading_msg').innerHTML='<em></em>'"/>
				<div id="loading_msg"></div>
			</center>
			</form>
			<?php
		}
		else
		{
			echo "<strong>Selection:</strong> aucun membre choisi, le nombre de membres disponibles s'affiche.";
			function dispo_false($day, $idmb, $bdd){
				$creneaux = $bdd->query("SELECT * FROM creneaux WHERE c_jour=".$day." ORDER BY c_deb");
				foreach($creneaux as $c){
					$a = $bdd->query("SELECT c_id FROM dispos WHERE c_id=".$c['c_id']);
					$i=0;
					foreach($a as $b)$i++;
					echo "<label for='dispo_".$c['c_id']."'>".$c['c_deb']." &rarr; ".$c['c_fin']."</label>:  $i<br />";
				}
			}
			echo "<table style='width:100%;'><tr>";
			echo "<td>Lundi</td><td>Mardi</td><td>Mercredi</td><td>Jeudi</td><td>Vendredi</td><td>Samedi</td><td>Dimanche</td></tr><tr>";
			
			for($i=0;$i<7;$i++){				
				echo "<td>";
				dispo_false($i, $_GET['id'], $bdd);
				echo "</td>";	
			}
		}
	?>
		
