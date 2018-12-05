function virement_choix_carte(){
	popup("<h3>Faire un virement</h3><form onsubmit='virement_cherche_carte()'><input placeholder='Chercher un membre ou taper une carte' id='search_carte' type='text' /><input style='float:right' type='submit' value='Continuer' /></form><div style='clear:both'></div>");
	$('#search_carte').focus();
}
function virement_cherche_carte(){
	$.getJSON("../api/ajax/cherche_carte?q="+$('#search_carte').val()+"&token="+$('#token').val()).done(function(data){
		popup("<h3>Faire un virement</h3>");
		for(i=0;i<data.nb_elt;++i){
			$('#popup').append("<div class='nom_recherche' onclick='virement_choix_montant("+data.liste[i].carte+")'>Envoyer à "+data.liste[i].prenom+" "+data.liste[i].nom+"</div>");
		}
		$('#popup').append("<a onclick='virement_choix_carte()'>Retour</a>");
		if(data.nb_elt==1)virement_choix_montant(data.liste[0].carte);
		if(data.nb_elt==0){virement_choix_carte();fin_load("Aucun résultats !");}
		if(data.nb_elt>10){virement_choix_carte();fin_load("Trop de résultats, préciser la recherche");}
	});
	popup("<h3>Faire un virement</h3><p>Recherche de carte...</p>");
}
function virement_choix_montant(carte){
	popup("<h3>Faire un virement à <span id='user'>[carte "+carte+"]</span></h3><form id='form_vir' onsubmit='virement_valide("+carte+");return false;'><input type='number' id='montant' placeholder='Saisir un montant' step='0.1'/><input type='submit' value='Envoyer' style='float:right'/></form>");
	$.getJSON("../api/ajax/cherche_carte?q="+carte+"&force_number=true&token="+$('#token').val()).done(function(data){if(data.nb_elt==1)$('#user').html(data.liste[0].nom+" "+data.liste[0].prenom);});
	$('#montant').focus();
	$('#form_vir').append("<a onclick='virement_choix_carte()'>Retour</a>");

}

function virement_valide(carte){
	if($('#montant').val()>0){
		load();
		$.getJSON("../api/ajax/virement?to="+carte+"&token="+$('#token').val()+"&montant="+$('#montant').val()).done(function(data){
			if(data.error==1){
				fin_load("Action refusé !<br />"+data.error_msg);
			}
			else{
				$('#load,#fond_load').hide();
				popup_force_actualise("<h3>Opération terminée !</h3>");
			}
		});
	}
}

function popup(html)
{
	$('#popup').html(html);
	$('#fond_popup').fadeIn(200);
	$('#popup,#close_popup').fadeIn(200);
	$('#popup').css({'transform':'scale(1)'});
}
function popup_force_actualise(html)
{
	popup(html);
	$('#close_popup,#fond_popup').click(function(){window.location.reload();});
}
function close_popup(){
	$('#popup').css({'transform':'scale(0.8)'});
	$('#fond_popup,#close_popup').fadeOut(200);
	$('#popup').fadeOut(200);
	$('#carte').focus();
}
function getRandomInt(min, max) {
	  min = Math.ceil(min);
	  max = Math.floor(max);
	  return Math.floor(Math.random() * (max - min)) + min;
}

