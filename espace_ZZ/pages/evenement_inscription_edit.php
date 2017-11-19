<?php
	if(!isset($user['autorisations']['club']))
	{
		echo "<h2>Accès refusé !</h2><p>Vous devez être membre du BDE pour voir ça</p>";
		exit();
	}
?>

<?php
	if(!isset($_GET['id']) || !is_numeric($_GET['id']))die("Accès refusé !");
	$infos = api("get_info_evt", array("id" => $_GET['id']));
?>

<script>
	function print_evt(){
		popup("\
		<a class='button' href='assets/php/print_evt.php?id=<?= $_GET['id']; ?>&token=<?= $_SESSION['token'];?>&order=NULL'>Tri par nom</a>\
		<a class='button' href='assets/php/print_evt.php?id=<?= $_GET['id']; ?>&token=<?= $_SESSION['token'];?>&order=commande'>Tri par date</a>\
		");
	}
</script>
<a class='button' href='evenement_inscription.<?= $infos['id_club']; ?>'>Retour</a>
<a class='button' onclick='evt_change_settings(<?= $_GET['id']; ?>)'>Modifier les paramètres</a>
<a class='button' onclick='evt_encaisse_bde(<?= $_GET['id']; ?>)'>Encaisser les cartes BDE</a>
<a class='button' onclick='evt_edit_article(<?= $_GET['id']; ?>)'>Modifier les articles</a>
<a class='button' onclick='evt_get_stats(<?= $_GET['id']; ?>)'>Statistiques</a>
<a class='button' onclick='print_evt()'>Imprimer</a>

<?php

	$liste = api("evt_get_liste_inscrits", array("token" => $_SESSION['token'], "id_evt" => $_GET['id']));
	
	
	echo "<div style='overflow-x:auto;'><table class='overflowtable'>
		<tr>
			<td>#</td>
			<td>Nom</td>
			<td>Article</td>
			<td>Qte</td>
			<td>Qte payé</td>
			<td>Paiement</td>
			<td>Commentaires</td>
			<td>Options</td>
		</tr>
	
	";
	
	foreach($liste['liste'] as $l){
		if(!empty($l['nom_membre']))$nom = $l['nom_membre'];
		else $nom = $l['prenom']." ".$l['nom'];
		
		
		echo "<tr>
			<td>".$l['id']."</td>
			<td>".$nom."</td>
			<td>".$l['nom_article']."</td>
			<td>".$l['qte']."</td>
			<td>".$l['qte_paye']."</td>
			<td>".($l['paiement']=="1" ? "Carte BDE":"Liquide")."</td>
			<td>".$l['commentaire']."</td>
			<td>
				<button style='width:100%' onclick='encaisse_cmd(".$l['id'].", ".($l['qte'] - $l['qte_paye']).")'>Encaisser</button>
				<br /><button style='width:100%' onclick='annuler_cmd_club(".$l['id'].")'>Annuler commande</button></td>
		</tr>
		";
		
	}
	
	
	echo "</table></div>";
