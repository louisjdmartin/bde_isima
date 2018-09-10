<?php
	if(!isset($_GET['id'])){
		$liste = api("get_liste_evt");
		echo "<h2>Formulaires d'inscriptions</h2>";
		
		echo "<div class='row 200%'>";
		
		if($liste['nb_elt'] == 0) echo "<div class='4u 12u$(medium) important(medium)'>Aucun événement à venir !</div>";
		else foreach($liste['liste'] as $evt)
		{
			$club = api("get_club", array("id" => $evt['id_club']))['liste'][0];
			
			
			echo "
			<div class='4u 12u$(medium) important(medium)'>
				<h3>".$evt['nom']."</h3>
				Organisé par ".$club['nom']."<br />
				Date événement: ".date_joli(strtotime($evt['date_event']))."<br />
				Inscription avant: ".date_joli(strtotime($evt['date_limite_commande']))."<br />
				<a class='button' href='./inscription.".$evt['id']."'>S'inscrire</a>
			</div>
			";
		}
		
		echo '</div>';
	}
	
	else if(is_numeric($_GET['id'])){
		
		$evt = api("get_info_evt", array("id" => $_GET['id']));
		if($evt['error']){
			echo "<h2>Une erreur s'est produite</h2>";
			echo $evt['error_msg'];
			echo "<br /><a class='button' href='inscription'>Voir la liste des événements</a>";
		}
		else {
			echo "<h2>".$evt['nom']."</h2>";
			
			$places = api("evt_places_dispo", array("id_evt" => $_GET['id']));
			$inscrit= api("evt_deja_inscrit", array("token" => $_COOKIE['token'],"id_evt"=>$_GET['id']));

			if(strtotime($evt['date_limite_commande']) < time()){
				echo "Il est trop tard pour s'inscrire !";
			}
			else if($inscrit['bool'] && !isset($user['autorisations']['club']) || is_numeric($places['places']) && $places['places'] == 0 && isset($user['autorisations']['club'])){
				if(is_numeric($places['places']) && $places['places'] == 0) echo "Plus de places disponibles !<br>";
				echo "Vous êtes inscrit ! Pour modifier vous devez annuler l'inscription puis en faire une autre<table>
						<tr>
							<td>Nom</td>
							<td>Prix (€)</td>
							<td>Qté</td>
							<td>Commentaire</td>
						</tr>
		
				";
				foreach ($inscrit['liste'] as $e){
					echo "
						<tr>
							<td>".$e['nom']."</td>
							<td>".$e['prix']."</td>
							<td>".$e['qte']."</td>
							<td>".$e['commentaire']."</td>
						</tr>
					";
				}
				echo "</table><button onclick='annuler_inscription_evt(".$_GET['id'].")'>Annuler cette inscription</button>
				<br /> <br /> <a class='button' href='./inscription'>S'inscrire pour un autre événement.</a>
				";

			}
			else if(is_numeric($places['places']) && $places['places'] == 0) echo "Plus de places disponibles !";
			else{
				/*Tout est ok, on peut s'inscrire !*/
				?>
				<form onsubmit='return false;'>
			    <?php if(is_numeric($places['places'])) echo "Il reste ".$places['places']." place(s)"; ?>
				<!-- 
					Note a ceux qui lisent ça...
					Si vous voulez "hacker" le système, je vous en empêcherai pas, et il y aura surement des gens pour essayer, mais si vous trouvez une faille, signalez la faille
					Si vous l'exploitez ou que vous abusez du système, on enregistre qui fait les actions (souvenez vous, vous êtes identifié ;) ), donc on peut vous bloquer.
				-->
					<?php if(isset($user['autorisations']['club'])) { ?>



						<?php if($inscrit['bool']){ 
							echo "<br />Vous êtes déjà inscrit ! Pour modifier vous devez annuler l'inscription avant d'en faire une autre, vous pouvez inscrire quelqu'un d'autre<table>
									<tr>
										<td>Nom</td>
										<td>Prix (€)</td>
										<td>Qté</td>
										<td>Commentaire</td>
									</tr>
		
							";
							foreach ($inscrit['liste'] as $e){
								echo "
									<tr>
										<td>".$e['nom']."</td>
										<td>".$e['prix']."</td>
										<td>".$e['qte']."</td>
										<td>".$e['commentaire']."</td>
									</tr>
								";
							}
							echo "</table><button  onclick='annuler_inscription_evt(".$_GET['id'].")'>Annuler cette inscription</button><br /><hr /><br />";

						 } ?>



						<h3>Qui voulez vous inscrire ?</h3>
						<em>Vous voyez ceci car vous êtes enregistré comme club ou BDE</em><br />
						<?php if(!$inscrit['bool']){ ?><input type='radio' name='who' id='moi' checked onclick='$("#info_other,#info_carte_other").hide();$("#carteBDE").show()'/><label for='moi' class='inline' >Inscription pour moi</label><br /><br /><?php } ?>


						<input type='radio' name='who' id='other_bde'  <?php if($inscrit['bool']) echo "checked"; ?>  onclick='$("#carteBDE,#info_carte_other").show();$("#other_carte").focus();$("#info_other").hide()' /><label for='other_bde' class='inline'>Inscrire quelqu'un par son numéro de carte</label><br /><br />


						<input type='radio' name='who' id='other' onclick='$("#info_other").show();$("#other_name").focus();$("#carteBDE,#info_carte_other").hide()' /><label for='other' class='inline'>Inscrire quelqu'un d'autre</label>


						<div id='info_other' style='display:none'>
							<input type='text' name='other_name' id='other_name' placeholder='Saisir un nom' />
							<em>ATTENTION: le paiement par carte BDE n'est pas possible !  </em>
						</div>
						<div id='info_carte_other' <?php if(!$inscrit['bool']) { ?>style='display:none' <?php } ?>>
							<input type='text' name='other_carte' id='other_carte' onkeyup="cherche_carte()" placeholder='Saisir un numéro de carte ou chercher un nom' />
							<div id="resultats"></div>

						</div><div style='height:64px'></div>

						<hr />

						
						<div style='clear:both'></div>
					<?php } ?>
				<div class='row 200%' id='articles'>
					<?php
						$liste = api("get_liste_articles_evt", array("id_event" => $_GET['id']));

						foreach ($liste['liste'] as $art){
							echo "
								<div class='4u 12u$(medium) important(medium)'>
									<h3 id='name".$art['id']."'>".$art['nom']."</h3>
									<a id='btn_cmd_".$art['id']."' class='button' onclick='commander(".$art['id'].")'>Ajouter (".$art['prix']."€)</a>
									<a id='btn_suppr_".$art['id']."' class='button' onclick='suppr_cmd(".$art['id'].")' style='display:none'></a>
									<div id='art".$art['id']."' style='display:none'>
									Qté voulu: <input type='number' value='0' min='0' max='".$art['qte_dispo']."' id='qte".$art['id']."' /><br />
									Commentaire 
									</div><input type='text' id='comment".$art['id']."' style='display:none' placeholder='Aucun commentaire' /><br />
								</div>
							";
						}				
					?><div style='clear:both'></div>
					<p><button onclick='$("#articles,#validation").toggle();show_commande(<?php echo $_GET['id']; ?>);'>Voir le panier</button></p>
				</div>
				<div id='validation' style='display:none;'>
					<h3>Validation</h3>
					
					<div id='recap'></div>
					<br /><br />
					
					
					<h3>Payer en carte bde ?</h3>
					<div id='carteBDE'>
						<?php
							if($evt['carte_bde_possible']=='1'){
								$solde = api("get_solde", array("token" => $_SESSION['token'])); 
								echo "
								<input type='radio' name='bde' id='bde'  /><label for='bde' class='inline' >Oui</label>
								<input type='radio' name='bde' id='pasBDE' checked /><label for='pasBDE' class='inline'>Non</label><br />
								
								";
							}else echo "Vous ne pouvez pas payer avec la carte BDE (option non disponible)";
						?>
					</div><div id='noCarteBDE'>Vous ne pouvez pas payer avec la carte BDE (solde insuffisant)</div>
					    <?php echo "Solde actuel: ". solde($solde['solde']); ?>
					<br /> <br />
					<br /><button onclick='$("#articles,#validation").toggle()'>Revenir en arrière</button>
					<button onclick='valide_commande(<?php echo $_GET['id']; ?>)'>Passer la commande</button>
					
				</div>
				</form>
				<?php
			}
		}
	}
	
	else echo "<h2>URL NON VALIDE !</h2>";
