<?php
	if(!isset($user['autorisations']['bde']))
	{
		echo "<h2>Accès refusé !</h2><p>Vous devez être membre du BDE pour voir ça</p>";
		exit();
	}
	$clubs = api("get_liste_clubs");
	echo "<button onclick='open_club()'>Ouvrir un club</button>";
	echo "<table style='width:100%'>";
	foreach($clubs['liste'] as $club)
	{
		echo "
			<tr>
				<td style='width:32px;text-align:center;'>".$club['id']."</td>
				<td style='width:32px;text-align:center'><img style='max-width:64px;max-height:64px;margin: 0 8px' src='".$club['img']."' /></td>
				<td>".$club['nom']."</td>";
				if($club['id']!=0)echo "<td style='width:128px;text-align:center'><a class='button' onclick='close_club(".$club['id'].");'>Fermer club</a></td>";
				else echo "<td></td>";
				echo "<td style='width:4px;'></td>
				<td style='width:128px;padding:2px 0px;text-align:center'><a class='button' href='./edit_events.".$club['id']."'>Gerer événements</a></td>
				<td style='width:4px;'></td>
				<td style='width:128px;padding:2px 0px;text-align:center'><a class='button' href='./edit_club.".$club['id']."'>Editer club</a></td>
				<td style='width:4px;'></td>
				<td style='width:128px;text-align:center'><a class='button' onclick='changer_proprietaire(".$club['id'].")'>Changer proprietaire</a></td>
			</tr>
		";
	}
	echo "</table>";
