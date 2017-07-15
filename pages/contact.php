<h2 class="major">Contact</h2>
Admissible ? Rejoins nous sur <a href="https://www.facebook.com/bde.isima/" target="_blank">Facebook</a>. Nous répondons à la plupart des messages en moins de 20 minutes !
<form method="post" action="#" id='form_contact' onsubmit='contact();return false;'>
	<div class="field half first">
		<label for="name">Nom / Prénom</label>
		<input type="text" name="name" id="name" required />
	</div>
	<div class="field half">
		<label for="email">Email</label>
		<input type="email" name="email" id="email" required />
	</div>
	<div class="field">
		<label for="provenance">Vous êtes </label>
		<div class="select-wrapper">
			<select name="demo-category" id="provenance">
				<option value="Non précisé">Ne pas préciser</option>
				<option>un étudiant en CPGE</option>
				<option>un étudiant en license</option>
				<option>un étudiant en DUT</option>
				<option>un étudiant au lycée</option>
				<option>un étudiant de Clermont-Ferrand</option>
				<option value='un étudiant'>un étudiant autre part</option>
				<option>un ZZ</option>
				<option>un Prep'Isima</option>
				<option>une entreprise</option>
				<option>un organisme de l'université (SHS, DAG, etc.)</option>
				<option>un partenaire (ou demande de partenariat)</option>
				<option>Autre</option>
			</select>
		</div>
	</div>
	<div class="field">
		<label for="message">Message</label>
		<textarea name="message" id="message" rows="4" required></textarea>
	</div>
	<ul class="actions">
		<li><input type="submit" value="Envoyer" class="special" /></li>
		<li><input type="reset" value="Reset" /></li>
	</ul>
</form>
