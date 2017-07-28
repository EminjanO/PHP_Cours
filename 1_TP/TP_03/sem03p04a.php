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
			   value=""/>
		<input type="submit" value="Envoi"/>
	</form>
<?php

if(!isset($_GET['groupe']) || $_GET['groupe'] == '') exit();

require_once('dbConnect.inc.php');
require_once('mesFonctions.inc.php');

$dbName = 'minicampus';

try
{
	$dbh = new PDO ( "mysql:host = ".getServer().';dbName = '.$dbName,
					 $__INFOS__['user'],$__INFOS__['pswd']);
	$sqlT = "SELECT
				c.nom, p.nom as parentName
			FROM
				minicampus.class as c
					JOIN
				minicampus.class as p ON c.parent_id = p.id
			WHERE
				c.nom = ?";

	$sthTestP = $dbh->prepare($sqlT);
	$sthTestP->execute(array($groupe));

	$infos = $sthTestP->fetch(PDO::FETCH_ASSOC);
	if(!empty($infos))
	{
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

		$sth = $dbh->prepare($sql);
		$sth->execute(array($groupe));
		$res = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		echo 'Groupe : '.$groupe.'<br>';
		echo 'Nom du parent : '. $infos['parentName']."<br>";
		
		if(!empty($res)) echo creeTableau($res,'AVEC Index',1);
		else echo 'Aucun cours n\'est rattaché à ce groupe !';
	}
	else
	{
		echo 'Ce group n\'existe pas';
	}
}
catch (PDOException $e)
{
	print "Erreur !: " .$e->getMessage()."<br>";
	die();
}
