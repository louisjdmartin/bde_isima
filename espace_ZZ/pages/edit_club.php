<?php
	$id=club_selector("Modification d'un club", $user);

	if($id!=null)
	{
		echo "<a class='button' href='./edit_club'>Editer un autre club</a>";
		if(isset($user['autorisations']['bde']))
			echo "
				<a class='button' onclick='changer_proprietaire(".$_GET['id'].")'>Changer le propriétaire</a>
			";
		else echo "
				<a class='button' onclick='popup(\"<h3>Changement de propriétaire</h3>Le BDE peut changer le mail associé à ce club. Si cela est nécessaire, demandez à un membre du BDE de le faire pour vous.<br />Vous ne pouvez pas réaliser cette action par vous même car la procédure nécessite des droits que vous ne possédez pas.\")'>Changer le propriétaire</a>
			";
		$club = api("get_club", array('id' => $id));
		$club = $club['liste'][0];
		echo " 
			
				<a class='button' onclick='popup($(\"#mise_en_page\").html());'>Mettre en page</a>			
				<a class='button' onclick='save_club(".$id.")'>Sauvegarder</a>
				<br /><br />



<div id='mise_en_page' style='display:none'><h3>Balises de mises en page</h3>
<pre>
[lien=http(s)://www.site.com]Lien vers un site[/lien]
[gras]Texte en gras[/gras]
[b]Texte en gras[/b]
[italique]Texte en italique[/italique]
[souligne]Texte souligné[/souligne]
[couleur=#AABBCC]Texte en couleur (#hexa) => <a href='https://www.google.fr/?gfe_rd=cr#newwindow=1&q=%23aabbcc' target='_blank'>cf ce lien</a>[/couleur]
[list]
	[li]Liste à puce[/li]
	[li]Liste à puce[/li]
[/list]
</pre>
</div>


		<form onsubmit='valide_modif_club()'>
			<div class='row 200%'>
				<div class='4u 12u$(medium) important(medium)'>
					<h3>Informations sur le club</h3>
					<label for='club_name'>Nom du club</label><input type='text' id='club_name' value=\"".$club['nom']."\" />
					
					<label for=''>Image</label><input value='".$club['img']."'  type='text' id='img_club' disabled /><input type='file' name='file' id='btn_upload' />
					<div id='progress' class='progress'><div class='progress-bar progress-bar-success'></div></div>

					
					<label for='fb'>Facebook</label><input type='text' id='fb' value=\"".$club['facebook']."\" />
					<label for='twitter'>Twitter</label><input type='text' id='twitter' value=\"".$club['twitter']."\" />
					<label for='googleplus'>Google +</label><input type='text' id='googleplus' value=\"".$club['googleplus']."\" />
				</div>	
				<div class='8u 12u$(medium) important(medium)'>
					<h3>Description du club</h3>
					<input type='text' id='desc_courte' value=\"".$club['description_courte']."\" />
					<textarea style='height:500px;' id='presentation'>".$club['presentation']."</textarea>
				</div>			
			</div>
		</form>
		";
	}

?>



<script>
$('#btn_upload').fileupload({
	url: "./assets/php/upload.php",
	dataType: 'html',
	done: function (e, data) {
		if(data.result=="")alert("Fichier refusé !\nTaille trop importante, erreur d'upload ou extension non correcte (png, jpg, jpeg)");
		$('#img_club').val(data.result);
		console.log(data);
	},
	progressall: function (e, data) {
		var progress = parseInt(data.loaded / data.total * 100, 10);
		if(progress==100){
			$('#progress .progress-bar').css(
			'background',
			'lightblue'
		);
		}
		$('#progress .progress-bar').css(
			'width',
			progress + '%'
		);
	}
});
</script>
