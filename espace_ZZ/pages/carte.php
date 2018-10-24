<?php 
	$carte = $user['carte'];
	if(isset($user['autorisations']['bde']) AND isset($_GET['carte']))
		$carte = $_GET['carte'];
	$nom = api("get_nom_by_carte", array("numero" => $carte))[0];
	if($nom == 'null')die("<h2>Carte BDE</h2><h3>Impossible de trouver cette carte !</h3><p>Redirection...</p><script>setTimeout(\"window.location='.'\", 2000);</script>");
?>
<article>

	<h2>Carte BDE</h2>

	
	<div class="row 200%">
		<div class="4u 12u$(medium) important(medium)">
			<h3>Carte</h3>
			
			
			<?php 
				if(isset($user['autorisations']['bde']))
					$solde = api("get_solde", array("token" => $_SESSION['token'], "numero" => $carte)); 
				else
					$solde = api("get_solde", array("token" => $_SESSION['token'])); 
			?>
			<p>
				<strong>Carte n°<?= $carte ?>: </strong>
				<span id="affichage_solde">
					<?php echo solde($solde['solde']); ?>
				</span>
				<?php if(isset($user['autorisations']['bde'])) { ?>
					<br /> <strong>Propriétaire</strong> <?php echo $nom; ?>
					<form action="." method="GET" onsubmit="return false;">
						<input type="hidden" value="carte" name="page" />
						<input type="hidden" value="true" name="fast_add_articles" />
						<input type="text" id="carte" name="recherche" placeholder="Rechercher" required autofocus autocomplete="off" />
						<div id="resultats"></div>
					</form>
				<?php } ?>
					<br /><a href='carteisibouffe'>Voir ma carte isibouffe</a>

			</p>
		</div>
		<div class="4u 12u$(medium)">
			<h3>Consommations</h3>
	  <?php if(isset($user['autorisations']['bde'])) { 
				echo "<a href='#' onclick='get_all_articles($carte); return false'>Ajouter une conso</a>";
			} ?>
				<ul id="ul_consos">
					
					<?php 
						if(isset($user['autorisations']['bde']))
							$consos = api("get_log_consos", array("token" => $_SESSION['token'], "numero" => $carte, "nombre" => 5));
						else 
							$consos = api("get_log_consos", array("token" => $_SESSION['token'], "nombre" => 5));
						
						
						if($consos['nb_elt']>0)foreach ($consos['liste'] as $r) 
							echo '<li><span style="display:inline-block;width:60px">'.solde(-$r['tarif']).'</span>
						'.$r['article'].'
						<br />
						<span style="display:inline-block;width:60px;">&nbsp;</span>'.date_joli(strtotime($r['date'])).'
						</li>';
						else echo "<li>Carte jamais utilisée</li>"
					?>
					
				</ul>
				<a onclick="get_all_consos(<?= $carte; ?>); return false;" href="#">Voir tout</a>
		</div>
		<div class="4u 12u$(medium)">
			<h3>Recharges</h3>
				<?php if(isset($user['autorisations']['bde'])) { 
					echo "<a href='#' onclick='recharge($carte); return false'>Recharger la carte</a>";
				} ?>
				<ul id="ul_recharge">
					
					<?php 
						if(isset($user['autorisations']['bde']))
							$recharges = api("get_log_recharges", array("token" => $_SESSION['token'], "numero" => $carte));
						else 
							$recharges = api("get_log_recharges", array("token" => $_SESSION['token']));
						
						
						if($recharges['nb_elt']>0)foreach ($recharges['liste'] as $r) 
							echo '<li><span style="display:inline-block;width:64px;color:'.($r['montant']>0 ? "green":"red").'">'.($r['montant']>0 ? "+":"").($r['montant']).'€</span> 
						'.date_joli(strtotime($r['date'])).'</li>';
						else echo "<li>Carte jamais utilisée</li>"
					?>
					
				</ul>
				<a onclick="get_all_recharges(<?= $carte; ?>); return false;" href="#">Voir tout</a>
		</div>
	</div>
</article>
