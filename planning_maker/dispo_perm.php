<?php
	if($_GET['id']=="rem"){
		header('location:./dispo_perm.php');
		die();
	}
	$bdd = new PDO('mysql:host=localhost;dbname=python', 'louis','louismartin');
	$liste_dispo = "";
	if(!empty($_GET['id'])){
		$rep = $bdd->query('SELECT * FROM dispo_bde WHERE id='.$_GET['id']);
		foreach ($rep as $r){
			$liste_dispo = $r;
		}
	}
	function write_dispo($liste_dispo, $moment){
		if(!empty($liste_dispo)){
			$check1="";$check2="";$check3="";
			if($liste_dispo[$moment]==0)$check1="selected";
			if($liste_dispo[$moment]==1)$check2="selected";
			if($liste_dispo[$moment]==2)$check3="selected";
			
			echo "
				<select name='$moment'>
					<option value='0' $check1>Pas dispo</option>
					<option value='1' $check2>Ne sait pas</option>
					<option value='2' $check3>Dispo</option>
				</select>
			";
		}
		else{
			$bdd = new PDO('mysql:host=localhost;dbname=python', 'louis','louismartin');
			$rep = $bdd->query('SELECT nom FROM dispo_bde WHERE '.$moment.'=2 ORDER BY nom');
			$c=0;
			echo "<div class='dispos'>";
			foreach ($rep as $r){
				if($c!=0)echo "<br />";
				echo $r['nom'];
				$c++;
			}
			echo "</div>";
		}
		echo "<hr/>";
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="https://code.getmdl.io/1.2.1/material.indigo-pink.min.css">
		<script defer src="http://code.jquery.com/jquery.min.js"></script>
		<script defer src="https://code.getmdl.io/1.2.1/material.min.js"></script>
		<title>Disponibilités permanences BDE</title>
	</head>
	<style>
	
		table{
			width:1295px;
			margin:64px;
		}
		td{
			width:185px;
			text-align:left!important;
			vertical-align:top!important;
		}
		.nope{
			background:#AAA;
		}
		select{
			max-width:110px;
		}
		select#personne{
			width:300px;
			max-width:200px;
		}
		label{
			width:50px;
			display:inline-block;
		}
		.dispos{height:220px;}
		
	</style>
</html>


