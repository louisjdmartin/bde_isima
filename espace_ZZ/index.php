<?php
	session_start();
	ini_set("display_errors", "0");
	require "../api/api.php";
	$pages = array(
		"carte" => "Cartes BDE",
		"articles" => "Gestion des articles",
		"statistiques"=> "Statistiques",
		"change_pwd" => "Changer son mot de passe",
		"membres" => "Gestion des membres",
		"annales" => "Annales",
		"agenda" => "Agenda des clubs",
		"gestion_clubs" => "Gestion des clubs",
		"edit_club" => "Edition des clubs",
		"edit_events" => "Gestion des événements du calendrier",
		"calendrier" => "Calendrier du ZZ",
		"edit_partenaires" => "Gestion des partenaires",
		"articlesbde" => "Articles en vente au BDE",
		"edit_news" => "Gestion des news",
		"evenement_inscription" => "Gestion des formulaires d'inscriptions",
		"evenement_inscription_edit" => "Gérer des inscriptions",
		"inscription" => "Inscrivez vous !",
		"records" => "Tableau des records du BDE"
	);
	
	if(isset($_GET['token']))
	{
		$_SESSION['token']=$_GET['token'];
		if(!isset($_GET['no_cookie']))setcookie("token", $_SESSION['token'], $_GET['expiration'], "/", null, false, true);
	}
	else if(isset($_COOKIE['token'])) $_SESSION['token'] = $_COOKIE['token'];
	
	
	
	if(empty($_SESSION['token']))
	{
		if(empty($_GET['id'])){
			if(empty($_GET['page']))$_GET['page']='carte';
			header('location:../?from='.$_GET['page'].'#zz');
		}
		else header('location:../?from='.$_GET['page'].'.'.$_GET['id'].'#zz');
		die();
	}
	$user = authentification($_SESSION['token']);
	if($user['uti_id']==NULL)
	{
		header('location:../#zz');
		die();
	}
	
	if($_GET['page']=='carte' && isset($_GET['recherche'])){
		$cherche = api("cherche_carte", array('q'=>$_GET['recherche'], "token"=>$_SESSION['token']));
		if($cherche['liste'][0]['carte']==null)header('location:./?page=carte');
		elseif(is_numeric($_GET['recherche']))header("location: ./?page=carte&fast_add_articles=true&carte=".$_GET['recherche']);
		else header("location: ./?page=carte&fast_add_articles=true&carte=".$cherche['liste'][0]['carte']);
		die();
	}
	if($user['uti_id']==NULL)
	{
		header('location:../#zz');
		die();
	}
	
	
	
	if(!isset($pages[$_GET['page']])){
		     if(isset($_GET['from']) && $_GET['from']=='planning_maker'){header('location:../planning_maker');die();}
		else if(isset($_GET['from']) && $_GET['from']=='change_pwd'){header('location:./?page=change_pwd&token_pwd='.$_GET['token']);die();}
		else if(isset($_GET['from'])) {header('location:./'.$_GET['from']);die();}
	    else header('location:./carte');
		die();
	}
	else
	{
		$titre = $pages[$_GET['page']];
?>
<!DOCTYPE HTML>
<!--
	Verti by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title><?php echo $titre; ?></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/jquery.dropotron.min.js"></script>
		<script src="assets/js/skel.min.js"></script>
		<script src="assets/js/util.js"></script>
		<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
		<script src="assets/js/main.js"></script>
		<script src="assets/js/script.js?update=4"></script>
		<script src="assets/js/jquery_fileupload/js/vendor/jquery.ui.widget.js"></script>
		<script src="assets/js/jquery_fileupload/js/jquery.iframe-transport.js"></script>
		<script src="assets/js/jquery_fileupload/js/jquery.fileupload.js"></script>
		<script src="../assets/js/konami.js"></script>
		<link rel="apple-touch-icon" sizes="57x57" href="/ico/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="/ico/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="/ico/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="/ico/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="/ico/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="/ico/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="/ico/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="/ico/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="/ico/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="/ico/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/ico/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="/ico/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/ico/favicon-16x16.png">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="/ico/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">
		

	</head>
	<body class="no-sidebar">
		<div id="page-wrapper">

			<!-- Header -->
				<div id="header-wrapper" style='position:relative'>
	<?php if(date("m") == '12')echo '
				<link rel="stylesheet" href="../noel/neige.css" />
				<div class="snow" style="z-index:0">
				  <div class="snow__layer"><div class="snow__fall"></div></div>
				  <div class="snow__layer"><div class="snow__fall"></div></div>
				  <div class="snow__layer">
					<div class="snow__fall"></div>
					<div class="snow__fall"></div>
					<div class="snow__fall"></div>
				  </div>
				  <div class="snow__layer"><div class="snow__fall"></div></div>
				</div>
		
			';
		
		 ?>
					<?php include "header.php"; ?>
				</div>

			<!-- Main -->
				<div id="main-wrapper" style='z-index:4'>
					<div class="container">
						<div id="content">
							<?php 
						                include "./pages/".$_GET['page'].".php"; 
		                                        ?>
						</div>
					</div>
				</div>
				<div id="fond_popup"></div>
				<div id="popup"></div>
				<div id="fond_load"></div>
				<div id="load"><h3>Traitement en cours...</h3><p>Merci de patienter...</p><?php if(troll_mode($user)) echo "<center class='gif_load'></center>"; ?></div>
				<div id="fin_load"><h3>Traitement terminé</h3><p id="fin_load_msg">&nbsp;</p></div>
				<div id="close_popup">X</div>
				<input id="token" type="hidden" value="<?= $_SESSION['token']; ?>" />
			</div>

		<!-- Scripts -->

			<?php include ("../script_indispensable.php"); ?>
			<?php if(isset($_GET['fast_add_articles']) and $solde['cotisation']!=annee_scolaire() and isset($user['autorisations']['bde'])) { ?>
				<script>
					popup("<h3>ATTENTION ! COTISATION NON PAY&Eacute;E  !</h3>Dernière cotisation: <?php echo ($solde['cotisation']-1).' - '.$solde['cotisation']; ?><br />Année en cours: <?php echo (annee_scolaire()-1).' - '.annee_scolaire(); ?><br /><br /><em style='font-size:80%'>Pour mettre à jour la cotisation (voir avec Trésorier): <br /><a href='membres'>Gestion membre</a> -> Editer -> mettre à jour la cotisation -> Sauvegarder</em><br /><br /><a href='#' onclick='recharge(<?= $carte; ?>)'>Recharger</a> / <a href='#' onclick='get_all_articles(<?= $carte; ?>)'>Encaisser article</a> ");
				</script>
			<?php } 
			else if(isset($_GET['fast_add_articles']) and $solde['solde']>0 and isset($user['autorisations']['bde'])) { ?>
				<script>
					get_all_articles(<?= $carte; ?>);
				</script>
			<?php } else if(isset($_GET['fast_add_articles']) and $solde['solde']<0 and isset($user['autorisations']['bde'])) { ?>
				<script>
					popup("<h3>ATTENTION ! SOLDE NEGATIF !</h3><a href='#' onclick='recharge(<?= $carte; ?>)'>Recharger</a> / <a href='#' onclick='get_all_articles(<?= $carte; ?>)'>Encaisser article</a> ");
				</script>
			<?php } ?>
			
			<div id="footer-wrapper">
					<footer id="footer" class="container">
						<div class="row">
							<div class="12u">
								<div id="copyright">
									<ul class="menu">
										<li>
											© BDE ISIMA, Design: <a href="http://html5up.net">HTML5 UP</a>
											<br />Créé par BDE BliZZard
											<?php if(troll_mode($user)){
												echo "<br>Le BDE BliZZard décline toute responsabilitée en cas de dysfonctionnement sur les comptes listeux.";
												echo "<br>Le BDE BliZZard décline toute responsabilitée en cas de dysfonctionnement le premier avril.";
												echo "<br>Le BDE BliZZard espère que le site vous plaît.";
												echo "<br>Le saviez vous ? Vous avez une chance sur 42 d'être converti par un prêtre bleu ou rouge.";
												echo "<br>Le saviez vous ? Vous avez une chance sur 42 d'être la tête à l'envers.";
												echo "<br>Le saviez vous ? Le temps de chargement moyen de l'API est de 100ms, sauf aujourd'hui où celui-ci est de 4s.";
												echo "<br>COGO EVERYWHERE";
												echo "<br>Le saviez vous ? C'était mieux avant !";
											}if(isset($user['autorisations']['romane'])) echo "<br />Ce grade aussi beau qu'inutile vous est offert par Louis du BDE bliZZard ;-) j'espère qu'il fera des jaloux !"; ?>
										</li>
										
									</ul>
								</div>
							</div>
						</div>
					</footer>
				</div>
	</body>
	<?php
		if(troll_mode($user)){
			echo "
				<style>
					#header-wrapper{
						background: url('../easter_eggs/cogonixkill/".rand(1,10).".jpg');
						background-size: auto 280px;
						background-attachment: fixed;
					}
				</style>
				<script>
					function getRandomInt(min, max) {
						  min = Math.ceil(min);
						  max = Math.floor(max);
						  return Math.floor(Math.random() * (max - min)) + min;
					}
					if(getRandomInt(1,42)==4){
						$('#main-wrapper').append('<audio src=\"../easter_eggs/wololo.mp3\" autoplay></audio>');
						$('*').css({'transition':'background 2s'});
						if(getRandomInt(1,3)==1)setTimeout(\"$('*').css({'background':'blue'});\",700);
						else setTimeout(\"$('*').css({'background':'red'});\",700);
					}
					if(getRandomInt(1,42)==28){
						$('body').css({'transition':'transform 2s'});
						$('body').css({'transform':'rotate(180deg)'});
					}
				</script>
			";
		}
		
	?>
</html>
	<?php } ?>
