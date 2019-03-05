<?php
	if(!isset($user['autorisations']['bde']))
	{
		echo "<h2>Accès refusé !</h2><p>Vous devez être membre du BDE pour voir ça</p>";
		exit();
	}
	else
	{
		$articles = api("get_liste_articles");
		echo "
			<button onclick='edit_article(0, \"\", \"\", \"\", \"\")'>Ajouter un article</button>
			<table style='width:100%'>
				<tr>
					<th>#</th>
					<th>Image</th>
					<th>Nom</th>
					<th>Prix</th>
					<th>Prix non cotisants</th>
					<th></th>
				</tr>
		";
		foreach($articles['liste'] as $art)
		{
			echo "
				<tr>
					<td style='width:32px;text-align:center;'>".$art['id']."</td>
					<td style='width:32px;text-align:center'><img style='height:32px;' src='".$art['img']."' /></td>
					<td>".$art['nom']."</td>
					<td style='width:64px;text-align:center'>".$art['tarif']." €</td>
					<td style='width:64px;text-align:center'>".$art['tarif_nc']." €</td>
					<td style='width:128px;text-align:center' onclick='edit_article(".$art['id']." , \"".$art['nom']."\", \"".$art['img']."\", \"".$art['tarif']."\", \"".$art['tarif_nc']."\")'><button>Editer</button></td>
				</tr>
			";
		}
		echo "</table>";
	}
