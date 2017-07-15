<h2>Calendrier du ZZ</h2><div class="calendrier">
<?php
	$events = api("get_liste_events");
	$liste = array();
	foreach($events['liste'] as $e)
	{
		$liste[strtotime(date("Y-m-d", strtotime($e['debut'])))][] = array("nom" => $e['nom'], "deb"=>$e['debut'], "fin"=>$e['fin'], "club"=>$e['club']);	
	}
	
	$date = new Date();
	$year = date("Y");
	if(isset($_GET['id']) && is_numeric($_GET['id']))$year=$_GET['id'];
	$dates= $date->getAll($year);
	$mois = array("jan.", "fev.", "mars", "avril", "mai", "juin", "juil.", "aout", "sept.", "oct.", "nov.", "dec.");
		$jours = array("lun", "mar", "mer", "jeu", "ven", "sam", "dim");
?>
	<div class="periods">
		<div class='year'>
			<span style='color: #888888'><a href='calendrier.<?= $year-1; ?>'><?= $year-1; ?></a></span>
			<?= $year; ?>
			<span style='color: #888888'><a href='calendrier.<?= $year+1; ?>'><?= $year+1; ?></a></span>
		</div><br />
		<div class='months'>
			<ul>
				<?php foreach ($mois as $id=>$m)echo "<li><a href='#' id='linkMonth".($id+1)."'>$m</a></li>"; ?>
			</ul>
		</div>
	</div>
	<?php
		$dates = current($dates);
		foreach($dates as $m=>$days){
			echo "
				<div class='month' id='month$m'>
					<table>
						<thead><tr>";
						foreach($jours as $j)echo "<th>$j</th>";
						echo "</tr></thead>
						<tbody><tr>";
						
						foreach($days as $d=>$w){
							if($d==1 && $w>1)
								echo "<td colspan=".($w-1)." class='padding'></td>";



							if(isset($liste[strtotime("$year-$m-$d")])){ echo "
								<td onclick='popup($(\"#$year-$m-$d\").html())'><div class='relative'>
									<div class='day'>$d</div>
								</div><ul class='events relative'><li></li></ul>
								<div style='display:none' id='$year-$m-$d'><h3>&Eacute;vénement(s) du $d ".$mois[$m-1]."</h3>";
								foreach($liste[strtotime("$year-$m-$d")] as $evt){
									echo "<strong>".$evt['nom']."</strong> (".$evt['club'].") à partir de ".date("H:i", strtotime($evt['deb']))." et jusqu'au ".date("d/m/Y H:i", strtotime($evt['fin']))."<br />";
								}
								echo "</div>";
							}


							else echo "<td><div class='relative'><div class='day'>$d</div></div>";				

							echo "</td>";
							if($w==7) echo "</tr><tr>";
						}
						echo "</tr></tbody>
					</table>
				</div>
			";
		}
	?>
</div>
<script>
	$(function(){
		$('.month').hide();
		$('#month<?php echo date('n'); ?>').show();
		$('#linkMonth<?php echo date('n'); ?>').addClass('active');
		var current = <?php echo date('n'); ?>;
		$('.months a').click(function(){
			var month = $(this).attr('id').replace('linkMonth', '');
			$('#month'+current).hide();
			$('#month'+month).show();
			$('.months a').removeClass('active');
			$('#linkMonth'+month).addClass('active');
			current=month;
			return false;
		});
	});
</script>
