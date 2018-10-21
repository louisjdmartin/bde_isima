<?php 
	$carte = $user['carte'];
	$nom = api("get_nom_by_carte", array("numero" => $carte))[0];
	if($nom == 'null')die("<h2>Carte BDE</h2><h3>Impossible de trouver cette carte !</h3><p>Redirection...</p><script>setTimeout(\"window.location='.'\", 2000);</script>");
?>
<script>
	function associer_isibouffe(onlyone){
		popup("<h3></h3>\
				<form onsubmit='return false;'><input onkeyup='search_carte(false)' type='text' id='search' autofocus placeholder='Rechercher une carte'/><input onclick='search_carte(false)' type='submit' value='Chercher'/></form><div id='search_results'>");	
		$.post("../api/ajax/get_nom_by_carte",{numero:<?php echo $carte;?>, token:$('#token').val()}).done(function(data){
			data=JSON.parse(data);
			$('#search').val(data[0].split('(')[0]);
			search_carte(onlyone);
		});
	}
	function search_carte(onlyone){
		$.post("../api/ajax/cherche_carteisibouffe",{q:$('#search').val(), token:$('#token').val()}).done(function(data){
			data=JSON.parse(data);
			$('#search_results').html("");
			console.log(data.nb_elt);
			for(i=0;i<data.nb_elt;++i){
				$('#search_results').append("<br/><a onclick='confirm_associer("+data.liste[i].id_isibouffe+")'>Associer la carte: "+data.liste[i].nom+" "+data.liste[i].prenom+" ("+data.liste[i].solde+"€)</a><br />");
			}
			if(data.nb_elt==1 && onlyone)confirm_associer(data.liste[0].id_isibouffe);
		});
	}
	function confirm_associer(id_isibouffe){
		load();
		$.post("../api/ajax/cherche_carteisibouffe",{q:id_isibouffe, token:$('#token').val(), "force_number":"true"}).done(function(data){	
			fin_load();
			data=JSON.parse(data);
			popup("<h3>Associer ma carte isibouffe</h3>Confirmer l'association avec la carte suivante:<br />"+data.liste[0].nom+" "+data.liste[0].prenom+" ("+data.liste[0].solde+"€)<br/><button onclick='finalize_associer("+id_isibouffe+")'>Associer</button><button onclick='associer_isibouffe(false)'>Chercher une autre carte</button>");
		});
	}
	function finalize_associer(id_isibouffe){
		$.post("../api/ajax/associer_isibouffe",{id_isibouffe:id_isibouffe, token:$('#token').val()}).done(function(data){	
			window.location.reload();
		});
	}
	function dissocier(){
		if (confirm("Voulez vous vraiment dissocier votre carte ? Cela n'affectera pas le solde et l'historique de cette carte."))
		finalize_associer(0);	
	}
</script>
<article>

	<h2>Carte ISIBOUFFE</h2>

	
	<div class="row 200%">
		<div class="4u 12u$(medium) important(medium)">
			<h3>Carte</h3>
			
			
			<?php 
				$solde = api("get_solde_isibouffe", array("token" => $_SESSION['token'])); 
				if($solde['error']){?>
			<p style='text-align:justify'>
				<?php echo $solde['msg'];?><br />
				<a onclick='associer_isibouffe(true)'>Cliquez ici pour associer votre carte isibouffe</a>
			</p>
			<?php }else{
			?>
			<p>
				<span id="affichage_solde">
					<strong>Solde isibouffe</strong>: <?php echo solde($solde['solde']); ?>
					<br /><a onclick='dissocier()'>Dissocier ma carte isibouffe</a>
				</span>
				<br /><a href='carte'>Voir ma carte BDE</a>
			</p>
				<?php  } ?>
		</div>
		<div class="4u 12u$(medium)">
			<h3>Consommations</h3><em>Bientôt dispo...</em>
				<!--<ul id="ul_consos">
					
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
				<a onclick="get_all_consos(<?= $carte; ?>); return false;" href="#">Voir tout</a>-->
		</div>
		<div class="4u 12u$(medium)">
			<h3>Recharges</h3><em>Bientôt dispo...</em><!--
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
				<a onclick="get_all_recharges(<?= $carte; ?>); return false;" href="#">Voir tout</a>-->
		</div>
	</div>
</article>
