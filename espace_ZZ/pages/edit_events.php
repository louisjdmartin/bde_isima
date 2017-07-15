<script src="./assets/js/jquery_ui/jquery-ui.min.js"></script>
<script src="./assets/js/jquery_ui/jquery-ui-timepicker-addon.js"></script>
<script src="./assets/js/jquery_ui/datepicker-fr.js"></script>
<link rel="stylesheet" href="assets/js/jquery_ui/jquery-ui.min.css" />
<link rel="stylesheet" href="assets/js/jquery_ui/jquery-ui-timepicker-addon.css" />

<?php
	echo "
	<script>function edit_this_club(){
		club = $('#club_id').val();
		window.location = './edit_events.'+club;
	}</script>
	";
	if(isset($user['autorisations']['club']))
	{
		$id=null;
		if(!isset($_GET['id'])){
			$clubs = api("get_club_gere", array("token" => $_SESSION['token']));
			echo "<h2>Gestion des événements</h2>
				<form action='./' method='get'>
					<input type='hidden' name='page' value='edit_club' />
					<select name='id' id='club_id' onchange='edit_this_club();'><option>Choisir un club:</option>
			";
			$count = 0;
			foreach($clubs['liste'] as $club)
			{
				$select = "";
				if(isset($_GET['id']) && $_GET['id'] == $club['id'])$select = "selected";
				echo "<option value='".$club['id']."' $select>".$club['nom']."</option>";	
				$count ++;
						
			}
			echo "</select></form>";
			if($count==1)echo "Chargement...<script>window.location='./edit_events.".$club['id']."'</script>";
		}else 
		{	
			$clubs = api("get_club_gere", array("token" => $_SESSION['token']));
			foreach($clubs['liste'] as $club)
				if(isset($_GET['id']) && $_GET['id'] == $club['id']){
					$id=$_GET['id'];
					$nom = $club['nom'];
				}
			if($id==null)echo "<strong>Accès refusé:</strong> Ce club n'existe pas ou vous n'avez pas le droit de le modifier.<script>setTimeout(\"window.location='./edit_event'\", 5000);</script>";
		}
	
	}

	if($id!=null){
		echo "
			<h2>Gestion des événements ($nom)</h2>
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