function load(){
	
	$('#load,#fond_load').show();
	
	gifs = [
		"https://media.giphy.com/media/hMpc5y9seCrWo/giphy.gif",
		"https://media.giphy.com/media/rQKPX8yy8UGm4/giphy.gif",
		"https://media.giphy.com/media/DeJ2ifS2V2zlu/giphy.gif",
		"https://media.giphy.com/media/ScZzMlETdv9mg/giphy.gif",
		"https://media.giphy.com/media/GODSCQebffJzW/giphy.gif",
		"https://media.giphy.com/media/zB2bTM3RyMRig/giphy.gif",
		"https://media.giphy.com/media/CEF7ocyS0C9q/giphy.gif",
		"https://media.giphy.com/media/TFyDxKxXg6Rz2/giphy.gif",
		"https://media.giphy.com/media/yPVyBqWtZfeaA/giphy.gif",
		"https://media.giphy.com/media/rdma0nDFZMR32/giphy.gif",
		"https://media.giphy.com/media/wYz6MTJaDgxNK/giphy.gif",
		"https://media.giphy.com/media/O5NyCibf93upy/giphy.gif",
		"https://media.giphy.com/media/OuQwH940jCQ6Y/giphy.gif",
		"https://media.giphy.com/media/3oKIPf1BaBDILVxbYA/giphy.gif",
		"https://media.giphy.com/media/UZA15w44oCT1m/giphy.gif",
		"https://media.giphy.com/media/5gVgwoD6NE0BW/giphy.gif",
		"https://media.giphy.com/media/E9oadOOmD27jG/giphy.gif",
		"https://media.giphy.com/media/hPPx8yk3Bmqys/giphy.gif",
		"https://media.giphy.com/media/Sm8Ec3ddRWXa8/giphy.gif",
		"https://media.giphy.com/media/c1zviFHCf4pq0/giphy.gif",
		"https://media.giphy.com/media/hsOmFxr1YAD2E/giphy.gif",
		"https://media.giphy.com/media/7LG6PqAubrWBa/giphy.gif",
		"https://media.giphy.com/media/wcjtdRkYDK0sU/giphy.gif",
		"https://media.giphy.com/media/BHVeUoyqihAaI/giphy.gif",
		"https://media.giphy.com/media/rn1xsrH5JB1E4/giphy.gif",
		"https://media.giphy.com/media/kB6t9nMVHU9eE/giphy.gif",
		"https://media.giphy.com/media/8ErHYXFsA9QsM/giphy.gif",
		"https://media.giphy.com/media/110gqI69qjVAkM/giphy.gif",
		"https://media.giphy.com/media/tCAsXsOGeIcgM/giphy.gif",
		"http://media.giphy.com/media/6t4gwsSh4BQfm/giphy.gif",
		"https://media.giphy.com/media/kTZBUjdRlZB3G/giphy.gif",
		"https://media.giphy.com/media/bxVA5CqJ5iVLq/giphy.gif",
		"https://m.popkey.co/8618d2/DyVJx.gif",
		"https://media.giphy.com/media/3osBLvEDEgSfQ7l3EY/giphy.gif",
		"https://media.giphy.com/media/3osBLvEDEgSfQ7l3EY/giphy.gif",
		"https://media.giphy.com/media/3osBLvEDEgSfQ7l3EY/giphy.gif",
		"https://media.giphy.com/media/3osBLvEDEgSfQ7l3EY/giphy.gif",
	        "https://media.giphy.com/media/3osBLvEDEgSfQ7l3EY/giphy.gif",
	        "https://bde.isima.fr/easter_eggs/cogonixkill/10.jpg", 
	        "https://bde.isima.fr/easter_eggs/franck_romane.gif",
		"https://bde.isima.fr/easter_eggs/listeux/memelisteux1.jpg",
		"https://bde.isima.fr/easter_eggs/listeux/memelisteux2.jpg",
		"https://bde.isima.fr/easter_eggs/listeux/memelisteux3.jpg"
	];
	gn = getRandomInt(0,(gifs.length)-1);
	$('.gif_load').html("<img src='"+gifs[gn]+"' alt='load' style='max-width:100%'/>");
}
var fin_load_timeout;
function fin_load(html){
	$('#load,#fond_load').hide();
	if(html!=undefined)$('#fin_load').hide().slideDown(300)
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
function get_all_recharges_isibouffe()
{
	popup("<h3>Chargement...</h3><ul id='liste_recharges'></ul>");
	$.getJSON('../api/ajax/get_log_recharges_isibouffe', {nombre: 1000, token: $('#token').val()}).done(function(data){
		html = "<h3>Historique</h3><ul id='liste_recharges'>";
		for(i=0;i<data.nb_elt;i++){
			if(data.liste[i].montant>0)html = html + '<li><span style="display:inline-block;width:64px;color:green">+'+data.liste[i].montant+'€</span>';
			if(data.liste[i].montant<0)html = html + '<li><span style="display:inline-block;width:64px;color:red">'+data.liste[i].montant+'€</span>';
			
			html = html + " le " + data.liste[i].date + "</li>";
		}
		html = html + "</ul><em>Si votre compte isibouffe à été créé sur l'ancienne version du site du BDE, le début de votre historique est perdu. Le solde n'a pas été perdu lors de la migration. Si besoin allez voir le trésorier.</em>";
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
}function get_all_consos_isibouffe(numero)
{
	popup("<h3>Chargement...</h3><ul id='liste_recharges'></ul>");
	$.getJSON('../api/ajax/get_log_consos_isibouffe', {nombre: 1000, token: $('#token').val(), numero:numero}).done(function(data){
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
	
	
	load();
	$.getJSON('../api/ajax/get_liste_articles',{token:$('#token').val()}).done(function(data){
		html = "<h3>Encaisser sur la carte <a onclick='autre_carte();return false;' href='#' style='text-decoration:underline'>"+numero+"</a> /  <a onclick='recharge("+numero+");return false;' href='#' style='text-decoration:underline'>Recharger</a></h3><form onsubmit='return false'><input id='fast_search' type='text' placeholder='Recherche rapide article' /></form><div id='liste_articles'>";
		for(i=0;i<data.nb_elt;i++){
			html = html + '<span class="article" onclick="encaisser('+numero+', '+data.liste[i].id+')"><img src="'+data.liste[i].img+'" /><br />'+data.liste[i].nom+' ('+data.liste[i].tarif+'€)</span>';
			
		}
		html = html + "</div>";
		fin_load();
		popup(html);


		$('#fast_search').keyup(function(){
	       $('#liste_articles .article').each(function(){
	           chaine=$(this).html().toUpperCase();
	           recherche=$('#fast_search').val()
	           var position = chaine.search(recherche.toUpperCase());
	           if(position>=0){$(this).slideDown(0);}
	           else{$(this).slideUp(0);}
	       });
	    }).focus();


	});
}
function encaisser(carte, article)
{
	load();
	$.getJSON('../api/ajax/encaisser_article', {carte: carte, id_article: article, token: $('#token').val()}).done(function(data){
		if(data.solde>0){ $('#affichage_solde').html('<span style="color:green">+'+data.solde+'€</span>'); }
		else {$('#affichage_solde').html('<span style="color:red">'+data.solde+'€</span>');}
		html_ul = $('#ul_consos').html();
	        if(data.tarif>0)html = '<li><span style="display:inline-block;width:60px;color:red">-'+data.tarif+'€</span> ';
	    else html = '<li><span style="display:inline-block;width:60px;color:green">'+data.tarif+'€</span> ';
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

function cherche_carte_other(){
	if(xhr)xhr.abort();
	q = $('#other_carte').val();
	html = "<input type='hidden' value='-1' id='index_cherche' />";
	if(q.length > 0)xhr = $.getJSON('../api/ajax/cherche_carte', {q:q, token:$('#token').val(), force_number:1}).done(function(data){
		for(i=0;i<data.nb_elt;i++){
		    html = html + "<span class='nom_recherche' onclick='$(\"#other_carte\").val("+data.liste[i].carte+");cherche_carte_other();'>"  + data.liste[i].nom+' '+data.liste[i].prenom+' '+data.liste[i].surnom+' ('+data.liste[i].carte +') <strong>'+data.liste[i].solde+'€</strong></span>';
		}
		if(data.nb_elt==0){

			html = "Aucun résultat.";

		}
		if(data.nb_elt>20){
			html = data.nb_elt + " résultats.";
		}
		$('#resultats').html(html);
		if(data.nb_elt==1)$('#other_carte').val(data.liste[0].carte);
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
	load();

	$.post('../api/ajax/get_liste_membres', {id:id, token:$('#token').val(), id:id},function(data){
		data=JSON.parse(data);

		data = data['liste'][0];

		nom=data.nom;
		prenom=data.prenom;
		surnom=data.surnom;
		mail=data.mail;
		carte=data.numero;
		promo=data.promo;
		grade=data.grade;
		tel=data.telephone


		if(id==0)efface_button="";
		else efface_button = "Pour effacer un membre remplace son nom par SUPPR_MEMBER\nATTENTION: le compte ne sera pas effacé si il est associé à un club";
		super_grade="";disable_super="";
		if(grade == 1)club = "selected";else club= "";
		if(grade == 2)bde = "selected";else bde= "";
		if(grade == 3)listeux = "selected";else listeux= "";
		if(grade == 4){super_grade="<option value='4' selected>Créateur du site</option>";disable_super="disabled";} 
		if(grade == 664){super_grade="<option value='664' selected>Romane</option>";disable_super="disabled";} 


		popup("<h3>Edition d'un membre</h3>\
			<form onsubmit='valide_membre();return false;'>\
			<input type='hidden' value='"+id+"' id='id_mb' />\
			<label for='nom_art'>Nom</label><input type='text' id='nom_mb' />\
			<label for='nom_art'>Prénom</label><input  type='text' id='prenom_mb' />\
			<label for='nom_art'>Surnom</label><input type='text' id='surnom_mb' />\
			<label for='nom_art'>Téléphone</label><input type='text' id='tel_mb' />\
			<label for='nom_art'>Mail</label><input type='text' id='mail_mb' />\
			<label for='nom_art'>Carte</label><input type='text' id='carte_mb' />\
			<label for='nom_art'>Promo</label><input type='text' id='promo_mb' />\
			<label for='nom_art'>Grade</label><select "+disable_super+" id='grade_mb'>\
			<option value='0'>ZZ</option>\
			<option value='1' "+club+">Club</option>\
			<option value='3' "+listeux+">Listeux</option>\
			<option value='2' "+bde+">BDE</option>\
				"+super_grade+"</select>\
			<label for='nom_art'>Cotisation (<a onclick='maj_cotisation();return false;'>mettre à jour la cotisation</a>)</label><input disabled value='"+cotisation+"'  type='text' id='cotisation_mb' />\
			\
			<a style='float:right' class='button' href='#' onclick='valide_membre()'>Sauvegarder</a>&nbsp;\
			"+efface_button+"\
			</form>\
		");

		$('#nom_mb').val(nom);
		$('#prenom_mb').val(prenom);
		$('#surnom_mb').val(surnom);
		$('#mail_mb').val(mail);
		$('#carte_mb').val(carte);
		$('#promo_mb').val(promo);
		$('#tel_mb').val(tel);


		fin_load();
	});
	
}
function add_membre()
{
	
	popup("<h3>Ajout d'un membre</h3>\
	<form onsubmit='valide_add_membre();return false;'>\
	<input type='hidden' value='0' id='id_mb' />\
	<label for='nom_art'>Nom</label><input  type='text' id='nom_mb' />\
	<label for='nom_art'>Prénom</label><input type='text' id='prenom_mb' />\
	<label for='nom_art'>Mail</label><input type='text' id='mail_mb' />\
	<label for='nom_art'>Tel</label><input type='text' id='tel_mb' />\
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
			promo : $('#promo_mb').val(),
			telephone : $('#tel_mb').val()
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
			telephone : $('#tel_mb').val(),
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

function valide_cp_evt(id_event){
	if($("#event_deb").val() == "" || $("#event_fin").val() == "")
		return alert("Formulaire incomplet !");
	$('#valide_btn_load,#valide_btn').toggle();
	$.post('../api/ajax/evt_copie', {
		token:$('#token').val(),
		id_evt: id_event,
		date_limite_insc:$("#event_deb").val(),
		date_event:$("#event_fin").val()
	},function(data){
		data = JSON.parse(data);
		$('#load,#fond_load').hide();
		evt_edit_article(data.id);
	});
}
function del_evt(id_event){
	if(confirm("Valider l'action..."))$.post('../api/ajax/evt_delete', {token: $('#token').val(), id_evt: id_event}, function(d){window.location.reload();});
}
function cp_evt(id_event)
{
	popup("<h3>Copier un événement avec inscription</h3>\
	<form onsubmit='return false'>\
	<label>Date (non modifiable par la suite !)</label>\
	<input style='width:48%; display:inline;' type='text' id='event_deb' placeholder='Date limite inscription' />\
	\
	<input style='width:48%; display:inline;' type='text' id='event_fin' placeholder='Date événement' />\
	<br /><button style='float:right' onclick='valide_cp_evt("+id_event+");' id='valide_btn'>Suivant</button><button style='float:right' id='valide_btn_load'>Chargement...</button>");

	$('#nom_event').focus();
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
	$('#valide_btn_load').hide();

}


function add_evt(id_club)
{
	popup("<h3>Ajouter un événement avec inscription</h3>\
	<form onsubmit='return false'>\
	<label>Nom de l'événement</label>\
	<input type='text' id='nom_event' />\
	<label>Places disponibles (0=infini)</label>\
	<input type='number' id='places_event' value='0' step='1' />\
	<label>Paiement par carte BDE autorisé</label>\
	<input type='radio' id='carte_bde_event' name='carte_bde_event' value='0' checked />Non\
	<input type='radio' id='carte_bde_event_true' name='carte_bde_event' value='1' />Oui\
	<label>Date (non modifiable par la suite !)</label>\
	<input style='width:48%; display:inline;' type='text' id='event_deb' placeholder='Date limite inscription' />\
	\
	<input style='width:48%; display:inline;' type='text' id='event_fin' placeholder='Date événement' />\
	<br /><button style='float:right' onclick='valide_add_evt("+id_club+");' id='valide_btn'>Suivant</button><button style='float:right' id='valide_btn_load'>Chargement...</button>");

	$('#nom_event').focus();
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
	$('#valide_btn_load').hide();

}


function valide_add_evt(id_club){
	if($("#event_deb").val() == "" || $("#event_fin").val() == "" || $("#nom_event").val() == "")
		return alert("Formulaire incomplet !");
	$('#valide_btn_load,#valide_btn').toggle();
	$.post('../api/ajax/add_evt', {
		token:$('#token').val(),
		id_club:id_club, 
		nom:$('#nom_event').val(),
		places:$('#places_event').val(), 
		limite:$('#event_deb').val(), 
		date:$('#event_fin').val(), 
		bde:$('#carte_bde_event_true').is(':checked')
	},function(data){
		data = JSON.parse(data);
		$('#load,#fond_load').hide();
		evt_add_article(data.id);
	});
}


function evt_edit_article(id){
	popup_force_actualise("<h3>Modifier les articles</h3>\
	<div id='liste_articles'>Chargement...</div>\
	<br ><a onclick='evt_add_article("+id+")' class='button'>Ajouter...</a>");
	
	
	$.getJSON("../api/ajax/get_liste_articles_evt?id_event="+id,function(data){
		if(data.nb_elt==0)$('#liste_articles').html("Aucun article");
		else{
			$('#liste_articles').html("<table><tr><td>Nom</td><td>Qte dispo</td><td>Qte restante</td><td>Prix</td><td style='width:4%'>Effacer</td></tr></table>");
			for(i=0;i<data.nb_elt;i++){
				$('#liste_articles table').append("\
					<tr>\
						<td>"+data.liste[i].nom+"</td>\
						<td>"+data.liste[i].qte_max+"</td>\
						<td>"+data.liste[i].qte_dispo+"</td>\
						<td>"+data.liste[i].prix+"</td>\
						<td style='width:4%'><a class='button' onclick='evt_eff_article("+id+","+data.liste[i].id+")'>X</td>\
					</tr>");
			}
		}
	});
	
}
function evt_eff_article(evt_id, art_id){
	if (confirm("ATTENTION ! \nCELA ANNULE TOUTES LES COMMANDES PASSEES SUR CET ARTICLE!")){
		load();
		$.post('../api/ajax/del_art_evt', {
			token:$('#token').val(),
			id_evt:evt_id, 
			id_article: art_id
		},function(data){
			data = JSON.parse(data);
			$('#load,#fond_load').hide();
			evt_edit_article(evt_id);
		});
	}
}
function evt_add_article(id){
	popup_force_actualise("<h3>Ajouter un article</h3>\
	<em>Une qté dispo égale à 0 ou non définie signifie qu'il n'y a pas de limites</em>\
	<h4>Utiliser un nouvel article</h4>\
	<form onsubmit='return false;'><table><tr>\
	<td style='width:66%'><input type='text' id='art_name' placeholder='Saisir nom' /><td>\
	<td style='width:14%'><input type='number' size=2 id='art_qte' placeholder='Qte' id='art_qte' min='0' step='1' /></td>\
	<td style='width:16%'><input type='number' size=2 id='art_prix' placeholder='Prix'id='art_prix'  min='0' step='0.01' /></td>\
	<td style='width:4%'><a onclick='evt_valide_add_article("+id+")' class='button'>+</a><td>\
	</tr></table></form><h4>Réutiliser un ancien article</h4>\
	<br ><div id='liste_articles'>Chargement...</div>\<br /></small>\
	<a onclick='evt_edit_article("+id+")' class='button'>Précédent...</a>");
	$('#art_name').focus();
	
	
	$.getJSON("../api/ajax/get_old_art_evt?id_evt="+id+"&token="+$('#token').val(),function(data){
		if(data.nb_elt==0)$('#liste_articles').html("Aucun article");
		else{
			$('#liste_articles').html("<form onsubmit='return false;'><table><tr><td>Nom</td><td>Qte</td><td>Prix</td><td style='width:4%'>Ajouter</td></tr></table></form>");
			for(i=0;i<data.nb_elt;i++){
				$('#liste_articles table').append("\
					<tr>\
						<td>"+data.liste[i].nom+"</td>\
						<td style='width:14%'><input type='number' size=2 id='art_qte"+data.liste[i].id+"' placeholder='infini' id='art_qte' min='0' step='1' /></td>\
						<td style='width:16%'>"+data.liste[i].prix+"€</td>\
						<td style='width:4%'><a class='button' onclick='evt_add_old_article("+id+","+data.liste[i].id+")'>+</td>\
					</tr>");
			}
		}
	});
}
function evt_add_old_article(id_event,id_article){

	if($("#art_qte"+id_article).val() == "")$("#art_qte"+id_article).val(0);
	load();
	$.post('../api/ajax/add_old_art_evt', {
		token:$('#token').val(),
		id_evt:id_event, 
		id_article:id_article,
		qte:$('#art_qte'+id_article).val()
	},function(data){
		data = JSON.parse(data);
		$('#load,#fond_load').hide();
		evt_add_article(id_event);
	});
}
function evt_valide_add_article(id){
	if($("#art_name").val() == "" ||  $("#art_prix").val() == "")
		return alert("Formulaire incomplet !");
	if($("#art_qte").val() == "")$("#art_qte").val(0);
	$('#valide_btn_load,#valide_btn').toggle();
	$.post('../api/ajax/add_art_evt', {
		token:$('#token').val(),
		id_evt:id, 
		nom:$('#art_name').val(),
		qte:$('#art_qte').val(), 
		prix:$('#art_prix').val()
	},function(data){
		data = JSON.parse(data);
		fin_load("Article ajouté: "+$('#art_name').val()+"<br />Prix:"+$('#art_prix').val()+"€<br />Qté:"+$('#art_qte').val()+" (0=infini)");
		evt_add_article(id);
	});
}


function genere_liste_commande(id_evt, fct){
	load();
	$.getJSON("../api/ajax/get_liste_articles_evt?id_event="+id_evt, function(data){
		retour = {taille: 0, liste:[]};
		for(i=0;i<data.nb_elt;i++){
			if($('#qte'+data["liste"][i]['id']).val()>0){
				retour.liste.push({
					art_id: data['liste'][i]['id'],
					art_nom: data['liste'][i]['nom'],
					qte: $('#qte'+data["liste"][i]['id']).val(),
					commentaire: $('#comment'+data["liste"][i]['id']).val(),
					prix:data['liste'][i]['prix']
				});
				retour.taille++;
			}
		}
		fct(retour);
	});
}

function annuler_inscription_evt(id){
	if(confirm("Voulez vous vraiment annuler votre inscription ?")){
		load();
		$.post("../api/ajax/evt_annuler_inscription", {token: $('#token').val(), id_evt: id}, function(data){
			window.location.reload();
		});
	}
}

function valide_commande(id_evt)
{
	genere_liste_commande(id_evt, function(data){
		if(document.getElementById('other') && $('#other').is(':checked')){
			other = 1;
			other_name = $('#other_name').val();
		}
		else if(document.getElementById('other_bde') && $('#other_bde').is(':checked')){
			other = 2;
			other_name = $('#other_carte').val();
		}
		else{
			other = 0;
			other_name = "";
		}

		if(data.solde<total){cartebde=0}
		else if(document.getElementById('bde') && $('#bde').is(':checked'))cartebde=1;
		else cartebde=0;


		$.post("../api/ajax/evt_inscription", {bde:cartebde, liste: data.liste, other:other, other_name:other_name, id_evt:id_evt, token: $('#token').val()},function(reponse){
		    brut=reponse;
		    reponse = JSON.parse(reponse);
			if(reponse.error=="1"){
				fin_load();
				popup("<h3>Erreur !</h3><pre>"+reponse.error_msg+"</pre>");
			}
			else {
				fin_load();
				popup_force_actualise("<h2>L'inscription est bien prise en compte !</h1>Pour revoir la commande,  modifier ou annuler, il suffit de revenir sur cette page.")
			}
		   
		});
	});
}

function show_commande(id_evt){
	genere_liste_commande(id_evt, function(data){
		$('html, body').stop().animate({
	        'scrollTop': $('#recap').offset().top -64
	    });
		
		$('#recap').html("<table style='width:100%'><tr><td><strong>Article</strong></th><td><strong>Qté</strong></th><td><strong>Prix (€)</strong></th><td><strong>Commentaire</strong></th></tr></table>");
		total = 0;
		for(i=0;i<data.taille;i++){
			total += data.liste[i].qte*data.liste[i].prix
			$('#recap table').append("<tr><td>"+data.liste[i].art_nom+"</td><td>"+data.liste[i].qte+"</td><td>"+(data.liste[i].qte*data.liste[i].prix)+"</td><td style='width:35%'>"+(data.liste[i].commentaire)+"</td></tr>");
		}
		$('#recap').append("<strong>TOTAL: "+total+"€</strong>");
		
		$.getJSON("../api/ajax/get_solde?token="+$('#token').val(),function(data){
		if(data.solde<total){$('#carteBDE').hide();$('#noCarteBDE').show();}
		else {$('#carteBDE').show();$('#noCarteBDE').hide();}
			$('#load,#fond_load').hide();
		})
		
	});
}


function encaisse_cmd(id_cmd, qte_max, id_user){
	if(qte_max == 0){
		close_popup();
		alert("Vous avez déjà encaissé !");
	}else {
		popup("<h3>Encaisser</h3>Notez combien d'articles on été payées en liquide: <select id='qte_to_pay'></select><br /><button onclick='encaisse_liquide("+id_cmd+")'>Encaisser en liquide</button><hr />\
		Ou saisir une carte BDE <input id='carte_bde_to_pay' type='number' /><br /><button onclick='encaisse_carte("+id_cmd+")'>Encaisser par carte</button>\
		");
		for(i=qte_max;i>=1;i--) $('#qte_to_pay').append("<option>"+i+"</option>");
	}
	$.getJSON("../api/ajax/get_carte_by_id?id="+id_user).done(function(data){$('#carte_bde_to_pay').val(data.numero);});
}
function encaisse_liquide(id_cmd){
	load();
	$.post('../api/ajax/evt_encaisser', {token:$("#token").val(), id_cmd: id_cmd, qte: $('#qte_to_pay').val(), mode: "liquide"}, function(d){
		window.location.reload();
	});
}
function encaisse_carte(id_cmd){
	load();
	$.post('../api/ajax/evt_encaisser', {token:$("#token").val(), id_cmd: id_cmd, carte: $('#carte_bde_to_pay').val(), mode: "bde"}, function(d){
		window.location.reload();
	});
}
function annuler_cmd_club(id){
	if(confirm("Voulez vous vraiment annuler votre inscription ?")){
		load();
		$.post('../api/ajax/evt_annuler_inscription_club', {token:$("#token").val(), id_cmd: id}, function(d){
			window.location.reload();
		});
	}
}
function evt_encaisse_bde(id_event){
    if(confirm("Valider l'encaissement de toutes les cartes")){
	load();
	$.post('../api/ajax/evt_encaisser', {token:$('#token').val(),mode:'event', id_evt:id_event}, function(d){
	    window.location.reload();
	});
    }
}

function evt_get_stats(id_event){
	popup("Chargement...");
	$.getJSON("../api/ajax/evt_get_stats", {token: $('#token').val(), id_evt: id_event}, function(data){
		html = "<h3>Statistiques</h3>Argent encaissé par carte BDE: " +  data.total_gain_bde + "€<br>";
		html+= "Argent généré au total: " + data.total_gain + "€";
		
		html+= "<table><tr><td>Nom</td><td>Qté</td><td>Total</td></tr>";
	
		for(i=0;i<data.taille_liste;i++){
			html+="<tr><td>"+data.liste[i].nom_article+"</td><td>"+data.liste[i].qte+"</td><td>"+data.liste[i].gain+"€</td>";
		}

		html += "</table>";

		popup(html);
	});
}

function evt_change_settings(id_event){
	html = "<h3>Paramètres (cliquer pour modifier)</h3>\
				Nom de l'événement: <span id='change_nom' onclick='evt_change_nom("+id_event+")'>Chargement...</span><br />\
				Date limite inscription (non modifiable): <span id='change_date_lim'>Chargement...</span><br />\
				Date événement (non modifiable): <span id='change_date_evt'>Chargement...</span><br />\
				Paiement par carte BDE autorisé: <span id='change_carte'  onclick='evt_change_bde("+id_event+")'>Chargement...</span><br />\
				Places disponibles: <span id='change_places' onclick='evt_change_places("+id_event+")'>Chargement...</span><br />\
				<em>La sauvegarde est automatique</em>";
	popup(html);

	$.getJSON("../api/ajax/get_evt", {token: $('#token').val(), id_evt: id_event}, function(data){
		$('#change_nom').html(data.nom);
		$('#change_date_lim').html(data.date_insc);
		$('#change_date_evt').html(data.date_evt);
		if(data.carte_bde == '1')$('#change_carte').html("Oui");
		else $('#change_carte').html("Non");
		$('#change_places').html(data.places);
	});

}
function evt_change_nom(id_event){
	nom = prompt("Nouveau nom: ");
	if(nom != undefined) if(nom != '') {
		$('#change_nom').html(nom);
		$.post("../api/ajax/evt_change_settings", {token: $('#token').val(), mode: 'nom', val: nom, id_evt: id_event});
	}
}
function evt_change_places(id_event){
	nom = prompt("Nombre de places (0= infini, arrondi si non entier): ");
	nom = parseInt(nom, 10);
	if(nom || nom==0) {
		$('#change_places').html(nom);
		$.post("../api/ajax/evt_change_settings", {token: $('#token').val(), mode: 'places', val: nom, id_evt: id_event});
	}
}

function evt_change_bde(id_event){
	if(confirm("Autoriser le paiement par carte BDE ?\nATTENTION: si des cartes BDE on déjà été débitées celle-ci resterons débitées")) {
		$('#change_carte').html("Oui");
		$.post("../api/ajax/evt_change_settings", {token: $('#token').val(), mode: 'carte', val: 1, id_evt: id_event});
	}else {
		$('#change_carte').html("Non");
		$.post("../api/ajax/evt_change_settings", {token: $('#token').val(), mode: 'carte', val: 0, id_evt: id_event});
	}
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
				if($.isNumeric($('#carte').val()))
						window.location="./?page=carte&fast_add_articles=true&carte="+$('#carte').val();
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

		$("#other_carte").keyup(function(e)
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
				e.preventDefault();
				if($.isNumeric($('#other_carte').val()))
						return false
				$( ".nom_recherche" ).each(function( index ) {
					found = 0;
					if($(this).hasClass("active")){
						$('#other_carte').val($(this).text());
						cherche_carte_other();
						found = 1;
					}			
				});
				return false;
			}
			else cherche_carte_other();
	    });
		$('html,body').keyup(function(e){
			if(e.keyCode==27)close_popup();
		});


});

