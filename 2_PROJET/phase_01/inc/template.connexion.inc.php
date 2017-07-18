<form class="template" action="sendFormLogin.html" method="POST" onsubmit="sendForm(this); return false;" enctype="multipart/form-data">
    <fieldset id='formLogin' name='formLogin'>
        <legend>Connexion</legend>
        Pseudo
        <input type="text" name="flg_pseudo" required placeholder="Votre pseudo svp" size="30"/><br>
        Mot de passe
        <input type="password" name="flg_cle" required placeholder="Votre mot de passe svp" size="30"/><br>
        <input type="submit" name="flg_submit" value="Envoyer">
    </fieldset>
</form>