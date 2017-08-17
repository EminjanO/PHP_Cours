<?php
/**
 * Created by PhpStorm.
 * User: eminjan
 * Date: 21/04/17
 * Time: 7:11
 */

require_once('dbConnect.inc.php');
require_once('mesFonctions.inc.php');

    if(isset($_FILES["fichierUpload"]))
    {
        $dossier = 'DOCUMENTS/';
        $fichier = basename($_FILES['fichierUpload']['name']);
        
        if(move_uploaded_file($_FILES['fichierUpload']['tmp_name'], $dossier . $fichier))
        {
        	/*
        	$pathA = getServer().dirname($_SERVER["ORIG_PATH_INFO"]).'/'. $dossier.$fichier;
            echo '<a href = '.getServer().dirname($_SERVER["ORIG_PATH_INFO"]).'/'. $dossier.$fichier.'>Afficherl le fichier que vous avez envoyé:'.$pathA.' </a>';
            */
	        echo '<a href = '. $dossier.$fichier.'>Afficherl le fichier que vous avez envoyé</a>';
        }
        else
        {
            echo ' pas bien ';
        }
    }

//echo '<pre>'. print_r($_FILES,1).'</pre>';
//echo dirname($_SERVER["ORIG_PATH_INFO"]);