<center><form action="actualise_dispo_perm.php?id=<?php if(!empty($liste_dispo)) echo $liste_dispo['id'] ;?>" method="POST">
	<select id="personne" onchange="window.location='./dispo_perm.php?id='+$('#personne').val()">
		<option>Choisir une personne...</option>
		<option value="rem">Voir qui est dispo</option>
		<?php
			$rep = $bdd->query('SELECT id, nom FROM dispo_bde ORDER BY nom');
			foreach($rep as $r){
				echo "<option value='".$r['id']."'>".$r['nom']."</option>";
			}
			
		?>		
	</select><br />
	
	<?php if(!empty($liste_dispo))echo "<strong>Personne choisie: ".$liste_dispo['nom']."</strong>";
	else echo "<strong>Disponibilités</strong>";
	?>
	<!-- SEMAINE 1 -->
	<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">

		<thead>
			<td></td>
			<td>Lundi</td>
			<td>Mardi</td>
			<td>Mercredi</td>
			<td>Jeudi</td>
			<td>Vendredi</td>
			<td>Samedi</td>
			<td>Dimanche</td>
		</thead>
		
		<!--<tr>
			<td>Activités</td>
			<td class="nope"></td>
			<td class="nope"></td>
			<td>
				Partiel SDD <br />Service PIZZA <br /> Billard <br />
			</td>
			<td>Soirée BDE</td>
			<td class="nope">Soirée Officielle</td>
			<td class="nope">Nettoyage BDE</td>
			<td class="nope"></td>
		</tr>-->
		<tr>
			<td>Disponibilités<br />Matin = pause de 10h
			<br />Midi, bah devine
			<br />Soir = jusqu'a la fermeture
			<br />SI quelqu'un n'a pas cours,<br /> ALORS il fait perm
			<br /><br/>Je ferai une V2 <br />pour une meilleure organisation <br />dans la semaine #codeAl'arrache</td>
			<td>
				<label>Matin </label><?php write_dispo($liste_dispo, "lun_mat"); ?><br />
				<label>Midi</label><?php write_dispo($liste_dispo, "lun_mid"); ?><br />
				<label>Soir </label><?php write_dispo($liste_dispo, "lund_soir"); ?><br />
			</td>
			<td>
				<label>Matin </label><?php write_dispo($liste_dispo, "mar_mat"); ?><br />
				<label>Midi</label><?php write_dispo($liste_dispo, "mar_midi"); ?><br />
				<label>Soir </label><?php write_dispo($liste_dispo, "mar_soir"); ?><br />
			</td>
			<td>
				<label>Matin </label><?php write_dispo($liste_dispo, "mer_mat"); ?><br />
				<label>Midi </label><?php write_dispo($liste_dispo, "mer_midi"); ?><br />
				<label>Soir </label><?php write_dispo($liste_dispo, "mer_soir"); ?><br />
			</td>
			<td>
				<label>Matin </label><?php write_dispo($liste_dispo, "jeu_mat"); ?><br />
				<label>Midi </label><?php write_dispo($liste_dispo, "jeu_mid"); ?><br />
				<label>13h-15h </label><?php write_dispo($liste_dispo, "jeu_1315"); ?><br />
				<label>15h-17h </label><?php write_dispo($liste_dispo, "jeu_1517"); ?><br />
				<label>17h-19h </label><?php write_dispo($liste_dispo, "jeu_1719"); ?><br />
			</td>
			<td>
				<label>Matin </label><?php write_dispo($liste_dispo, "ven_mat"); ?><br />
				<label>Midi</label><?php write_dispo($liste_dispo, "ven_midi"); ?><br />
				<label>Soir</label><em><br />BDE pas fermé mais<br /> flemme de modifier la BDD<br/>je suis dispo</em><br />
			</td>
			<td class="nope"></td>
			<td class="nope"></td>
		</tr>

	</table>
</center>


	<!-- SEMAINE 2 --><!--<center>
	<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">

		<thead>
			<td></td>
			<td>Lundi 12</td>
			<td>Mardi 13</td>
			<td>Mercredi 14</td>
			<td>Jeudi 15</td>
			<td>Vendredi 16</td>
			<td>Samedi 17</td>
			<td>Dimanche 18</td>
		</thead>
		
		<tr>
			<td>Activités</td>
			<td>Blind TEST <br /> Patinoire</td>
			<td>Soirée cocktails <br /> Jeux de sociétés</td>
			<td class="nope"></td>
			<td class="nope"></td>
			<td></td>
			<td class="nope"></td>
			<td class="nope"></td>
		</tr>
		
		<tr>
			<td>Disponibilités</td>
			<td>
				<label>Matin </label><?php write_dispo($liste_dispo, "lun_mat"); ?><br />
				<label>Midi</label><?php write_dispo($liste_dispo, "lun_mid"); ?><br />
				<label>Soir </label><?php write_dispo($liste_dispo, "lund_soir"); ?><br />
			</td>
			<td>
				<label>Matin </label><?php write_dispo($liste_dispo, "mar_mat"); ?><br />
				<label>Midi</label><?php write_dispo($liste_dispo, "mar_midi"); ?><br />
				<label>Soir </label><?php write_dispo($liste_dispo, "mar_soir"); ?><br />
			</td>
			<td class="nope"></td>
			<td class="nope"></td>
			<td>
				<label>Matin </label><?php write_dispo($liste_dispo, "ven_mat"); ?><br />
				<label>Midi</label><?php write_dispo($liste_dispo, "ven_midi"); ?><br />
				<label>Soir</label><em>BDE fermé</em><br />
			</td>
			<td class="nope"></td>
			<td class="nope"></td>
		</tr>

	</table>--><center><?php if(!empty($liste_dispo)) echo '<input type="submit" value="Sauvegarde" />' ?></form>
</center>