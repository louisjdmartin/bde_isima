<?php $articles=api("get_liste_articles");
echo '<div id="liste_articles"><h2>Liste des articles en vente au BDE</h2>';
foreach($articles['liste'] as $a)
{
	echo '<span class="article" style="width:200px!important"><img src="'.$a['img'].'" /><br/>'.$a['nom'].' ('.$a['tarif'].' €)</span>';
}
echo '</div>';
