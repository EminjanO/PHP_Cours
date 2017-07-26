<?php
/**
 * Created by PhpStorm.
 * User: eminjan
 * Date: 7/26/17
 * Time: 4:39 PM
 */
echo '<p>au nom de votre script :<br>'. "  ". $_SERVER["SCRIPT_NAME"]."</p>"; //	/HE201365/1_TP/TP_02/sem02P1a.php
echo '<p>au dns du serveur :<br>'. "   ". $_SERVER["USERDOMAIN"]."</p>"; //  EPHEC
echo '<p>au chemin permettant d\'aller de la racine du serveur à votre script :<br>'
	. " ". $_SERVER["PATH_TRANSLATED"]."</p>";  //C:\inetpub\ftproot\1617\HE201365\1_TP\TP_02\sem02P1a.php
echo '<p>au type de protocole utilisé :<br>'. "    ". $_SERVER["SERVER_PROTOCOL"]."</p>"; //	HTTP/1.1

echo "<pre>";
print_r( $explResult=explode("\\",$_SERVER["PATH_TRANSLATED"]));
echo "</pre>";