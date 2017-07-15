function popup(html)
{
	$('#popup').html(html);
	$('#fond_popup').fadeIn(1500);
	$('#popup,#close_popup').fadeIn(200);
}
function close_popup(){
	$('#fond_popup,#close_popup').fadeOut(200);
	$('#popup').fadeOut(200);
	$('#carte').focus();
}
function load(){
	
	$('#load,#fond_load').show();
}
var fin_load_timeout;
function fin_load(html){
	$('#load,#fond_load').hide();
	$('#fin_load').hide().slideDown(300)
	clearInterval(fin_load_timeout);
	$('#fin_load_msg').html(html);
	fin_load_timeout = setTimeout("$('#fin_load').slideUp(200);", 5000);
}

function get_all_recharges(numero)
{
	popup("<h3>Chargement...</h3><ul id='liste_recharges'></ul>");
	$.getJSON('../api/ajax/get_log_recharges', {nombre: 1000, token: $('#token').val(), numero:numero}).done(function(data){
		html = "<h3>Historique</h3><ul id='liste_recharges'>";
		for(i=0;i<data.nb_elt;i++){
			if(data.liste[i].montant>0)html = html + '<li><span style="display:inline-block;width:64px;color:green">+'+data.liste[i].montant+'€</span>';
			if(data.liste[i].montant<0)html = html + '<li><span style="display:inline-block;width:64px;color:red">'+data.liste[i].montant+'€</span>';
			
			html = html + " le " + data.liste[i].date + "</li>";
		}
		html = html + "</ul>";
		$('#popup').html(html);
	});
}
function get_all_consos(numero)
{
	popup("<h3>Chargement...</h3><ul id='liste_recharges'></ul>");
	$.getJSON('../api/ajax/get_log_consos', {nombre: 1000, token: $('#token').val(), numero:numero}).done(function(data){
		html = "<h3>Historique</h3><ul id='liste_recharges'>";
		for(i=0;i<data.nb_elt;i++){
			html = html + '<li><span style="display:inline-block;width:64px;color:red">-'+data.liste[i].tarif+'€</span>';
			
			html = html + data.liste[i].article + " le " + data.liste[i].date ;
			if(data.liste[i].anciensolde>0)html = html + " (ancien solde:  <span style='display:inline-block;color:green'>" + data.liste[i].anciensolde+"€</span>)</li>";
			if(data.liste[i].anciensolde<0)html = html + " (ancien solde: <span style='display:inline-block;color:red'>" + data.liste[i].anciensolde+"€</span>)</li>";
		}
		html = html + "</ul>";
		$('#popup').html(html);
	});
}

