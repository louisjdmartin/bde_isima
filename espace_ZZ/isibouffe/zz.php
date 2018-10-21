<?php

require 'header.html';
//on est sur le profil du zz



?>


<?php

$info_zz = $donnees->query('SELECT * FROM isibouffe_zz WHERE id='.addslashes($_GET['id_zz'])); //addslashes empêche les injections SQL

$info1 = $info_zz->fetch();

//FONCTIONNE

?>

<p>
	
		<strong><?php echo $info1['nom']?> <?php echo $info1['prenom']; ?></strong>
			
		<i><?php echo $info1['surnom']; ?><br /></i>
				
		Promo <?php echo $info1['promo']; ?><br />

		Solde : <?php echo $info1['solde']; ?> € <br />
	
</p>


<?php

//si on veut modifier les info du zz --> NE FONCTIONNE PAS

?>

<a href='modif_zz.php?id_zz=<?php echo $_GET['id_zz']; ?>'>Modification des informations</a>

<?php

$info_zz->closeCursor();


// créditer un zz

?>

<p>

	<form action="credit.php" method="GET"><br>
	
		Recharger : <input name="ajout" type='float'> €<br><br>
		<input name="id_zz" type="hidden" value=<?php echo $_GET['id_zz']; ?> ><br><br>


	</form>
	
</p>



<?php

//afficher la liste des article avec une case quantité à remplir et le prix

$all_article = $donnees->query('SELECT * FROM isibouffe_article ORDER BY id_article DESC');



// On affiche chaque entrée une à une, débiter

while ($info77 = $all_article->fetch())
{
?>

	

    <p>

		<strong><?php echo $info77['nom_article']; ?></strong>
		<?php echo $info77['prix_article']; ?> €
 



	<form action="debit.php" method="GET">

		quantité : 
		<a class='lien' href='debit.php?quantite=1&id_zz=<?php echo $_GET['id_zz']; ?>&id_article=<?php echo $info77['id_article']; ?>'>1</a>
		<a class='lien' href='debit.php?quantite=2&id_zz=<?php echo $_GET['id_zz']; ?>&id_article=<?php echo $info77['id_article']; ?>'>2</a>
		<a class='lien' href='debit.php?quantite=3&id_zz=<?php echo $_GET['id_zz']; ?>&id_article=<?php echo $info77['id_article']; ?>'>3</a>
		<a class='lien' href='debit.php?quantite=4&id_zz=<?php echo $_GET['id_zz']; ?>&id_article=<?php echo $info77['id_article']; ?>'>4</a>
		<input name="quantite" type='number' placeholder="Autre qte">
		<input name="id_zz" type="hidden" value=<?php echo $_GET['id_zz']; ?> >
		<input name="id_article" type="hidden" value=<?php echo $info77['id_article']; ?> >

		<input type="Submit" value="Valider"><br><br>

	</form>
	
 	</p>
 	
<?php 


}






$all_article->closeCursor(); // Termine le traitement de la requête


//afficher les recharges -> fonctionne
				?>

				<br /><br /><strong>Consos :</strong>


<?php

				//afficher l'historique du zz
					
				
				
					$info_hist = $donnees->query('SELECT * FROM isibouffe_historique, isibouffe_article WHERE isibouffe_historique.id_zz='.$_GET['id_zz'].' AND isibouffe_historique.id_article=isibouffe_article.id_article' );
		
					

					while ($info5=$info_hist->fetch())

					{
					?>

						<div class="zz">
						<br />	

							<i><?php echo $info5['date'];?></i><br />						

							<?php echo $info5['quantite']; ?>  <?php echo $info5['nom_article']; ?> à <?php echo $info5['prix_article']; ?> €<br />
				
							<strong>Solde</strong> : <?php echo $info5['solde']; ?> €<br />	
		
						<br />	
					   </div>

					<?php

					}$info_hist->closeCursor();
		
			?>



				<br /><br /><strong>Recharges :</strong>
				<?php
				
				
				$info_recharge = $donnees->query('SELECT * FROM isibouffe_hist_recharges WHERE id_zz='.addslashes($_GET['id_zz']));
				
				while ($info11=$info_recharge->fetch())

				{
					?>

						<div class="zz">
						<br />	

							<i><?php echo $info11['date'];?></i><br />						
							<strong>Recharge</strong> : <?php echo $info11['recharge']; ?> €<br />	
		
						<br />	
					   </div>

					<?php

				}$info_recharge->closeCursor();





?>
