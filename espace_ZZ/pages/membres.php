<?php
	if(!isset($user['autorisations']['bde']))
	{
		echo "<h2>Accès refusé !</h2><p>Vous devez être membre du BDE pour voir ça</p>";
		exit();
	}
	else
	{
		if(isset($_GET['orderby']))$membres = api("get_liste_membres", array("token" => $_SESSION['token'], "orderby" => $_GET['orderby']));
		else $membres = api("get_liste_membres", array("token" => $_SESSION['token']));
		if(isset($_GET['order']) && $_GET['order']=='ASC')$order="DESC";
		else $order="ASC";
		echo "
			<button onclick='add_membre()'>Ajouter un membre cotisant</button>
			<div style='overflow-x:auto'>
			<table style='width:100%' class='overflowtable'>
				<tr style='width:32px;text-align:left;'>
					<th><a href='./?page=membres&order=$order&orderby=id $order'>#</a></th>
					<th><a href='./?page=membres&order=$order&orderby=nom $order, prenom $order'>Nom Prenom Surnom</a></th>
					<th><a href='./?page=membres&order=$order&orderby=mail $order'>Mail</a></th>
					<th><a href='./?page=membres&order=$order&orderby=numero $order'>Carte</a></th>
					<th><a href='./?page=membres&order=$order&orderby=promo $order'>Promo</a></th>
					<th><a href='./?page=membres&order=$order&orderby=grade $order'>Grade</a></th>
					<th><a href='./?page=membres&order=$order&orderby=solde $order'>Solde</a></th>
					<th><a href='./?page=membres&order=$order&orderby=telephone $order'>Tel</a></th>
					<th><a href='./?page=membres&order=$order&orderby=cotisation $order'>Cotisation</a></th>
					<th></th>
				</tr>
		";
		foreach($membres['liste'] as $mb)
		{
			echo "
				<tr>
					<td>".$mb['id']."</td>
					<td class='nom'>".$mb['nom']." ".$mb['prenom']." ".$mb['surnom']."</td>
					<td>".$mb['mail']."</td>
					<td class='carte'><a href='?page=carte&carte=".$mb['numero']."'>".$mb['numero']."</a></td>
					<td>".$mb['promo']."</td>
					<td>".grade($mb['grade'])."</td>
					<td>".solde($mb['solde'])."</td>
					<td>".$mb['telephone']."</td>
					<td>".$mb['cotisation']."</td>
					<td style='width:128px;text-align:center' onclick='edit_membre(".$mb['id'].", \"".$mb['nom']."\", \"".$mb['prenom']."\", \"".$mb['surnom']."\", \"".$mb['mail']."\", \"".$mb['numero']."\", \"".$mb['promo']."\", \"".$mb['grade']."\", \"".$mb['cotisation']."\")'><button>Editer</button></td>
				</tr>
			";
		}
		echo "</table></div>";
	}
?>

<script>
    
</script>