function get_all_articles(numero){
	popup("<h3>Chargement...</h3><div id='liste_articles'></ul>");
	$.getJSON('../api/ajax/get_liste_articles').done(function(data){
		html = "<h3>Encaisser sur la carte <a onclick='autre_carte();return false;' href='#' style='text-decoration:underline'>"+numero+"</a> /  <a onclick='recharge("+numero+");return false;' href='#' style='text-decoration:underline'>Recharger</a></h3><div id='liste_articles'>";
		for(i=0;i<data.nb_elt;i++){
			html = html + '<span class="article" onclick="encaisser('+numero+', '+data.liste[i].id+')"><img src="'+data.liste[i].img+'" /><br />'+data.liste[i].nom+' ('+data.liste[i].tarif+'€)</span>';
			
		}
		html = html + "</div>";
		$('#popup').html(html);
	});
}
function encaisser(carte, article)
{
	load();
	$.getJSON('../api/ajax/encaisser_article', {carte: carte, id_article: article, token: $('#token').val()}).done(function(data){
		if(data.solde>0){ $('#affichage_solde').html('<span style="color:green">+'+data.solde+'€</span>'); }
		else {$('#affichage_solde').html('<span style="color:red">'+data.solde+'€</span>');}
		html_ul = $('#ul_consos').html();
		html = '<li><span style="display:inline-block;width:60px;color:red">-'+data.tarif+'€</span> ';
		html = html + data.nom;
		html = html + '<br><span style="display:inline-block;width:60px;">&nbsp;</span> &Agrave; l\'instant</li>';
		$('#ul_consos').html(html + html_ul);
		$('#ul_consos li:last').remove()
		if(data.solde>=0)fin_load("Nouveau solde: "+data.solde+"€");
		else fin_load("<strong>ATTENTION ! SOLDE NEGATIF</strong>")
	});
}
function recharge(numero){
	html = "<h3>Recharger la carte <a onclick='autre_carte();return false;' href='#' style='text-decoration:underline'>"+numero+"</a></h3>";
	html = html + "<form onsubmit='rechargement("+numero+");return false;'>";
	html = html + "<input type='text' placeholder='Saisir un montant' id='montant_recharge' required />";
	html = html + "<input style='float:right;' type='submit' value='Recharger' />";
	html = html + "</form>";
	popup(html);
	$('#montant_recharge').focus();
}
function rechargement(numero){
	montant = $('#montant_recharge').val();
	close_popup();
	load();
	$.getJSON('../api/ajax/recharge_carte', {carte: numero, montant: montant, token: $('#token').val()}).done(function(data){
		if(data.reussi==false){fin_load("<strong>IT'S A FAIL !</strong> Un truc n'a pas marché, t'as bien entrée un nombre ?")}
		else {
			if(data.solde>0){ $('#affichage_solde').html('<span style="color:green">+'+data.solde+'€</span>'); }
			else {$('#affichage_solde').html('<span style="color:red">'+data.solde+'€</span>');}
			html_ul = $('#ul_recharge').html();
			if(montant>0)html = " <li><span style='width:60px;display:inline-block;color:green'>+" + montant+"€ </span>";
			else html = " <li><span style='width:60px;display:inline-block;color:red'>" + montant+"€ </span>";
			html = html + ' à l\'instant</li>';
			$('#ul_recharge').html(html + html_ul);
			$('#ul_recharge li:last').remove()
			if(data.solde>=0)fin_load("Nouveau solde: "+data.solde+"€");
			else fin_load("<strong>ATTENTION ! SOLDE NEGATIF</strong>")
		}
	});
}
function autre_carte()
{
	close_popup();
	$('#carte').focus();
}
var xhr;
function cherche_carte()
{
    if(xhr)xhr.abort();
	q = $('#carte').val();
	html = "<input type='hidden' value='-1' id='index_cherche' />";
	if(q.length > 0)xhr = $.getJSON('../api/ajax/cherche_carte', {q:q, token:$('#token').val()}).done(function(data){
		for(i=0;i<data.nb_elt;i++){
		    html = html + "<span class='nom_recherche' onclick='$(\"#carte\").val(\""+data.liste[i].carte+" "+data.liste[i].prenom+"\");cherche_carte();'>"  + data.liste[i].nom+' '+data.liste[i].prenom+' '+data.liste[i].surnom+' '+data.liste[i].carte +'</span>';
		}
		if(data.nb_elt==0){
			html = "Aucun résultat.";
		}
		if(data.nb_elt>20){
			html = data.nb_elt + " résultats.";
		}
		$('#resultats').html(html);
		if(data.nb_elt==1)window.location="./?page=carte&fast_add_articles=true&carte="+data.liste[0].carte;
	});
	else $('#resultats').html("");
}
function edit_article(id, nom, img, tarif)
{
	if(id==0)efface_button="";
	else efface_button = "<a style='float:left' class='button' href='#' onclick='$(\"#nom_art\").val(\"\");valide_article();'>Effacer</a>";
	popup("<h3>Edition d'article</h3>\
	<form onsubmit='valide_article();return false;'>\
	<input value='"+id+"' type='hidden' id='id_art' />\
	<label for=''>Image</label><input value='"+img+"'  type='text' id='img_art' disabled /><input type='file' name='file' id='btn_upload' />\
	<div id='progress' class='progress'><div class='progress-bar progress-bar-success'></div></div>\
	<label for='nom_art'>Nom</label><input value='"+nom+"'  type='text' id='nom_art' />\
	<label for='tarif_art'>Tarif</label><input value='"+tarif+"'  type='text' id='tarif_art' />\
	\
	<a style='float:right' class='button' href='#' onclick='valide_article()'>Sauvegarder</a>&nbsp;\
	"+efface_button+"\
	</form>\
	");
	$('#btn_upload').fileupload({
			url: "./assets/php/upload.php?id="+id,
			dataType: 'html',
			done: function (e, data) {
				if(data.result=="")alert("Fichier refusé !\nTaille trop importante, erreur d'upload ou extension non correcte (png, jpg, jpeg)");
				$('#img_art').val(data.result);
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
}

function edit_membre(id, nom, prenom, surnom, mail, carte, promo, grade, cotisation)
{
	if(id==0)efface_button="";
	else efface_button = "Pour effacer un membre remplace son nom par SUPPR_MEMBER\nATTENTION: le compte ne sera pas effacé si il est associé à un club";
	
	if(grade == 1)club = "selected";else club= "";
	if(grade == 2)bde = "selected";else bde= "";
	
	popup("<h3>Edition d'un membre</h3>\
	<form onsubmit='valide_membre();return false;'>\
	<input type='hidden' value='"+id+"' id='id_mb' />\
	<label for='nom_art'>Nom</label><input value='"+nom+"'  type='text' id='nom_mb' />\
	<label for='nom_art'>Prénom</label><input value='"+prenom+"'  type='text' id='prenom_mb' />\
	<label for='nom_art'>Surnom</label><input value='"+surnom+"'  type='text' id='surnom_mb' />\
	<label for='nom_art'>Mail</label><input value='"+mail+"'  type='text' id='mail_mb' />\
	<label for='nom_art'>Carte</label><input value='"+carte+"'  type='text' id='carte_mb' />\
	<label for='nom_art'>Promo</label><input value='"+promo+"'  type='text' id='promo_mb' />\
	<label for='nom_art'>Grade</label><select id='grade_mb'>\
	<option value='0'>ZZ</option>\
	<option value='1' "+club+">Club</option>\
	<option value='2' "+bde+">BDE</option>\
	</select>\
	<label for='nom_art'>Cotisation (<a onclick='maj_cotisation();return false;'>mettre à jour la cotisation</a>)</label><input disabled value='"+cotisation+"'  type='text' id='cotisation_mb' />\
	\
	<a style='float:right' class='button' href='#' onclick='valide_membre()'>Sauvegarder</a>&nbsp;\
	"+efface_button+"\
	</form>\
	");
}
function add_membre()
{
	
	popup("<h3>Ajout d'un membre</h3>\
	<form onsubmit='valide_add_membre();return false;'>\
	<input type='hidden' value='0' id='id_mb' />\
	<label for='nom_art'>Nom</label><input  type='text' id='nom_mb' />\
	<label for='nom_art'>Prénom</label><input type='text' id='prenom_mb' />\
	<label for='nom_art'>Mail</label><input type='text' id='mail_mb' />\
	<label for='nom_art'>Promo</label><input type='text' id='promo_mb' />\
	<br /><strong>Solde initial</strong>: 0<br /> <strong>grade</strong>: ZZ<br /> <strong>Marqué comme cotisant</strong> <br />\
	<em>L'ajout peut prendre un peu de temps.</em>\
	<a style='float:right' class='button' href='#' onclick='valide_add_membre()'>Ajouter</a>&nbsp;\
	</form>\
	");
	$('#nom_mb').focus();
	$.ajax("./assets/php/cotisation.php").done(function(data){$('#promo_mb').val(parseInt(data)+2);});
}

function valide_add_membre(){
	
	load();
	$.getJSON('../api/ajax/modifier_membre',
		{
			token : $('#token').val(),
			id : 0,
			nom : $('#nom_mb').val(),
			prenom : $('#prenom_mb').val(),
			mail : $('#mail_mb').val(),
			promo : $('#promo_mb').val()
		}).done(function(data){
			if(data.error==0)
			{
				fin_load();
				popup("<h3>Membre ajouté !</h3><button onclick='add_membre();'>Ajouter un autre</button>");
			}
			else 
			{
				fin_load("<strong>ERREUR: </strong>"+data.msg);
			}
		});
}
function valide_membre(){
	
	load();
	$.getJSON('../api/ajax/modifier_membre',
		{
			token : $('#token').val(),
			id : $('#id_mb').val(),
			nom : $('#nom_mb').val(),
			prenom : $('#prenom_mb').val(),
			surnom : $('#surnom_mb').val(),
			mail : $('#mail_mb').val(),
			carte : $('#carte_mb').val(),
			promo : $('#promo_mb').val(),
			grade : $('#grade_mb').val(),
			cotisation : $('#cotisation_mb').val()
		}).done(function(data){
			if(data.error==0)
			{
				window.location.reload();
			}
			else 
			{
				fin_load("<strong>ERREUR: </strong>"+data.msg);
			}
		});
}
function maj_cotisation(){
	load();
	$.ajax("./assets/php/cotisation.php").done(function(data){$('#cotisation_mb').val(data);});
	$('#load,#fond_load').hide();
}
function valide_article()
{
	load();
	$.getJSON('../api/ajax/modifier_article', {id: $('#id_art').val(), img:$('#img_art').val(), tarif: $('#tarif_art').val(),nom: $('#nom_art').val(), token: $('#token').val()}, function(data){
		if(data.error==0)
		{
			window.location.reload();
		}
		else 
		{
			fin_load("<strong>ERREUR: </strong>"+data.msg);
		}
	});
	
}

function show_stats()
{
	stat = $('#selected_stat').val()
	$('.stats').hide();
	$('#'+stat).show();
}

function modif_pwd()
{
	token = $('#token').val();
	pwd = $('#pwd').val();
	pwd_c = $('#pwd_c').val();
	mail = $('#mail').val();
	clear = $('#deconnecter').is(':Checked');
	load();
	if(pwd == pwd_c)$.getJSON('../api/ajax/change_passwd', {token, token, mode: "change_passwd",pwd: pwd, clear_all_token: clear, mail:mail}, 	function(data){
		if(data.error==1)fin_load("<strong>ERREUR:</strong> verifiez votre mot de passe ou votre token");
		else {
			alert("Mot de passe changé ! Vous allez être redirigé, si vous avez choisi d'effacer toutes vos sessions, vous devrez vous re-connecter");
			window.location = "./";
		}
	});
	else alert("Mot de passes différents !");
}
function changer_proprietaire(id)
{
	popup("<h3>Changement de proprietaire</h3>\
			<form onsubmit='valide_changer_proprietaire();return false;'>\
			<input type='hidden' value='"+id+"' id='id_club' /><strong>Club: </strong><span id='nom_club'><em>Chargement...</em></span><br />\
			<label for='adr_pro'>Email du propriétaire du club</label><input  type='email' value='Chargement...' id='adr_pro' />\
			- Si l'email n'est pas associé à un compte, un compte <em>club <span id='nom_club2'></span></em> sera créé. <br />\
			- Le grade du membre sera changé en <em>club</em>.<br />\
			- Le grade de l'ancien propriétaire deviendra <em>ZZ</em><br />\
			- Il est conseillé d'utiliser le mail du club pour ce type de compte.\
			<a style='float:right' class='button' href='#' onclick='valide_changer_proprietaire()'>Valider</a>&nbsp;\
			</form>\
		");
	$.getJSON('../api/ajax/proprietaire_club', {id: id},function(data)
	{
		if(data.id==null){
			mail="";
			club=data.nom_club;
		}
		else{
			mail=data.mail;
			club=data.nom_club;
		}

		$('#nom_club').html(club);
		$('#nom_club2').html(club);
		$('#adr_pro').val(mail);

	});
}
function valide_changer_proprietaire()
{
	load();
	$.getJSON('../api/ajax/change_proprietaire_club',{
		token: $("#token").val(),
		id:$('#id_club').val(),
		mail:$('#adr_pro').val()	
	},function(data){window.location.reload();})
}

function save_club(id)
{
	load();
	$.post("../api/ajax/modifier_club",
		{
			token: $('#token').val(),
			nom: $('#club_name').val(),
			img: $('#img_club').val(),
			facebook: $('#fb').val(),
			twitter: $('#twitter').val(),
			googleplus: $('#googleplus').val(),
			description_courte: $('#desc_courte').val(),
			presentation: $('#presentation').val(),
			id: id
		},
	function(data){
		fin_load("Modifications enregistrées");
	});
}

function open_club()
{
	popup("<h3>Ouvrir un club</h3>\
	<form onsubmit='return false;'><label>Nom du club</label><input type='text' id='nom_club' />\
	<label>Mail du propriétaire</label><input type='email' id='email_club' />\
	- Si le mail n'est pas associé à un compte, un compte sera créé\
	<br />- Le grade du compte sera passé à <em>Club</em>\
	<br />- Le club sera visible sur le site\
	<br /><button style='float:right' onclick='valide_open_club();'>Continuer</button></form>\
	");
}

function valide_open_club()
{
	load();
	$.getJSON("../api/ajax/open_club",
	{token: $('#token').val(), nom: $('#nom_club').val(), mail: $('#email_club').val()},
	function(data){
		if(data.error==0)window.location= "./?page=edit_club&id="+data.id
		else fin_load("ERREUR, impossible d'ouvrir le club");		
	}
	);
}
function close_club(id)
{
	if(confirm("Voulez vous vraiment fermer ce club ?")){	
	load();
	$.getJSON("../api/ajax/close_club",
	{token: $('#token').val(), id:id},
	function(data){window.location.reload();});}
}

function add_event(id_club, id_event)
{
	popup("<h3>Gérer un événement</h3>\
	<form onsubmit='return false'>\
	<label>Nom de l'événement</label>\
	<input type='text' id='nom_event' />\
	<label>Date</label>\
	<input style='width:48%; display:inline;' type='text' id='event_deb' placeholder='Début' />\
	\
	<input style='width:48%; display:inline;' type='text' id='event_fin' placeholder='Fin' />\
	<label>Description</label><textarea id='desc_event' placeholder='Balises dispo: [gras][italique][souligne][b][couleur][lien][list][li]' style='height:64px;'></textarea>\
	<strong>RAPPEL: </strong> Si vous êtes un club, et pas une association, le BDE est juridiquement responsable de vos événements, tout événement doit se faire avec leur accord.\
	<br /><button onclick='valide_add_event("+id_club+","+id_event+");'>Enregistrer</button>\
	<button id='eff_button' onclick='if(confirm(\"Confirmer cet action\")){$(\"#nom_event\").val(\"DELETE_EVENT\");valide_add_event("+id_club+","+id_event+");}'>Effacer</button>");

	if(id_event !=0){
		$('#load').show();
		$.getJSON("../api/ajax/get_liste_events", {id: id_event},function(data){
			$('#nom_event').val(data.liste[0].nom);
			$('#event_deb').val(data.liste[0].debut);
			$('#event_fin').val(data.liste[0].fin);
			$('#desc_event').val(data.liste[0].description);
			$('#load,#fond_load').hide();
		});
	}else $('#eff_button').hide();
	$.timepicker.setDefaults($.timepicker.regional['fr']);
	var startDateTextBox = $('#event_deb');
	var endDateTextBox = $('#event_fin');

	startDateTextBox.datetimepicker({ 
		regional: 'fr',
		dateFormat: "yy-mm-dd",
		firstDay: 1,
		controlType: 'select',
		stepMinute: 1,
		numberOfMonths: 1,
		minDate: new Date(),
		oneLine: true,
		onClose: function(dateText, inst) {
			if (endDateTextBox.val() != '') {
				var testStartDate = startDateTextBox.datetimepicker('getDate');
				var testEndDate = endDateTextBox.datetimepicker('getDate');
				if (testStartDate > testEndDate)
					endDateTextBox.datetimepicker('setDate', testStartDate);
			}
			else {
				endDateTextBox.val(dateText);
			}
		},
		onSelect: function (selectedDateTime){
			endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate') );
		}
	});
	endDateTextBox.datetimepicker({ 
		controlType: 'select',
		dateFormat: "yy-mm-dd",
		stepMinute: 1,
		numberOfMonths: 1,
		firstDay: 1,
		minDate: new Date(),
		oneLine: true,
		onClose: function(dateText, inst) {
			if (startDateTextBox.val() != '') {
				var testStartDate = startDateTextBox.datetimepicker('getDate');
				var testEndDate = endDateTextBox.datetimepicker('getDate');
				if (testStartDate > testEndDate)
					startDateTextBox.datetimepicker('setDate', testEndDate);
			}
			else {
				startDateTextBox.val(dateText);
			}
		},
		onSelect: function (selectedDateTime){
			startDateTextBox.datetimepicker('option', 'maxDate', endDateTextBox.datetimepicker('getDate') );
		}
	});

}

function valide_add_event(id_club, id_event)
{
	if($("#event_deb").val() == "" || $("#event_fin").val() == "" || $("#nom_event").val() == "" || $('#desc_event').val() == "")
		return alert("Formulaire incomplet !");
	else{
		load();
		if($('#nom_event').val()=="DELETE_EVENT")$('#nom_event').val("");
		$.post("../api/ajax/modifier_event", {
			id: id_event,
			id_club: id_club,
			nom: $("#nom_event").val(),
			description: $("#desc_event").val(),
			date_deb: $("#event_deb").val(),
			date_fin: $("#event_fin").val(),
			token: $("#token").val()
		}, function(data){window.location.reload();});	
	}
}

function edit_partenaire(id){
	popup("<h3>Gerer un partenaire</h3>\
	<form onsubmit='valide_partenaire("+id+");return false'>\
	<label>Nom</label><input type='text' id='nom_part' />\
	<label for=''>Image</label><input type='text' id='img_part' disabled /><input type='file' name='file' id='btn_upload' />\
	<div id='progress' class='progress'><div class='progress-bar progress-bar-success'></div></div>\
	<label>Description</label><textarea id='desc_part' placeholder='Balises dispo: [gras][italique][souligne][b][couleur][lien][list][li]' style='height:64px;'></textarea></form>\
	<button id='eff_button' onclick='if(confirm(\"Confirmer cet action\")){$(\"#nom_part\").val(\"\");valide_partenaire("+id+");}'>Effacer</button>\
	<button onclick='valide_partenaire("+id+");'>Valider</button>");


	if(id !=0){
		$('#load').show();
		$.getJSON("../api/ajax/get_liste_partenaires", {id: id},function(data){
			$('#nom_part').val(data.liste[0].nom);
			$('#img_part').val(data.liste[0].img);
			$('#desc_part').val(data.liste[0].description);

			$('#load,#fond_load').hide();

		});
	}else $('#eff_button').hide();




	$('#btn_upload').fileupload({
			url: "./assets/php/upload.php?id="+id,
			dataType: 'html',
			done: function (e, data) {
				if(data.result=="")alert("Fichier refusé !\nTaille trop importante, erreur d'upload ou extension non correcte (png, jpg, jpeg)");
				$('#img_part').val(data.result);
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




}	
function edit_news(id){
	popup("<h3>Gerer une news</h3>\
	<form onsubmit='valide_news("+id+");return false'>\
	<label>Titre</label><input type='text' id='nom_part' />\
	<label for=''>Image</label><input type='text' id='img_part' disabled /><input type='file' name='file' id='btn_upload' />\
	<div id='progress' class='progress'><div class='progress-bar progress-bar-success'></div></div>\
	<label>Description</label><textarea id='desc_part' placeholder='Balises dispo: [gras][italique][souligne][b][couleur][lien][list][li]' style='height:64px;'></textarea></form>\
	<button id='eff_button' onclick='if(confirm(\"Confirmer cet action\")){$(\"#nom_part\").val(\"\");valide_partenaire("+id+");}'>Effacer</button>\
	<button onclick='valide_news("+id+");'>Valider</button>");


	if(id !=0){
		$('#load').show();
		$.getJSON("../api/ajax/get_news", {id: id},function(data){
			$('#nom_part').val(data.liste[0].titre);
			$('#img_part').val(data.liste[0].img);
			$('#desc_part').val(data.liste[0].texte);

			$('#load,#fond_load').hide();

		});
	}else $('#eff_button').hide();




	$('#btn_upload').fileupload({
			url: "./assets/php/upload.php?id="+id,
			dataType: 'html',
			done: function (e, data) {
				if(data.result=="")alert("Fichier refusé !\nTaille trop importante, erreur d'upload ou extension non correcte (png, jpg, jpeg)");
				$('#img_part').val(data.result);
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




}	
function valide_partenaire(id){
	$.post('../api/ajax/modifier_partenaire', {token:$('#token').val(),id:id, nom:$('#nom_part').val(),img:$('#img_part').val(),description:$('#desc_part').val()},function(data){
		window.location.reload();
	});
}
function valide_news(id){
	$.post('../api/ajax/modifier_news', {token:$('#token').val(),id:id, nom:$('#nom_part').val(),img:$('#img_part').val(),description:$('#desc_part').val()},function(data){
		window.location.reload();
	});
}
$(document).ready(function(){
		
		show_stats();
		$('#fond_popup,#close_popup').click(function(){
			close_popup();
		});
        $('#chercher').keyup(function(){
           $('td.nom').each(function(){
               chaine=$(this).html();
               recherche=$('#chercher').val()
               var position = chaine.toUpperCase().search(recherche.toUpperCase());
               if(position>=0){$(this).parent().show(0);}
               else{$(this).parent().hide(0);}
           });
        });
		$('#chercher_carte').keyup(function(){
           $('td.carte').each(function(){
               chaine=$(this).html();
               recherche=$('#chercher_carte').val()
               var position = chaine.toUpperCase().search(recherche.toUpperCase());
               if(position>=0){$(this).parent().show(0);}
               else{$(this).parent().hide(0);}
           });
        });
		$("#carte").keyup(function(e)
		{
			if(e.keyCode=="40")//BAS
			{
			$('#index_cherche').val(parseInt($('#index_cherche').val()) + 1 );
			if(parseInt($('#index_cherche').val())>$(".nom_recherche").length-1)$('#index_cherche').val(0);
			$( ".nom_recherche" ).each(function( index ) {
				if(index == parseInt($('#index_cherche').val())) $( this ).addClass("active");
				   else $(this).removeClass("active");
			});
			}
			else if(e.keyCode==38)//HAUT
			{
				$('#index_cherche').val(parseInt($('#index_cherche').val()) - 1 );
					if(parseInt($('#index_cherche').val())<0)$('#index_cherche').val(0);
				$( ".nom_recherche" ).each(function( index ) {
						if(index == parseInt($('#index_cherche').val())) $( this ).addClass("active");
					else $(this).removeClass("active");
					});

			}
			else if(e.keyCode==13)//ENTER
			{
			console.log("ENTER");
				if($.isNumeric($('#carte').val()))
						window.location="./carte"+$('#carte').val();
				$( ".nom_recherche" ).each(function( index ) {
					found = 0;
					if($(this).hasClass("active")){
						$('#carte').val($(this).text());
						cherche_carte();
						found = 1;
					}			
				});

			}
			else cherche_carte();
});

});

