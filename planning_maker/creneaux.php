<?php
include("inc/bdd.php");
if(isset($_POST['mode']))
{
	if($_POST['mode'] == 'add')
	{
		$bdd->query("INSERT INTO creneaux VALUES (NULL, '".addslashes($_POST['deb'])."', '".addslashes($_POST['fin'])."', '".addslashes($_POST['jours'])."', '".addslashes($_POST['poids'])."' )");
	}
	elseif(is_numeric($_POST['mode']))
	{
		$bdd->query("UPDATE creneaux SET c_deb='".addslashes($_POST['deb'])."' WHERE c_id=".$_POST['mode']);
		$bdd->query("UPDATE creneaux SET c_fin='".addslashes($_POST['fin'])."' WHERE c_id=".$_POST['mode']);
		$bdd->query("UPDATE creneaux SET c_jour='".addslashes($_POST['jours'])."' WHERE c_id=".$_POST['mode']);
		$bdd->query("UPDATE creneaux SET c_poids='".addslashes($_POST['poids'])."' WHERE c_id=".$_POST['mode']);
		
		if($_POST['action'] == "Effacer")
		{
			$bdd->query("DELETE FROM creneaux WHERE c_id=".$_POST['mode']);
		}
	}
	header("location:./creneaux.php");
}
include "inc/head.php";


?>
	<center><strong>Ajouter</strong><br />	
	<form method="POST" action="creneaux.php">
		<input type="hidden" value="add" name="mode" />
		<input name="deb" type="text" placeholder="Début: xxhxx"  autofocus />
		<input name="fin" type="text" placeholder="Fin: xxhxx" />
		<input name="poids" type="text" placeholder="Poids" />
		<?php select("jours", $jours); ?>
		<input type="submit" value="Ajouter" />
	</form>
	<?php
	
		$creneaux = $bdd->query("SELECT * FROM creneaux ORDER BY c_jour, c_deb");
		$last_day=-1;
		foreach ($creneaux as $c){
			if($last_day!=$c['c_jour'])
			{	
				$last_day = $c['c_jour'];
				echo "<br /><strong>".$jours[$c['c_jour']]."</strong><br />";
			}
			?>
				<form method="POST" action="creneaux.php">
					<input type="hidden" value="<?= $c['c_id']; ?>" name="mode"/>
					<input name="deb" type="text" placeholder="Début: xxhxx"  value="<?= $c['c_deb']; ?>"/>
					<input name="fin" type="text" placeholder="Fin: xxhxx"  value="<?= $c['c_fin']; ?>"/>
					<input name="poids" type="text" placeholder="Poids"  value="<?= $c['c_poids']; ?>"/>
					<?php select("jours", $jours, $c['c_jour']); ?>
					<input type="submit" name="action" value="Enregistrer" />
					<input type="submit" name="action" value="Effacer" />
				</form>
			<?php
		}
	
	?>
	
	
	</center>
