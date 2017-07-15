<h2>Changer le mot de passe</h2>
<form onsubmit="modif_pwd();return false">
	<label for="token">Ancien mot de passe ou token</label>
	<input <?php if(isset($_GET['token_pwd']))echo 'value="'.$_GET['token_pwd'].'" disabled'; ?> type="password" id="token">
	
	<label for="pwd">Nouveau mot de passe</label>
	<input type="password" name='pwd' id='pwd'/>
	
	<label for="pwd_c">Confirmation</label>
	<input type="password" name='pwd_c' id='pwd_c'/>
	
	<label for="deconnecter">Se déconnecter de tout les appareils</label>
	<input type='checkbox' id='deconnecter' /><br />
	
	<input type='submit' value='Changer le mot de passe' />
	<input type='hidden' value='<?php echo $user['mail']; ?>' id='mail'/>
</form>