<?php
/**
 * Created by PhpStorm.
 * User: eminjan
 * Date: 9/04/17
 * Time: 0:06
 */

// 1 partie

//mail('e.obulkasim@students.ephec.be','sujet','message','From:HE201365@students.ephec.be');
/*
$to = 'e.obulkasim@students.ephec.be';
$from = 'From:HE201365@students.ephec.be';
$sujet = 'Ceci est un mail de test';
$message = 'Bonjour, ceci est un envoi de mail test';

mail($to, $sujet, $message, $from);
*/

// 2 partie
/*
$to = 'e.obulkasim@students.ephec.be';
$sujet = 'Ceci est un mail de test html';
$entete = "From:HE201365@students.ephec.be \r\n";

//ici on défini le format, soit html
$entete .= "Content-Type: text/html; charset=utf-8\r\n";

$message = "<b>Bonjour, ceci est un envoi de mail test</b>
            <a href=\"http://193.190.65.94/HE201365/2_PROJET/phase_00_c/index.php\" rel=\"prev\">Phase_00_c</a>";

mail($to, $sujet, $message, $entete);
*/

// with form
if (isset($_POST['envoyer'])) {
	$from = $_POST['from'];
	$destinataire = 'HE201365@students.ephec.be';
	
    if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $from))  // filtrer les serveurs  ou  utilise \n
    {
        $passage_ligne = "\r\n";
    }
    else
    {
        $passage_ligne = "\n";
    }

    $sujet = $_POST['sujet'];

    $message = htmlentities($_POST['message']);
    $message .= '<br><a href="http://193.190.65.94/HE201365/1_TP/TP_05/form_mail.html">Contact</a>';

    $entete = 'MIME-Version: 1.0' . $passage_ligne; // Version MIME
    $entete .= 'Content-type: text/html; charset=ISO-8859-1' .$passage_ligne; // l'en-tete Content-type pour le format HTML
    $entete .= "From:" . $from;

    if (mail($destinataire, $sujet, $message, $entete)) {
        echo 'Votre message a bien été envoyé ';
    } else {
        echo ' Vous pensez que votre message a bien été envoyé ? NON !';
    };
}