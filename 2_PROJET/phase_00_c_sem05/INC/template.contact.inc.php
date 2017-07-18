<form id="formContact" action="sendFormContact.html" method="post" onsubmit="return sendForm(this)">
	<fieldset>
		<legend>Formulaire de contact</legend>
		<label for="fc_email">Votre email : </label>
		<input type="email" id="fc_email" name="fc_email" size="50" placeholder="requis" value="" required><br>
		
		<label for="fc_sujet">Sujet du message : </label>
		<input type="text" id="fc_sujet" name="fc_sujet" size="50" placeholder="requis" value="" required><br>
		
		<label for="fc_message">Message : </label>
		<textarea id="fc_message" name="fc_message" rows="5" cols="50" placeholder="requis"
		          title="Un sujet est requis" required></textarea><br><br>
		<input type="submit" id="fc_submit" name="fc_submit" value="envoyer">
	</fieldset>
</form>
<?php
/**
 * Created by PhpStorm.
 * User: eminjan
 * Date: 30/04/17
 * Time: 10:06
 */
