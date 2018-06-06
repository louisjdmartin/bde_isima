<h2 class="major">Partenaires</h2>
<p>Voici la liste des partenaires qui soutiennent notre BDE.</p>
<?php require '../api/api.php';
	$parts = api("get_liste_partenaires");
	foreach($parts['liste'] as $n)
	{
		?>
		<form>
			<h3><?= $n['nom']; ?></h3>
			<div class="field half first">
				<span class="image main"><img src="<?= $n['img']; ?>" alt="" /></span>
			</div>
			<div class="field half">
				<p style='text-align:justify'><?= zcode($n['description']); ?></p>
			</div>
			<div style='clear:both'></div>
		</form>
	<?php } ?>
