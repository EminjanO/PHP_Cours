<form name="formLogin" id="formLogin" method="post" action="sendFormLogin.html" onsubmit="return sendForm(this); return false;">
<fieldset><legend>Connexion</legend>
    <label for="flg_pseudo">Pseudo : </label><input title="Un pseudo est requis" type="text" name="flg_pseudo" id="flg_pseudo" required><br>
    <label for="flg_cle">Mot de passe : </label><input type="password" name="flg_cle" id="flg_cle" required><br>

    <input type="submit" name="flg_submit" id="flg_submit" value="envoyer">
</fieldset>
</form>