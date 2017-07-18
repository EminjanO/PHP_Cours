<form class="template" action=sendFormLogo.html method="POST" onsubmit="sendForm(this); return false;" enctype="multipart/form-data">
    <fieldset id='formLogo' name='logo'>
        <legend>Changement de logo</legend>
        <p>
            Selectionner un fichier
            <input type="file" name="fl_file" id="fl_file">
        </p>
        <p>
            Taille du logo
            <input type="number" name="fl_size" id="fl_size" min="40" max="100" value="60" step="10">
        </p>
        <div>
            <input type="submit" value="Send" id="fl_submit">
        </div>
        <p id="tailleFichier"></p>
</form>