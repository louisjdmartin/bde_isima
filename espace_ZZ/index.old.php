<?php
	session_start();
	require "../api/api.php";
	
	
	if(isset($_GET['token']))$_SESSION['token']=$_GET['token'];
	else if(isset($_COOKIES['token'])) $_SESSION['token'] = $_COOKIES['token'];
	
	
	
	if(empty($_SESSION['token']))
	{
		header('location:../#zz');
		die();
	}
/*setcookie("token", $SESSION['token'], time()+24*3600);*/
	$user = authentification($_SESSION['token']);
	
	
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
	
	$pages = array(
		"carte" => "Cartes BDE"
	);
	
	if(!isset($pages[$_GET['page']])){
	  if(isset($_GET['from']) && $_GET['from']=='planning_maker'){header('location:../planning_maker');die();}
	        header('location:./?page=carte');
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
	</head>
	<body class="no-sidebar">
		<div id="page-wrapper">

			<!-- Header -->
				<div id="header-wrapper">
					<?php include "header.php"; ?>
				</div>

			<!-- Main -->
				<div id="main-wrapper">
					<div class="container">
						<div id="content">
							<?php include "./pages/".$_GET['page'].".php"; ?>
						</div>
					</div>
				</div>
				<div id="fond_popup"></div>
				<div id="popup"></div>
				<div id="fond_load"></div>
				<div id="load"><h3>Traitement en cours...</h3><p>Merci de patienter...</p></div>
				<div id="fin_load"><h3>Traitement terminé</h3><p id="fin_load_msg">&nbsp;</p></div>
				<div id="close_popup">X</div>
				<input id="token" type="hidden" value="<?= $_SESSION['token']; ?>" />
			</div>

		<!-- Scripts -->

			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>
			<script src="assets/js/script.js"></script>
			<?php if(isset($_GET['fast_add_articles']) and $solde['solde']>0 and isset($user['autorisations']['bde'])) { ?>
				<script>
					get_all_articles(<?= $carte; ?>);
				</script>
			<?php } ?>
			<?php if(isset($_GET['fast_add_articles']) and $solde['solde']<0 and isset($user['autorisations']['bde'])) { ?>
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
										<li>© BDE ISIMA, Design: <a href="http://html5up.net">HTML5 UP</a><br />Créé par BDE BliZZard</li>
									</ul>
								</div>
							</div>
						</div>
					</footer>
				</div>
	</body>
</html>
	<?php } ?>