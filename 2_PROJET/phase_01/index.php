<?php
require_once('inc/lib.request.inc.php');
require_once("inc/lib.config.inc.php");
require_once('inc/lib.db.inc.php');
require_once ('inc/mesFonction.inc.php');
$GLOBALS['config'] = chargeConfig("inc/config.inc.php");

if (isset($_GET['rq']) && $_GET['rq']!='') {
	gereRequete($_GET['rq']);
}
else {
	//echo $_GET['rq'];
	$title = 'Accueil';
	//$nomSite = 'Phase 00_c';
	$nomSite = $config['SITE']['titre'];
	//$logoPath = 'img\04.png';
	$logoPath = 'img/' . $config['LOGO']['logo'];
	$logoAlt = 'Logo';
	$contenu = "Bienvenue";
	$rq = "inconnu";
	$html = "";
	//require_once('inc/dbConnect.inc.php');
	//include("inc/appelHTML.php");
	//include("inc/appelJSON.php");
	$mail = $config['EPHEC']['mail'];
	$auteur = "<a href='formContact.html' onclick='newAjaxJSON(this); return false;'>" . $config['ADMIN']['label'] . "</a>";
	require_once("inc/layout.html.inc.php");
}
