<h2 class="major">Vie associative</h2>
<p>La vie associative est un aspect très important du BDE, quelque soit tes passions tu trouveras forcément un club qui te plaira !</p>
<?php require '../api/api.php';
	$clubs = api("get_liste_clubs_actifs");
	foreach ($clubs['liste'] as $c)
	{
		echo "<form><div class='field half first'><span class='image'><img style='width:100%;' src='".$c['img']."' /></span></div>";
		echo "<div class='field half'><h2>".$c['nom']."</h2>";
		echo "<p>".(zcode($c['description_courte']))."</p>";
		echo "<p><a href='?c=".($c['id'])."#details_club'>En savoir plus</a></p>";
		echo '<ul class="icons">';
			if(!empty($c['twitter']))echo '<li><a href="'.$c['twitter'].'" class="icon fa-twitter"><span class="label">Twitter</span></a></li>';
			if(!empty($c['facebook']))echo '<li><a href="'.$c['facebook'].'" class="icon fa-facebook"><span class="label">Facebook</span></a></li>';
		echo '</ul></div><div style="clear:both"></div></form>';
	}
	
?>
<blockquote>
	<a href="https://www.youtube.com/watch?v=QKzsdpZ74x0&feature=youtu.be&t=52">ISIMALT, ISIBOUFFE, ISIOKE, Pas venu là simplement pour programmer...</a><br />
	<span style='float:right'>BDE GriZZlys - 2013</span>
</blockquote>
<h3>Voir aussi:</h3>
<a href="#partenaires">Nos partenaires</a>
