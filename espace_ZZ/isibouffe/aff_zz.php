<?php include "header.html"; ?>

<body>


<?php	
//AFFICHE TOUS LES ZZ

	//pouvoir exporter les résultats en pdf
	//organiser par ordre alphabetique et par promo
	//https://codepen.io/alassetter/pen/cyrfB

// On récupère tout le contenu de la table 

$info_zz = $donnees->query('SELECT * FROM isibouffe_zz ORDER BY promo, nom');

//afficher l'historique du zz
//$hist_zz = $donnees->query('SELECT * FROM historique_zz');


// On affiche chaque entrée une à une

?>

<table class="table-fill">
	<thead>
		<tr>
			<th class="text-left">Nom</th>
			<th class="text-left">Prenom</th>
			
			<th class="text-left">Promo</th>
			<th class="text-left">Solde</th>
			<th class="text-left">Effacer</th>
		</tr>
	</thead>
	<tbody class="table-hover">


<?php

// ajouter des conditions pour afficher les soldes <-5 en rouge et les soldes entre -5 et 1 en jaune

while ($donnees = $info_zz->fetch())

{
?>

	
		<tr>
			<td class="text-left"><?php echo $donnees['nom']?></td>
			<td class="text-left"><?php echo $donnees['prenom']?></td>
			
			<td class="text-left"><?php echo $donnees['promo']?></td>
			<td class="text-left"><?php echo $donnees['solde']?></td>
			<td class="text-left"><a href="suppr.php?mode=zz&id=<?php echo $donnees['id']?>">Effacer</a></td>
		</tr>


  

<?php

}


$info_zz->closeCursor(); // Termine le traitement de la requête



?>

	</tbody>
</table>

</body>

</html>
