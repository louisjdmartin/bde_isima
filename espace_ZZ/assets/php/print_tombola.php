<?php
require '../../../api/api.php';
$liste = api("evt_get_liste_inscrits", array("token" => $_GET['token'], "id_evt" => $_GET['id']));
echo "<body onload='window.print()'><meta charset='utf-8'>

<style>
	tr,td,table{border-collapse:collapse;border:1px solid black; padding:4px;text-align:center}
	td{width:20%;padding:32px}
	table{page-break-inside:avoid}
	.count{font-size:24px;}
</style>
<nobr><table> <tr>";

$maxCols = 4;
$counter = 0;
$cols = 0;
foreach($liste['liste'] as $l)
	for($i=1;$i<=$l['qte'];$i++)
	{
		if(!empty($l['nom_membre']))$nom = $l['nom_membre'];
		else $nom = $l['prenom']." ".$l['nom']; 
		$counter++;
		$cols++;
		if($cols==$maxCols+1){
			echo "</tr></table><table><tr>";
			$cols=1;
		}
		echo "<td><span class='count'>$counter </span><br /><span class='name'>$nom</span><br><em>".$l['nom_article']."</em></td>";

	}

if($cols<$maxCols+1)for($i=$cols;$cols<$maxCols;$cols++)echo "<td>&nbsp;</td>";
echo "</tr></table>";
