<?php
/**
 * Created by PhpStorm.
 * User: eminjan
 * Date: 21/04/17
 * Time: 7:11
 */
    if(isset($_FILES["fichierUpload"]) && isset($_POST["id"]))
    {
        $extentinsValides = array('jpg', 'jpeg', 'gif', 'png');
        //1. strrchr renvoie l'extention avec le point (" . ");
        //2. substr(chaine, 1) ignore le premier caractère de chaine.
        //3. strtolower met l'extention en minuscules.
        $extentionUpload = strtolower(substr(strrchr($_FILES['fichierUpload']['name'], '.'), 1));
        if(in_array($extentionUpload, $extentinsValides))
        {
            $dossier = 'AVATARS/';
	        $avatarMaxSize= 150; //(px)
            $fichier = basename($_FILES['fichierUpload']['name']); // y a un bug ici, si il ya une space dans le non de fichier !!!!!!!!
            if(move_uploaded_file($_FILES['fichierUpload']['tmp_name'], $dossier . $fichier))
            {
                //echo '<a href = '. $dossier.$fichier.'>Afficherl le fichier que vous avez envoyé</a>';
	            if($extentionUpload == "jpg" || $extentionUpload == "jpeg" ) // on vrée une ressource representatn
		                                                                    // en fait l'image à miniaturiser
	            {
	            	$src = imagecreatefromjpeg($dossier.$fichier);
	            }
	            elseif ($extentionUpload == "png")
	            {
	            	$src = imagecreatefrompng($dossier.$fichier);
	            }
	            else
	            {
	            	$src = imagecreatefromgif($dossier.$fichier);
	            }
	            $size = getimagesize($dossier.$fichier); // récupère les paramètres de notre image
	            // tester si la largeur de l'image est supérieur à sa longueur
	            if($size[0] > $size[1])
	            {
		            // creer un eresource pour miniature
		            $im = imagecreate(round(($avatarMaxSize/$size[1])*$size[0]), $avatarMaxSize);
		            // placer dans la ressource que nous venons de créer une copie de l'image originelle,
		            //redimentionnée et réechantillonnée
		            imagecopyresampled($im, $src,0,0,0,0, round(($avatarMaxSize/$size[1])*$size[0]),
		                               $avatarMaxSize,$size[0],$size[1]);
	            }
	            else
	            {
	            	// si la laegeur est inférieure ou égale à la hauteur, on entre dans ce cas
		            // créer une ressource pour notre miniature
		            $im = imagecreate($avatarMaxSize,round(($avatarMaxSize/size[0])*size[1]));
		            // placer dans la ressource que nous venons de créer une copie de l'image originelle,
		            // redimensionnée et réechantillonée
		            imagecopyresampled($im, $src, 0,0,0,0, $avatarMaxSize, round($size[1]*($avatarMaxSize/$size[0])),
		                               $size[0], size[1]);
	            }
	            // définir le nom de notre miniature
	            $id = $_POST["id"];
	            $miniature = "$dossier$id.$extentionUpload";
	            // créer notre miniature
	            if($extentionUpload == "jpg" || $extentionUpload == "jpeg" ) // on crée une ressource representatn
		                                                                    // en fait l'image à miniaturiser
	            {
		            imagejpeg($im,$miniature);
	            }
	            elseif ($extentionUpload == "png")
	            {
		            imagepng($im,$miniature);
	            }
	            else
	            {
		           imagegif($im,$miniature);
	            }
	            echo '<a href = '.$miniature.'>Afficherl le fichier que vous avez envoyé</a>';
            }
            else
            {
                echo ' pas bien ';
            }
        }
        else
        {
            echo ' c\'est pas une fichier valable (image)';
        }
    }

//echo '<pre>'. print_r($_FILES,1).'</pre>';

