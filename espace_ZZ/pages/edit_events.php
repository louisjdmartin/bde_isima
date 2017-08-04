<script src="./assets/js/jquery_ui/jquery-ui.min.js"></script>
<script src="./assets/js/jquery_ui/jquery-ui-timepicker-addon.js"></script>
<script src="./assets/js/jquery_ui/datepicker-fr.js"></script>
<link rel="stylesheet" href="assets/js/jquery_ui/jquery-ui.min.css" />
<link rel="stylesheet" href="assets/js/jquery_ui/jquery-ui-timepicker-addon.css" />

<?php
	$id=club_selector("Gestion du calendrier", $user);

	if($id!=null){
		echo "
			<a class='button' href='./edit_events'>Choisir un autre club</a>
			<a class='button' onclick='add_event($id,0);'>Ajouter un événement</a>
		";

		$events = api("get_liste_events");
		echo "<table>";
		$c = 0;
		if(!isset($events['liste']))echo "<tr><td>Aucun événements !</td></tr>";
		else foreach ($events['liste'] as $e) if($e['id_club']==$id){
			echo "<tr><td>".$e['debut']." &rarr; ".$e['fin']."</td>
				<td>".$e['nom']."</td><td style='width:128px;'><button onclick='add_event($id,".$e['id'].")'>Editer</button></td>
			</tr>";		
			$c++;
		}
		if($c==0)echo "<tr><td>Aucun événements !</td></tr>";
		echo "</table>";

		
	}
