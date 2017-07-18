<?php
/**
 * Created by PhpStorm.
 * User: eminjan
 * Date: 2/24/17
 * Time: 2:34 PM
 */
require_once('dbConnect.inc.php');
require_once('mesFonctions.inc.php');
/*
$sourceDeDonnees = "mysql:host = 193.190.65.94; dbName = ".$dbName;
$utilisateur = "OBULKASIM";
$motPasseUtilisateur = "Eminjan62bW";
*/

$dbName = 'minicampus';

/*
 * créez une variable $sql qui contient la requête (Cfr. travail à domicile de la sem02)
 * correspondant à la demande : Afficher la liste des cours (code, faculté et libellé)
 *  pour une classe (p.e. 1TL2) donnée>>
 */

$sql = "SELECT
          cours.code, faculte, cours.intitule
        FROM
          minicampus.cours
        INNER JOIN
          minicampus.course_class ON cours.code = course_class.cours_id
        INNER JOIN
          minicampus.class ON class.id = course_class.class_id
        WHERE
          class.nom = '1TL2'
        order by cours.code";


try
{
	$dbh = new PDO ("mysql:host = " . getServer() . ';dbName = ' . $dbName,
	                $__INFOS__['user'], $__INFOS__['pswd']);
	
	$query = $dbh->query($sql);
	
	foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $row)
	{
		echo monPrint_r($row);
	}
	$dbh = null;
}
catch (PDOException $e)
{
	print "Erreur !: " . $e->getMessage() . "<br>";
	die();
}
