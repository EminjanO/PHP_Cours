<?php
/**
 * Created by PhpStorm.
 * User: eminjan
 * Date: 21/04/17
 * Time: 7:11
 */
    if(isset($_FILES["fichierUpload"]))
    {
        $dossier = 'DOCUMENTS/';
        $fichier = basename($_FILES['fichierUpload']['name']);
        if(move_uploaded_file($_FILES['fichierUpload']['tmp_name'], $dossier . $fichier))
        {
            echo '<a href = '. $dossier.$fichier.'>Afficherl le fichier que vous avez envoyé</a>';
        }
        else
        {
            echo ' pas bien ';
        }
    }

//echo '<pre>'. print_r($_FILES,1).'</pre>';

