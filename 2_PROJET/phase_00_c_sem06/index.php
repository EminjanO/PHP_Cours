<?php
global $__INFOS__;
include 'INC/dbConnect.inc.php';
include "INC/lib.config.inc.php";
$config = chargeConfig("INC/config.ini");
$auteur= $__INFOS__['nom'].$__INFOS__['prenom'];
$mailAdd=$__INFOS__['matricule'].'@students.ephec.be';
$title='Accueil';
$titreDePage=$config["SITE"]["titre"];   //'Phase 00_c - sem04';
$srcIMG=$config["LOGO"]["logo"];        //'IMG/04.png';
$alternIMG=$config["SITE"]["images"];   //'logo';
$bienvenue='Bienvenue';
include 'INC/layout.html.inc.php';
