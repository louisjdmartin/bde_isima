<?php
	if(!isset($user['autorisations']['bde']))die("Cette page est réservée au BDE !");
	function show_stats($deb)
	{
		$stat = api("statistiques", array("token" => $_SESSION['token'], "mode" => "ventes", "deb" => $deb, "fin" => time()));
		echo "<table>";
		echo "<tr>
			<td><strong>Article</strong></td>
			<td><strong>Nb ventes</strong></td>
			<td><strong>Gain</strong></td>
		</tr>";
		foreach ($stat['liste'] as $s)
		{
			echo "<tr>
				<td>".$s['nom']."</td>
				<td>".$s['nombre']."</td>
				<td>".$s['gain']."</td>
			</tr>";
		}
		echo "</table>";
	}
?>


	<div class="row 200%">
		<div class='fixed_nav'>
			<a href="#ventes">Ventes</a>
			<a href="#etat">Etat des cartes</a>
			<a href="#neg">Négatifs</a>
			<a href="#cotisations">Cotisations</a>
		</div>
		<div class="8u 12u$(medium) important(medium)">
			<h3 id="ventes">Ventes</h3>

			Choisir une periode: <select onchange="show_stats()" id="selected_stat">
				<option value='today'>Aujourd'hui</option>
				<option value='week'>Cette semaine</option>
				<option value='7day'>7 derniers jours</option>
				<option value='month'>Mois en cours</option>
				<option value='30day'>30 derniers jours</option>
				<option value='all'>Depuis toujours</option>
			</select>



			<div id="today" class="stats">
				<?php
					show_stats(strtotime(date("Y-m-d")));
				?>
			</div>

			<div id="week" class="stats">
				<?php
					show_stats(strtotime("last Monday"));
				?>
			</div>
			
			<div id="7day" class="stats">
				<?php
					show_stats(time()-7*24*3600);
				?>
			</div>

			<div id="month" class="stats">
				<?php
					show_stats(strtotime(date("Y-m")."-01"));
				?>
			</div>

			<div id="30day" class="stats">
				<?php
					show_stats(time()-30*24*3600);
				?>
			</div>
			
			<div id="all" class="stats">
				<?php
					show_stats(0);
				?>
			</div>
			<h3 id="cotisations">Cotisations</h3>
			<?php 
				$cotisations = api("statistiques", array("token"=>$_SESSION['token'], "mode"=>"cotisations"));
				foreach($cotisations['liste'] as $c){
					echo "Promo ".$c['annee'].": ".$c['nombre']." cotisant(s)<br />";
				}
			?>
			
			
		</div>
		<div class="4u 12u$(medium) ">
			<h3 id="etat">Etat des cartes</h3>
			   <?php
				 $etat = api("statistiques", array("token"=>$_SESSION['token'], "mode"=>"etat"));
					 echo "<table><tr><td>Total positif:</td><td>".solde($etat['total-positif'])."</td></tr><tr><td>Total négatif:</td><td> ".solde($etat['total-negatif'])."</td></tr><tr><td>Total: </td><td>".solde($etat['total'])."</td></tr></table>";
			   ?>
			<h3 id="neg">Soldes négatifs</h3>
			<div id="negatifs">
			   <?php
					if(isset($_GET['promo']))$promo=$_GET['promo'];
					else $promo = "all";
					
					echo "
						<form action='./' id='form' method='get' onsubmit='load()'>
							<input type='hidden' value='statistiques' name='page' />
							<input type='number' value='".$promo."' name='promo' placeholder='Filtre par promo' />
							<a href='./?page=statistiques' onclick='load()'>Toutes les promos</a>
							<a onclick='load();document.getElementById(\"form\").submit();'>Filtrer</a>
						</form>
					";
					
					
					$liste_negatif = api("statistiques", array("token"=>$_SESSION['token'], "mode"=>"liste-negatif", "promo" => $promo));
					foreach($liste_negatif['liste'] as $n){
						echo "<span style='color:red; width: 64px; display:inline-block;'>".$n['solde']."€</span> ".$n['prenom']." ".$n['nom']." (carte ".$n['carte'].")<br />";
					}
					if($liste_negatif['nb_elt']==0) echo "AUCUN NEGATIFS #Miracle";
				   ?>
			</div>
		</div>
