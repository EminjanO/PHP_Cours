<form id="formLogo" name="formLogo" method="post"
      action="sendFormLogo.html" onsubmit=" return sendForm(this)">
    <fieldset title="Chanement de logo">
        <legend>Chanement de logo</legend>
        <label for="fl_file">Votre fichier : </label>
        <input type="file" id="fl_file" name="fl_file" required><br>
        <label for="fl_size">Taille du logo</label>
        <input type="number" id="fl_size" name="fl_size" value="60"
               min="40" max="100" step="10"><br>
        <input type="submit" id="fl_submit" name="fl_submit" value="envoyer">
    </fieldset>

</form>
<?php
/**
 * Created by PhpStorm.
 * User: eminjan
 * Date: 5/05/2017
 * Time: 21:59
 */