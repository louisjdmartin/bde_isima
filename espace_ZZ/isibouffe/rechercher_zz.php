<?php include "header.html";

// RECHERCHE UN ZZ EN TAPANT SON NOM, PRENOM, SURNOM OU UNE PARTIE -> FONCTIONNE

//POUVOIR EXTRAIRE UN PDF DES RESULTATS


?>

	


<div class="formulaire">

			<div class="form-style-8">
				<form action="rechercher_zz.php" method="GET"><br>
		
					<h2>Rechercher un zz</h2>
					<form>
						<input name="zz" placeholder="ZZ">
						<input type="submit" value="Valider"><br><br>
	
						<input name="promo" placeholder="Promo">
						<input type="submit" value="Valider"><br><br>
	
						<input name="smax" placeholder="Solde max €">
						<input type="submit" value="Valider"><br><br>
					</form>
				</form>
			</div>





			<?php

			// si on a rentré un nom de zz

			if (isset ($_GET['zz'])&& !empty($_GET['zz']))
			{

				$conditions = "nom LIKE '%%'";
	
				$mots = explode(" ",$_GET['zz']);
				foreach($mots as $mot)
				{
					$conditions .= "AND (nom LIKE '%".addslashes($mot)."%' OR prenom LIKE '%".addslashes($mot)."%' OR surnom LIKE '%".addslashes($mot)."%') ";
				}
	


				$info_zz = $donnees->query('SELECT * FROM isibouffe_zz WHERE '.$conditions);
				
				while ($info4 = $info_zz->fetch())

				{
	
			?>


		
						<a class="lien" href='zz.php?id_zz=<?php echo $info4['id']; ?>'> <!-- on créé un lien -->


							<strong><?php echo $info4['nom']?> <?php echo $info4['prenom']; ?></strong>
							<i><?php echo $info4['surnom']; ?></i>
							Promo <?php echo $info4['promo']; ?>

							Solde : <?php echo $info4['solde']; ?> € 

						</a>

				   </div>
				   
				
		
				<?php

				//afficher l'historique du zz
					
				
				
					$info_hist = $donnees->query('SELECT * FROM isibouffe_historique, isibouffe_article WHERE isibouffe_historique.id_zz='.$info4['id'].' AND isibouffe_historique.id_article=isibouffe_article.id_article' );
		
					

					while ($info5=$info_hist->fetch())

					{
					?>

						<div class="zz">
						<br />	

							<i><?php echo $info5['date'];?></i><br />						

							<?php echo $info5['quantite']; ?>  <?php echo $info5['nom_article']; ?> à <?php echo $info5['prix_article']; ?> €<br />
				
							<strong>Solde</strong> : <?php echo $info5['solde']; ?> €<br />	
		
						<br />	
					   </div>

					<?php

					}$info_hist->closeCursor();
				
				
				
				}
	
				$info_zz->closeCursor();
			}
			
		
			?>
			
			<?php

			// si on a rentré une promo -> fonctionne

			if (isset ($_GET['promo'])&& !empty($_GET['promo']))
			{	
	
				$info_promo = $donnees->query('SELECT * FROM isibouffe_zz WHERE promo = "'.$_GET['promo'].'" ORDER BY promo, nom');
				
				?>

				<table class="table-fill">
					<thead>
						<tr>
							<th class="text-left">Nom</th>
							<th class="text-left">Prenom</th>
							<th class="text-left">Surnom</th>
							<th class="text-left">Promo</th>
							<th class="text-left">Solde</th>
						</tr>
					</thead>


				<?php



				while ($info1 = $info_promo->fetch())

				{
	
			?>
					<tbody class="table-hover">
					<tr>
						<td class="text-left"><?php echo $info1['nom']?></td>
						<td class="text-left"><?php echo $info1['prenom']; ?></td>
						<td class="text-left"><?php echo $info1['surnom']; ?></td>
						<td class="text-left"><?php echo $info1['promo']; ?></td>
						<td class="text-left"><?php echo $info1['solde']; ?></td>
					</tr>
				   
			<?php
	
				}

			$info_promo->closeCursor();

			}
			?>

				</tbody>
			</table><br><br><br><br><br>
			
			<?php
			
			
			
			
			// si on a rentré un solde max -> fonctionne


			if (isset ($_GET['smax'])&& !empty($_GET['smax']))
			{	
	
				$info_solde = $donnees->query('SELECT * FROM isibouffe_zz WHERE solde <= '.$_GET['smax'].' ORDER BY promo, nom');
				
				?>

				<table class="table-fill">
					<thead>
						<tr>
							<th class="text-left">Nom</th>
							<th class="text-left">Prenom</th>
							<th class="text-left">Surnom</th>
							<th class="text-left">Promo</th>
							<th class="text-left">Solde</th>
						</tr>
					</thead>


				<?php

				while ($info7 = $info_solde->fetch())

				{
	
			?>

				<tbody class="table-hover">
					<tr>
						<td class="text-left"><?php echo $info7['nom']?></td>
						<td class="text-left"><?php echo $info7['prenom']?></td>
						<td class="text-left"><?php echo $info7['surnom']?></td>
						<td class="text-left"><?php echo $info7['promo']?></td>
						<td class="text-left"><?php echo $info7['solde']?></td>
					</tr>

					
				   
				<?php
	
				}

			$info_solde->closeCursor();
			
			?>

				</tbody>
			</table><br><br><br><br><br>

			<?php
			}



			?>
			

</div>



