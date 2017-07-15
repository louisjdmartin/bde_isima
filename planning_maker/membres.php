<?php
include("inc/bdd.php");
if(isset($_POST['mode']))
{
	if($_POST['mode'] == 'add')
	{
		$bdd->query("INSERT INTO membres VALUES (NULL, '".addslashes($_POST['membre'])."', NOW())");
	}
	elseif(is_numeric($_POST['mode']))
	{
		$bdd->query("UPDATE membres SET m_nom='".addslashes($_POST['membre'])."' WHERE m_id=".$_POST['mode']);
		
		if($_POST['action'] == "Effacer")
		{
			$bdd->query("DELETE FROM membres WHERE m_id=".$_POST['mode']);
		}
	}
	header("location:./membres.php");
}
include "inc/head.php";


?>
	<center>
	<form method="POST" action="membres.php">
		<input type="hidden" value="add" name="mode" />
		<input name="membre" type="text" placeholder="Ajouter quelqu'un"  autofocus />
		<input type="submit" value="Ajouter" />
	</form>
	<?php
	
		$membres = $bdd->query("SELECT * FROM membres ORDER BY m_nom");
		foreach ($membres as $c){
			?>
				<form method="POST" action="membres.php">
					<input type="hidden" value="<?= $c['m_id']; ?>" name="mode"/>
					<input name="membre" type="text" placeholder="Nom"  value="<?= $c['m_nom']; ?>"/>
					<input type="submit" name="action" value="Enregistrer" />
					<input type="submit" name="action" value="Effacer" />
					<?= $c['last_modif']; ?>
				</form>
			<?php
		}
		
	?>
	Heure serveur: <?php echo date("Y-m-d H:i:s"); ?>
	
	
	
	
	
	
	</center>
