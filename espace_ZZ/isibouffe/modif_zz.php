<?php include "header.html"; 



$numero=$_GET['id_zz'];

$info56_zz = $donnees->query('SELECT * FROM isibouffe_zz WHERE id='.$_GET['id_zz']);

?>



<div class="form-style-8">
	<form method="POST"><br>
		
		<h2>Modification des informations</h2>
	 	
			<input name="surnom" placeholder="Surnom"><br><br>
			<input name="prenom" placeholder="Prenom"><br><br>
			<input name="nom" placeholder="Nom"><br><br>
			<input name="promo" placeholder="Promo"><br><br>

			<input type="Submit" value="Valider"><br><br>
		
	</form>
</div>



<?php 


if (isset ($_POST['surnom'])&& !empty($_POST['surnom']))
{
	$donnees->query("UPDATE isibouffe_zz SET surnom = '".htmlspecialchars($_POST['surnom'])."' WHERE isibouffe_zz.id=".$numero);
	
}

if (isset ($_POST['prenom'])&& !empty($_POST['prenom']))
{
	$donnees->query("UPDATE isibouffe_zz SET prenom = '".htmlspecialchars($_POST['prenom'])."' WHERE id=".$numero);
}

if (isset ($_POST['nom'])&& !empty($_POST['nom']))
{
	$donnees->query("UPDATE isibouffe_zz SET nom = '".htmlspecialchars($_POST['nom'])."' WHERE id=".$numero);
}

if (isset ($_POST['promo'])&& !empty($_POST['promo']))
{
	$donnees->query("UPDATE isibouffe_zz SET promo = '".htmlspecialchars($_POST['promo'])."' WHERE id=".$numero);
}

$info56_zz->closeCursor();




?>
