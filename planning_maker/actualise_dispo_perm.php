<?php
	$bdd = new PDO('mysql:host=localhost;dbname=python', 'louis','louismartin');
	foreach ($_POST as $key => $post){
		$bdd->query('UPDATE dispo_bde SET '.$key.'='.$post.' WHERE id='.$_GET['id']);
	}
	header('location:./dispo_perm.php?id='.$_GET['id']);
?>