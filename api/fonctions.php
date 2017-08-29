<?php
	function date_joli($time)
	{
		$mois = array(NULL, "jan.", "fev.", "mars", "avril", "mai", "juin", "juil.", "aout", "sept.", "oct.", "nov.", "dec.");
		$jours = array("dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi", "dimanche");
		$retour = " Le ".$jours[intval(date("w", $time))] . " " . date('d', $time) . " " . $mois[intval(date("m", $time))] . " à ". date("H:i", $time);
		if(date("Y-m-d")==date("Y-m-d", $time))$retour = " Aujourd'hui à ". date("H:i", $time);
		if(date("Y-m")==date("Y-m", $time)   && intval(date("d"))-1==intval(date("d", $time)))$retour = " Hier à ". date("H:i", $time);
		return $retour;
	}
	function createRandomPassword() {

		$chars = "abcdefghijkmnopqrstuvwxyz023456789";
		srand((double)microtime()*1000000);
		$i = 0;
		$pass = '' ;

		while ($i <= 7) {
		    $num = rand() % 33;
		    $tmp = substr($chars, $num, 1);
		    $pass = $pass . $tmp;
		    $i++;
		}

		return $pass;
	}
	function carte_utilise($c, $id=-12346547654346)
	{
		global $bdd;
		$carte = $bdd->query("SELECT numero FROM membres WHERE numero=".$c." AND NOT id=".$id);
		foreach($carte as $c){return true;}
		return false;	
	}
	function solde($solde)
	{
		return '<span style="color:'.($solde>=0 ? "green":"red").'">'.($solde>=0 ? "+":"") . $solde.'€</span>';
	}
	function grade($g)
	{
			 if($g==0) return "ZZ";
		else if($g==1) return "Club";
		else if($g==2) return "BDE";
		else 		   return "Grade non défini: $g";
	}
	function annee_scolaire()
	{
		if (date('m') >= 9)
		{
			return date('Y') + 1;
		}
		else
		{
			return date('Y');
		}
	}
	function zcode($texte){
		$texte = htmlentities($texte, ENT_NOQUOTES, 'UTF-8');
		$texte = preg_replace('#\[lien\=(.+)\](.+)\[\/lien\]#iUs', '<a href="$1" target="blank">$2</a>', $texte);
		$texte = preg_replace('#\[gras\](.+)\[\/gras\]#iUs', '<strong>$1</strong>', $texte);
		$texte = preg_replace('#\[b\](.+)\[\/b\]#iUs', '<strong>$1</strong>', $texte);
		$texte = preg_replace('#\[italique\](.+)\[\/italique\]#iUs', '<em>$1</em>', $texte);
		$texte = preg_replace('#\[souligne\](.+)\[\/souligne\]#iUs', '<span style="text-decoration:underline;">$1</span>', $texte);
		$texte = preg_replace('#\[couleur\=(.+)\](.+)\[\/couleur\]#iUs', '<span style="color:$1;">$2</span>', $texte);
		$texte = preg_replace('#\[list\](.+)\[\/list\]#iUs', '<ul>$1</ul>', $texte);
		$texte = preg_replace('#\[li\](.+)\[\/li\]#iUs', '<li>$1</li>', $texte);
		$texte = preg_replace('#\[youtube\](.+)\[\/youtube\]#iUs', '<iframe style="max-width:100%" width="420" height="315" src="$1" frameborder="0" allowfullscreen></iframe>', $texte);
		$texte = nl2br($texte);
		return($texte);
	}
	function send_mail($mail, $sujet, $contenu)
	{
		 $headers ='From: "BDE ISIMA"<bde@poste.isima.fr>'."\n";
		 $headers .='Reply-To: bdeisima@gmail.com'."\n";
		 $headers .='Content-Type: text/html; charset="utf-8"'."\n";
		 $headers .='Content-Transfer-Encoding: 8bit';

		 $message ='<html><head><title>Site BDE</title></head><body><div style="padding-bottom: 30px; text-align: center;"><img src="http://img11.hostingpics.net/pics/636594logo.jpg" alt="Logo BDE" width="200" height="200" /></div><div style="padding: 30px; border-top: 3px  solid  black;"></div>'.$contenu.'<br /><br /><div style="padding: 30px; border-top: 3px  solid  black;"></div>
		 
		 
		 <em>Ceci est un mail automatique, il est inutile de répondre. En cas de soucis, allez voir un membre du BDE.</em>
		 </body></html>';
		 return mail($mail, $sujet, $message, $headers);
	}

	function club_selector($titre, $user)
	{
		
		$id=null;
		if(isset($user['autorisations']['club']))
		{
			
			if(!isset($_GET['id'])){
				echo "<h2>".$titre."</h2>
				<script>function edit_this_club(){
					club = $('#club_id').val();
					window.location = './".$_GET['page'].".'+club;
				}</script>
				";
				$clubs = api("get_club_gere", array("token" => $_SESSION['token']));
				echo "
					<form action='./' method='get'>
						<input type='hidden' name='page' value='".$_GET['page']."' />
						<select name='id' id='club_id' onchange='edit_this_club();'><option>Choisir un club:</option>
				";
				$count = 0;
				foreach($clubs['liste'] as $club)
				{
					echo "<option value='".$club['id']."'>".$club['nom']."</option>";	
					$count ++;
				}
				echo "</select></form>";
				if($count==1)echo "Chargement...<script>window.location='./".$_GET['page'].".".$club['id']."'</script>";
			}else 
			{	
				$clubs = api("get_club_gere", array("token" => $_SESSION['token']));
				foreach($clubs['liste'] as $club)
					if(isset($_GET['id']) && $_GET['id'] == $club['id']){
						$id=$_GET['id'];
						echo "<h2>".$titre." (".$club['nom'].")</h2>";
					}
				if($id==null)echo "<strong>Accès refusé:</strong> Ce club n'existe pas ou vous n'avez pas le droit de le modifier.<script>setTimeout(\"window.location='./".$_GET['page']."'\", 5000);</script>";
			}
		
		}
		return $id;
	}


class Date {

	function getAll($year){
		$r = array();
		$date = strtotime("$year-01-01 12:00:00");
		while(date("Y", $date)==$year) {
			$y = date("Y", $date);
			$m = date("n", $date);
			$d = date("j", $date);
			$w = str_replace("0", "7", date("w", $date));
			$r[$y][$m][$d] = $w;
			$date+=24*3600;
		}
		return $r;
	}

}








