<?php include "header.html"; ?>



<div class="form-style-8">
	<form action="creer_zz.php" method="POST"><br>
		
		<h2>Nouveau ZZ</h2>
	 	<form>
			<input name="surnom" placeholder="Surnom"><br><br>
			<input name="prenom" placeholder="Prenom"><br><br>
			<input name="nom" placeholder="Nom"><br><br>
			<input name="solde" placeholder="Solde"><br><br>
			<input name="promo" placeholder="Promo"><br><br>

			<input type="Submit" value="Valider"><br><br>
		</form>
	</form>
</div>

<?php 

if (isset ($_POST['prenom']))
{

	$req_send = "INSERT INTO isibouffe_zz (nom, prenom, surnom, solde, promo) VALUES ('".$_POST['nom']."','".$_POST['prenom']."','".$_POST['surnom']."','".$_POST['solde']."','".$_POST['promo']."')";
	

	$res_send = $donnees->query($req_send);
	
}


?>

