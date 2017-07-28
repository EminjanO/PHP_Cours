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

try
{
	$dbh = new PDO ( "mysql:host = ".getServer().';dbName = '.$dbName,
	                 $__INFOS__['user'],$__INFOS__['pswd']);
	$sqlT = "call 1617he201365.mc_parentGroup(?)";
	
	$sthTestP = $dbh->prepare($sqlT);
	$sthTestP->execute(array($groupe));
	
	$infos = $sthTestP->fetch(PDO::FETCH_ASSOC);
	if(!empty($infos))
	{
		$sql = "call 1617he201365.mc_coursesGroup(?)";
		
		$sth = $dbh->prepare($sql);
		$sth->execute(array($groupe));
		$res = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		echo 'Groupe : '.$groupe.'<br>';
		echo 'Nom du parent : '. $infos['parentName']."<br>";
		echo monPrint_r($res);
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
