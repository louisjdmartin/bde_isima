<?php
	if(is_numeric($_GET['c']))$c=$_GET['c'];
	else $c=0;
	$clubs = api("get_club", array('id'=>$c));
?>
<h2 class="major" id="club_nom"><?= $clubs['liste'][0]['nom'] ?></h2>
<span class="image main" id="club_img"><img style='float:left;width:33%;margin:0 16px 16px 0' src="<?= $clubs['liste'][0]['img'] ?>" /></span>
<p id="club_presentation"><?= zcode($clubs['liste'][0]['presentation']) ?></p>
<p><a onclick="load_section('clubs')" href='#clubs'>Retour</a></p>
