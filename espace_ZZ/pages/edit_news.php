<?php
 	
	if(!isset($user['autorisations']['bde']))
	{
		echo "<h2>Accès refusé !</h2><p>Vous devez être membre du BDE pour voir ça</p>";
		exit();
	}
	
	$partenaires = api("get_news");
	echo "<button onclick='edit_news(0)'>Ajouter une news</button><table>";
	foreach($partenaires['liste'] as $p)
	{
		echo "
			<tr>
				<td style='width:32px;text-align:center' >".$p['id']."</td>
				<td style='width:32px;text-align:center'><img style='height:32px;' src='".$p['img']."' /></td>
				<td>".$p['titre']."</td>
				<td style='width:128px;text-align:center' ><button onclick='edit_news(".$p['id'].")'>Editer</button></td>
			</tr>
		";
	}
	echo "</table>";
