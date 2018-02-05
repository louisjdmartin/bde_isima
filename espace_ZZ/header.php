<header id="header" class="container">

	


	<!-- Logo -->
		<div id="logo">
			<?php 
				if(troll_mode($user)){
					echo '<h1><a href="."><img id="logo_img" src="../images/polytech_lite.gif" style="border-radius:128px;" height=128 /></a></h1>';
				}
				elseif(isset($user['autorisations']['romane'])){
					echo '<h1><a href="."><img id="logo_img" src="../easter_eggs/franck_romane.gif" style="border-radius:4px;"  height=128 /></a></h1>
					<style>
						#header-wrapper{background: url(../easter_eggs/fond_romane.png) repeat;}
						#nav{background: rgba(255,255,255,.9);border-radius:4px;}
					</style>
					';
				}
				else{
					echo '<h1><a href="."><img id="logo_img" src="../images/logo.png"  height=128 /></a></h1>';
				}
			?>
		</div>





	<!-- Nav -->
		<nav id="nav">
			<ul>
				<li>Bonjour <?php echo $user['prenom']." ".$user['nom']; if($user['surnom'])echo " (".$user['surnom'].")"; ?></li>
				
				<?php if(isset($user['autorisations']['bde']))
						 echo "<li>La session expire ". date_joli($user['expiration'])."</li>
							   "; 
				?><li>
					<a href="#">Accès ZZ</a>
					<ul>
						<li><a href="carte">Carte BDE</a></li>
						<li><a href="javascript:virement_choix_carte()" onclick='virement_choix_carte()'>Envoyer de l'argent</a></li>
						<li><a href="solde_isibouffe">Carte ISIBOUFFE</a></li>
						<li><a href="inscription">S'inscrire à un événement</a></li>
						<li><a href="records">Records du BDE</a></li>
						<li><a href="articlesbde">Articles en vente au BDE</a>
						<li><a href="calendrier">Calendrier</a></li>
						<li><a href="annales">Annales</a></li>
						<li><a href="change_pwd">Modifier le mot de passe</a></li>
						
					</ul>
				</li>
				<li>
				<?php if(isset($user['autorisations']['club']) and !isset($user['autorisations']['listeux'])) { ?>
					<a href="#">Accès association/club</a>
					<ul>
						<!--<li><a href="#">Modifier un club</a>
							<ul>
								<li><a href="#">BDS</a></li>
								<li><a href="#">ISIBOUFFE</a></li>
								<li><a href="#">ISIGALA</a></li>
								<li><a href="#">MUZZIC</a></li>
								<li><a href="#">ISIMALT</a></li>
								<li><a href="#">IMAGE</a></li>
								<li><a href="#">REZZO</a></li>
								<li><a href="#">ISILABS</a></li>
								<li><a href="#">#Flemme</a></li>
							</ul>
						</li>-->
						<li><a href="evenement_inscription">Gestion des inscriptions</a></li>
						<li><a href="agenda">Agenda des clubs</a></li>
						<li><a href="edit_club">Modifier le club</a></li>
						<li><a href="edit_events">Gestion calendrier</a></li>
					</ul>
				</li>
				
				<?php } if(isset($user['autorisations']['bde']) and !isset($user['autorisations']['listeux'])) { ?>
				<li>
					<a href="#">Accès BDE</a>
					<ul>
				        <li><a href="http://louis.elol.fr/bde/planning_maker">Planning Maker</a></li>
						<li><a href="articles">Gestion des articles</a></li>
						<li><a href="membres">Gestion des membres</a></li>
						<li><a href="gestion_clubs">Gestion des clubs</a></li>
						<li><a href="edit_partenaires">Gestion des partenaires</a></li>
						<li><a href="edit_news">Gestion des news</a></li>
						<li><a href="statistiques" onclick="load()">Statistiques</a></li>

					</ul>
				</li>
				<?php } ?>
				<?php if(isset($user['autorisations']['bde']) and isset($user['autorisations']['listeux'])) { ?>
				<li>
					<a href="#">Accès Listeux</a>
					<ul>
						<li><a href="cartes">Gestion des cartes</a></li>
						<li><a href="articles">Gestion des articles</a></li>
						<li><a href="agenda">Agenda des clubs</a></li>
						<li><a href="statistiques" onclick="load()">Statistiques</a></li>

					</ul>
				</li>
				<?php } ?>
				<li><a href="close.php">Quitter</a></li>
			</ul>
		</nav>

</header>
