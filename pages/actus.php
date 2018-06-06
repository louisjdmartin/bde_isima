<h2 class="major">Actualitées</h2>
<?php require '../api/api.php';
	$news = api("get_news");
	foreach($news['liste'] as $n)
	{
		?>
		<form>
			<h3><?= $n['titre']; ?></h3>
			<div class="field half first">
				<span class="image main"><img src="<?= $n['img']; ?>" alt="" /></span>
			</div>
			<div class="field half">
				<p style='text-align:justify'><?= zcode($n['texte']); ?></p>
			</div>
			<div style='clear:both'></div>
		</form>
	<?php } ?>
