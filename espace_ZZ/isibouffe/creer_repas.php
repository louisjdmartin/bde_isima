<?php include "header.html"; ?>


<div class="form-style-8">

	<form action="creer_repas.php" method="POST"><br>
		
		<h2>Nouvel article</h2>
	 	
			<input name="nom_article" placeholder="Article"><br><br>
			<input name="prix_article" placeholder="Prix €"><br><br>


			<input type="Submit" value="Valider"><br><br>
		

	</form>
</div>

<?php 

if (isset ($_POST['nom_article']))
{
		$req_send = "INSERT INTO isibouffe_article (nom_article, prix_article) VALUES ('".$_POST['nom_article']."','".$_POST['prix_article']."')";

		$res_send = $donnees->query($req_send);
}



$all_article = $donnees->query('SELECT * FROM isibouffe_article');

while ($donnees = $all_article->fetch())
{
?>
 	<p>
		<a href='suppr.php?mode=art&id=<?php echo $donnees['id_article']; ?>'>[Effacer] </a>
		<strong><?php echo $donnees['nom_article']; ?></strong>
		<?php echo $donnees['prix_article']; ?> €
	</p>
 	
<?php 


}

$all_article->closeCursor(); // Termine le traitement de la requête
 

?>






























