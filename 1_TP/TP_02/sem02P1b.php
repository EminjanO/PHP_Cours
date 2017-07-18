<?php
/**
 * Created by PhpStorm.
 * User: eminjan
 * Date: 2/17/17
 * Time: 2:33 PM
 */
echo $_SERVER["SCRIPT_NAME"]."<br>"; //	/HE201365/1_TP/TP_02/sem02P1a.php
echo $_SERVER["USERDOMAIN"]."<br>"; //  EPHEC
echo _SERVER["PATH_TRANSLATED"]."<br>";  //C:\inetpub\ftproot\1617\HE201365\1_TP\TP_02\sem02P1a.php
echo $_SERVER["SERVER_PROTOCOL"]."<br>"; //	HTTP/1.1
echo "Hello world ! <br>";
print_r( $explResult=explode("\\",$_SERVER["PATH_TRANSLATED"]));
/*
foreach ($explResult as $rerultArray){
    echo $rerultArray."<br>";
}
*/