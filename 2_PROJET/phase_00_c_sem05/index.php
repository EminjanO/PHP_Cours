<?php
global $__INFOS__;
include 'INC/dbConnect.inc.php';
$auteur= $__INFOS__['nom'].$__INFOS__['prenom'];
$mailAdd=$__INFOS__['matricule'].'@students.ephec.be';
$title='Accueil';
$titreDePage='Phase 00_c - sem04';
$srcIMG='IMG/04.png';
$alternIMG='logo';
$bienvenue='Bienvenue';
include 'INC/layout.html.inc.php';