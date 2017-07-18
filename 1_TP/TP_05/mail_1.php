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

	$to = 'e.obulkasim@students.ephec.be';
	$sujet = 'Ceci est un mail de test html';
	$entete = "From:HE201365@students.ephec.be \r\n";
	
	//ici on défini le format, soit html
	$entete .= "Content-Type: text/html; charset=utf-8\r\n";
	
	$message = "<b>Bonjour, ceci est un envoi de mail test</b>
				<a href=\"http://193.190.65.94/HE201365/2_PROJET/phase_00_c/index.php\" rel=\"prev\">Phase_00_c</a>";
	
	mail($to, $sujet, $message, $entete);

