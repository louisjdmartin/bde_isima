<?php
$style="
	<style>
		div#confirm{
			margin: 64px auto;
			width: 400px;
			box-shadow: 2px 2px 5px grey;
			padding: 32px;
		}
		a{
			color:white;
			display:inline-block;
			width: 180px;
			padding: 12px 0;
			margin: 10px;
			text-align:center;
			background:grey;
		}
	</style>
";
	require("fonctions.php");
	if ($_GET['mode']=='zz'){
		$zz = $donnees->prepare('SELECT solde, nom, prenom FROM isibouffe_zz WHERE id=?');
		$zz->execute(array($_GET['id']));
		$zz = $zz->fetchAll();
		if($zz[0]['solde']==0 || isset($_GET['force']) && $_GET['force']=='true'){
			$eff = $donnees->prepare('DELETE FROM isibouffe_hist_recharges WHERE id_zz=?');
			$eff->execute(array($_GET['id']));	
			$eff2 = $donnees->prepare('DELETE FROM isibouffe_historique WHERE id_zz=?');
			$eff2->execute(array($_GET['id']));	
			$eff3 = $donnees->prepare('DELETE FROM isibouffe_zz WHERE id=?');
			$eff3->execute(array($_GET['id']));	
			header('location:./aff_zz.php');
		}
		else echo "$style <div id='confirm'>ATTENTION ! Ce solde n'est pas nul. <br />Confirmez l'action: <br /><strong>Effacer le compte de ".$zz[0]['nom']." ".$zz[0]['prenom']." avec un solde de ".$zz[0]['solde']." euros.</strong><br /><a href='suppr.php?id=".$_GET['id']."&mode=zz&force=true'>Effacer</a><a href='aff_zz.php'>Retour</a></div>";
	}

	if ($_GET['mode']=='art'){
		$zz = $donnees->prepare('SELECT * FROM isibouffe_historique WHERE id=?');
		$zz->execute(array($_GET['id']));
		$zz = $zz->fetchAll();
		if(count($zz)==0 || isset($_GET['force']) && $_GET['force']=='true'){
			$eff2 = $donnees->prepare('DELETE FROM isibouffe_historique WHERE id_article=?');
			$eff2->execute(array($_GET['id']));	
			$eff3 = $donnees->prepare('DELETE FROM isibouffe_article WHERE id_article=?');
			$eff3->execute(array($_GET['id']));	
			header('location:./creer_repas.php');
		}
		else echo "$style <div id='confirm'>ATTENTION ! Cette article est present dans l'historique de certaine personnes. Si vous effacez cet article il ne sera plus visible dans l'historique de conso.<br />Confirmez l'action: <br /><strong> Effacer l'article</strong><br /><a href='suppr.php?id=".$_GET['id']."&mode=art&force=true'>Effacer</a><a href='creer_repas.php'>Retour</a></div>";
	}
