<?php
/**
 * Created by PhpStorm.
 * User: eminjan
 * Date: 2/24/17
 * Time: 2:34 PM
 */
$groupe = (isset($_GET['groupe'])) ? ($_GET['groupe']) : '';
?>
<form method="get" action="">
	<input type="text" name="groupe" placeholder="groupe recherché"
		   value="<?php $groupe?>"/>
	<input type="submit" value="Envoi"/>
</form>

<?php

if(!isset($_GET['groupe']) || $_GET['groupe'] == '') exit();

require_once('dbConnect.inc.php');
require_once('mesFonctions.inc.php');

$dbName = 'minicampus';

$sql = "SELECT
    		cours.code, faculte, cours.intitule
		FROM
    		minicampus.cours
    	INNER JOIN
    		minicampus.course_class ON cours.code = course_class.cours_id
    	INNER JOIN
    		minicampus.class ON class.id = course_class.class_id
		WHERE
    		class.nom = ?/*'$groupe'*/ 
		order by cours.code";

try
{
	$dbh = new PDO ("mysql:host = " . getServer() . ';dbName = ' . $dbName,
	                $__INFOS__['user'], $__INFOS__['pswd']);
	
	$sth = $dbh->prepare($sql);
	$sth->execute(array($groupe));
	$res = $sth->fetchAll(PDO::FETCH_ASSOC);
	
	//$query = $dbh->query($sql);
	//$db = $dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	if(!empty($res))
	echo creeTableau($res, 'AVEC Index', 1);
	$dbh = null;
}
catch (PDOExceparentNameption $e)
{
	print "Erreur !: " . $e->getMessage() . "<br>";
	die();
}
