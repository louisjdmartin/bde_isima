function load_club(id)
{
	document.getElementById('club_nom').innerHTML = "Chargement...";
	document.getElementById('club_img').innerHTML = "";
	document.getElementById('club_presentation').innerHTML = "";
	
	$.getJSON("./api/ajax/get_club?id="+id).done(function(data){
		document.getElementById('club_nom').innerHTML = data.liste[0].nom;
		document.getElementById('club_img').innerHTML = "<img src='"+data.liste[0].img+"' />";
		document.getElementById('club_presentation').innerHTML = data.liste[0].presentation;
	});
}
function identification(from)
{
	$('#error').hide();
	$('#load').show();
	var d = new Date();
	if($('#stay').is(":checked"))var n = Math.trunc((d.getTime()+100*24*3600*1000)/1000); /* ConnectÃ© pour 100 jours */
	else var n = Math.trunc((d.getTime()+4*3600*1000)/1000);
	$.getJSON("./api/ajax/genere_token", {login:$('#mail').val(), pass:$('#passwd').val(), expiration: n }).done(function(data){
		$('#load').hide();
		if(data.error==1)
		{
			$('#error_msg').html(data.msg);
			$('#error').show();
		}
		else
		{
			$('#ok').show();
			$('#form').hide();
			window.location="./espace_ZZ?token="+data.token+"&from="+from+"&expiration="+n;
		}
	});
}
function reset_pass()
{
	mail = $('#mail_pass_oublie').val();
	html = $('#form_pass').html();
	$('#form_pass').html("Envoi du mail en cours...");
	$.getJSON("./api/ajax/change_passwd?mode=genere-token&mail="+mail).done(function(data){
		if(data.error==0)$('#form_pass').html("Mail de récupération envoyé ! Pense a  vérifier les spams");
		else 
		{
			alert("Impossible de trouver un compte !");
			$('#form_pass').html(html);
		}
	});
}

function contact()
{
	nom = $('#name').val();
	mail= $('#email').val();
	provenance=$('#provenance').val();
	msg=$('#message').val();
	if(nom==""||mail==""||msg=="")return alert("Formulaire incomplet !");
	$('#form_contact').html("Envoi du mail...");
	$.post('./assets/php/contact.php', {nom:nom,mail:mail,provenance:provenance,msg:msg},function(data){
		$('#form_contact').html("Mail envoyé ! Vous allez recevoir une copie par email et une réponse au plus vite.");
	});
}
