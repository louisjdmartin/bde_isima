<?php
	$fonctions = scandir("./api");
	if(empty($_GET['voir'])){
		foreach($fonctions as $fonction){
			if(is_file("./api/".$fonction)){
				$fonction_et_php = explode(".", $fonction);
				$fonction = $fonction_et_php[0];
				echo "<a href='?voir=$fonction'>$fonction</a><br />";
			}
		}
	}
	else{
		echo "<meta charset='utf8' /><a href='.'>Retour</a><hr />";
		if(is_file("api/".$_GET['voir'].".php")){
			$file = fopen("api/".$_GET['voir'].".php", 'r');
			$ligne=fgets($file);
			$ligne=fgets($file);
			echo "<pre>";
			while($ligne and !strstr($ligne,"*/")){
				if(!strstr($ligne,"/*"))echo $ligne;
				$ligne = fgets($file);
			}
			echo "</pre>";
		}
	}
	
?>