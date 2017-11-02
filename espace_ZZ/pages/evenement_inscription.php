<?php
	if(!isset($user['autorisations']['club']))
	{
		echo "<h2>Accès refusé !</h2><p>Vous devez être membre du BDE pour voir ça</p>";
		exit();
	}
?>
<script src="./assets/js/jquery_ui/jquery-ui.min.js"></script>
<script src="./assets/js/jquery_ui/jquery-ui-timepicker-addon.js"></script>
<script src="./assets/js/jquery_ui/datepicker-fr.js"></script>
<link rel="stylesheet" href="assets/js/jquery_ui/jquery-ui.min.css" />
<link rel="stylesheet" href="assets/js/jquery_ui/jquery-ui-timepicker-addon.css" />


<?php
	$id=club_selector("Gestion des inscriptions", $user);

	if($id!=null)
	{
		?>
		
			<a class='button' href='./evenement_inscription'>Changer de club</a>
			<a class='button' onclick='add_evt(<?= $id; ?>)'>Ajouter un événement avec inscription</a>
			
			<br />todo: copie/gestion articles/incription (membre+club)/edit/voir inscrits
		<?php
		
		$evt = api("get_liste_evt", array("token"=>$_SESSION['token'],"id_club"=>$id));
		
		echo "<h3>A venir</h3>";
		
		echo "<div style='overflow-x:auto;'><table class='overflowtable'>";
		echo "<tr>
			<td>#</td>
			<td>Nom</td>
			<td>Places</td>
			<td>Carte BDE</td>
			<td>Date limite</td>
			<td>Date</td>
			<td>Options</td>
		</tr>";
		$passe = false;
		foreach($evt['liste'] as $e)
		{
			if(strtotime($e['date_event']) < time() and !$passe){
				echo "</table></div>";
				echo "<h3>Passé</h3>";
				$passe=true;
				echo "<div style='overflow-x:auto;'><table class='overflowtable'>";
				echo "<tr>
					<td>#</td>
					<td>Nom</td>
					<td>Places</td>
					<td>Carte BDE</td>
					<td>Date limite</td>
					<td>Date</td>
					<td>Options</td>
				</tr>";
			}
			echo "<tr>";
			echo "<td>".$e['id']."</td>";
			echo "<td>".$e['nom']."</td>";
			echo "<td>".$e['places']."</td>";
			echo "<td>".($e['carte_bde_possible']==1?"Oui":"Non")."</td>";
			echo "<td>".date_joli(strtotime($e['date_limite_commande']))."</td>";
			echo "<td>".date_joli(strtotime($e['date_event']))."</td>";
			echo "<td><a class='button' href='evenement_inscription_edit.".$e['id']."'>Gérer</a><a class='button' onclick='cp_evt(".$e['id'].")'>Copier</a><a class='button' onclick='del_evt(".$e['id'].")'>Effacer</a></td>";
			echo "</tr>";
		}
		echo "</table></div>";
	}
