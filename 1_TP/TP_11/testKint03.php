<?php
/**
 * Created by PhpStorm.
 * User: HE201365
 * Date: 12-05-2017
 * Time: 14:50
 */
include 'kint/kint.inc.php';
kint::trace();
$_GET['rq']='listeCours';
$_GET['groupe']= 5;
kint::trace($_GET);
include '../../2_PROJET/phase_00_c_sem05/INC/newAppelJSON.php';
kint::trace($toSend);
//kint::dump($GLOBALS);
//kint::dump($_GET,$toSend);
//kint::dump($_GET);
