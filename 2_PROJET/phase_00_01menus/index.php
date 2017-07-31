<?php
include 'INC/dbConnect.inc.php';
global $__INFOS__;
$auteur= $__INFOS__['nom'].$__INFOS__['prenom'];
$mailAdd=$__INFOS__['matricule'].'@students.ephec.be';
$title='Accueil';
$titreDePage='Nom de mon site';
$srcIMG='IMG/04.png';
$alternIMG='logo';
$bienvenue='Bienvenue';
include 'INC/layout.html.inc.php';
