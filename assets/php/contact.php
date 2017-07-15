<?php
	if (filter_var(htmlentities($_REQUEST['mail']), FILTER_VALIDATE_EMAIL)) {
		include "../../api/fonctions.php";
		//nom:nom,mail:mail,provenance:provenance,msg:msg
		$sujet = "Formulaire de contact du BDE";
		$contenu = '<strong>Informations sur l\'expediteur</strong><br />
		Nom / prénom: '.htmlentities($_REQUEST['nom']).'<br />
		Email: <a href="mailto:'.htmlentities($_REQUEST['mail']).'">'.htmlentities($_REQUEST['mail']).'</a>
		<br />C\'est '.htmlentities($_REQUEST['provenance']).'
		<br /><br /><div style="padding: 30px; border-top: 3px  solid  black;"></div>
		'.nl2br(htmlentities($_REQUEST['msg'])).'<br />
		<br />';

		send_mail(htmlentities($_REQUEST['mail']), $sujet, $contenu);
		if(send_mail("bdeisima@gmail.com", $sujet, $contenu))
			echo "OK";
		else echo "ERROR";
	}else echo "nope";
