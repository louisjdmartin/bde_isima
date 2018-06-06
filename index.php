<?php
	ini_set("display_errors", 1);
	require "./api/api.php";
?>
<!DOCTYPE HTML>
<!--
	SITE DU BDE DE L'ISIMA
	- Crée par Louis MARTIN - BDE BliZZard
	Admissible ? Tu veut intégrer notre école ? Contacte nous ! bde.isima(a)gmail.com
	D'ailleurs que fait tu ici ? Visite le site plutôt que de regarder son code source !
--><!--
	Dimension by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Site du BDE de l'ISIMA</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<meta name="msapplication-TileColor" content="#fee"/>
        <meta name="theme-color" content="#fee">
		<meta name="Description" content="Site du BDE de l'ISIMA, découvre la vie étudiante d'un ZZ (étudiant de l'ISIMA) sur notre site !" /> 
		<meta name="Keywords" content="ISIMA, Clermont-Ferrand, Informatique, Etudiant, Vie etudiante, Clubs, Associations, <?php $clubs = api("get_liste_clubs");foreach($clubs['liste'] as $c)echo $c['nom'].", "; ?>Concours CCP, CPGE, Ingenieur, UBP, UCA, Universite Clermont-Auvergne, BREI, BNEI, plaquette alpha" />
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
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
	<body>
		
		<!-- Wrapper -->
			<div id="wrapper">
<?php
			if(date("m") == '12')echo '
				<link rel="stylesheet" href="noel/neige.css" />
				<div class="snow" style="position:fixed!important">
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
				<!-- Header -->
					<header id="header">
						<div class="logo">
							<img src="./images/logo.png" style="width:100%" />
						</div>
						<div class="content">
							<div class="inner">
								<h1>BDE ISIMA</h1>
								<p><!--[-->Découvre la vie étudiante d'un ZZ (étudiant de l'ISIMA) dès maintenant ! <!--]--></p>
							</div>
						</div>
						<nav>
							<ul>
								<li><a href="#actus">News</a></li>
								<!--<li><a href="#bde">Le BDE</a></li>-->
								<li><a href="#clubs">Clubs</a></li>
								<li><a href="./espace_ZZ">Compte</a></li>
                                                                <li><a href='https://drive.google.com/drive/folders/0B8UQ_-N6TCbvRDZEcUtTS1hWc2M?usp=sharing'>Annales</a></li>
								<li><a href="#contact">Contact</a></li>
							</ul>
							<p><br /><a href="#actus"><em>DERNIERE NEWS: <?php echo api("get_news", array("nombre" => 1))['liste'][0]['titre']; ?></em></a></p>
						</nav>
					</header>

				<!-- Main -->
					<div id="main">

							<article id="actus">
								<?php /*include "pages/actus.php";*/ ?>Chargement de la section différé...
							</article>

							<article id="bde">
								<?php include "pages/bde.php"; ?>
							</article>

							<article id="clubs">
								<?php /*include "pages/clubs.php";*/ ?>Chargement de la section différé...
							</article>

							<article id="contact">
								<?php include "pages/contact.php"; ?>
							</article>

							<article id="zz">
								<?php include "pages/zz.php"; ?>
							</article>
							
							<article id="partenaires">
								<?php /*include "pages/partenaires.php";*/ ?>Chargement de la section différé...
							</article>

							<article id="details_club">
								<?php include "pages/details_club.php"; ?>
							</article>

							<article id="oubli">
								<?php include "pages/oubli.php"; ?>
							</article>

							<article id="create_account">
								<?php include "pages/create_account.php"; ?>
							</article>

					</div>

				<!-- Footer -->
					<footer id="footer">
						<p class="copyright">&copy; BDE ISIMA. Design: <a href="https://html5up.net">HTML5 UP</a>.
						<br />Créé par BDE BliZZard. <a href="#partenaires">Nos partenaires</a></p>
					</footer>

			</div>

		<!-- BG -->
			<div id="bg"></div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
			<script src="assets/js/scripts.js"></script>
			<script>function load_section(section){$.ajax('pages/'+section+'.php').done(function(data){$('#'+section).html(data);});}window.onload = setTimeout("load_section('actus');load_section('clubs');load_section('partenaires')",4000)</script>
			<?php include ("./script_indispensable.php"); ?>

	</body>
</html>
