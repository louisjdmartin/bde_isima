<h2 class="major">Identification</h2>
<form method="post" id="form" action="#" onsubmit="identification('<?php if(isset($_GET['from']))echo htmlentities($_GET['from']); ?>');return false">
	<div class="field half first">
		<label for="mail">Email ou N° de carte</label>
		<input type="text" name="mail" id="mail" value="" required autocapitalize="off" />
	</div>
	<div class="field half">
		<label for="passwd">Mot de passe</label>
		<input type="password" name="passwd" id="passwd" value="" required />
	</div>
	<div class="field half first">
		<input type="checkbox" id="stay" name="stay">
		<label for="stay">Rester connecté</label>
	</div>
	<div class="field half">
		<input type="submit" value="Se connecter" class="special" />
	</div>
	
	<div class="field" id='error' style='display:none;'>
		<p style='color:red' id='error_msg'></p>
	</div>
	<div class="field" id='load' style='display:none;'>
		<p style='color:orange' id=''>Identification en cours, merci de patienter...</p>
	</div>
	
	<ul class="actions">
		<li><a href="#oubli">Mot de passe oublié ?</a></li>
		<li><a href="#create_account">Pas de compte ?</a></li>
		<li><a href="https://drive.google.com/drive/folders/0B8UQ_-N6TCbvRDZEcUtTS1hWc2M?usp=sharing">Annales</a></li>
	</ul>
</form>
<div class="field" id='ok' style='display:none;'>
	<p>
		Identification réussie ! Redirection vers l'espace membre ...
		<br /><span id="a_redirect"></span>
	</p>
</div>