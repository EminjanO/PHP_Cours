<form class="template" action="sendFormContact.html" onsubmit="sendForm(this); return false;" method="POST">
    <fieldset id='formContact' name='formContact'>
        <legend>Formulaire de contact</legend>
        <label>Votre email: </label>
        <input type="email" name="fc_email" required placeholder="requis" size="50"/><br>
        <label>Sujet du message</label>
        <input type="text" name="fc_sujet" required placeholder="requis" size="50"/><br>
        <label>Message: </label>
        <textarea name="fc_message" placeholder="requis" rows="5" cols="50">
</textarea>
        <br>
        <input type="submit" name="fc_submit" value="Envoyer">
    </fieldset>
</form>