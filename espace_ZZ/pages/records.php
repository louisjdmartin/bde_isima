<?php
	$scores = api("high_score", array("token" => $_SESSION['token']));
	echo "<table>";
	echo "<tr>
		<td>Article</td>
		<td>Record</td>
		<td>Score actuel</td>
		<td>Classement</td>
	</tr>";


	foreach($scores as $s){
		echo "
		<tr>
			<td>".$s['nom_art']."</td>
			<td>".$s['nom_membre_record']." avec ".$s['record']." achats</td>
			<td>Ton score: ".$s['score_actuel']."</td>
			<td>Classement: ".$s['classement']."</td>
		</tr>
		
		";
	}
	echo "</table>";
?>
