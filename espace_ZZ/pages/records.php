<?php
	$scores = api("high_score", array("token" => $_SESSION['token']));
	echo "<div style='overflow-x:auto;'><table class='overflowtable'>>";
	echo "<tr>
		<td>Article</td>
		<td>Record</td>
		<td><nobr>Score actuel</nobr></td>
		<td>Classement</td>
	</tr>";


	foreach($scores as $s){
		echo "
		<tr>
			<td><nobr>".$s['nom_art']."</nobr></td>
			<td><nobr>".$s['nom_membre_record']." avec ".$s['record']." achats</nobr></td>
			<td><nobr>Ton score: ".$s['score_actuel']."</nobr></td>
			<td><nobr>Classement: ".$s['classement']."</nobr></td>
		</tr>
		
		";
	}
	echo "</table></div>";
?>
<style>nobr{margin-right:16px;}</style>