?>

<script>
	function commander(id){
		name = $('#name'+id).html();
		html = "<h2>"+name+"</h2><h3>Quantité:</h3>"
		i = 0;
		while (i<4){
			i = i+1;
			html = html + "<a class='button' onclick='add_article_commande("+id+","+i+")' style='display:inline-block; width: 54px;'>" + i + "</a> &nbsp;"
		}
		html += "<a class='button' onclick='add_article_commande("+id+", 0)' style='display:inline-block; width: 54px;'>+</a> &nbsp;"
		html += "<br /><em>Vous pouvez ajouter un commentaire après avoir choisi la quantité.</em>"
		popup(html);
	}
	function add_article_commande(id_art, qte){
		name = $('#name'+id_art).html();
		if (qte==0){
			popup("<h2>"+name+"</h2><h3>Quantité:</h3><form onsubmit='add_article_commande("+id_art+", -1);return false'><input id='qteplus'  type='number'/><a class='button' onclick='add_article_commande("+id_art+", -1)'>Continuer</a></form>")
			$('#qteplus').focus()
		}
		if (qte==-1){
			qte = $('#qteplus').val()
		}
		if(qte > 0){
			$('#qte'+id_art).val(qte);
			$('#btn_cmd_'+id_art).hide();
			$('#btn_suppr_'+id_art).show();
			$('#btn_suppr_'+id_art).html("Supprimer du panier <br />("+qte+" commandé(s))");
			html = "<h2>"+name+" à été ajouté au panier</h2>"
			html +="<form onsubmit='valide_com("+id_art+");return false'><input type='text' placeholder='Un commentaire ?' id='comm'/></form><a class='button' onclick='valide_com("+id_art+")'>Ajouter le commentaire</a><br /><a onclick='close_popup()'>Passer</a>"
			popup(html)
			$('#comm').focus()
			$('#comment'+id_art).show()
		}
	}
	function valide_com(id_art){
		close_popup()
		$('#comment'+id_art).val($('#comm').val())
	}
	
	function suppr_cmd(id_art){
		$('#btn_cmd_'+id_art).show();
		$('#btn_suppr_'+id_art).hide();
		$('#comment'+id_art).hide()
		
		$('#comment'+id_art).val("")
		$('#qte'+id_art).val(0);
	}
</script>


























