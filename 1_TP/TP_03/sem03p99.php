<form method="get" action="">
    <input type="text" name="groupe" placeholder="groupe recherché"
           value="<?php if(isset($_GET['groupe']) and $_GET['groupe'] != NULL) echo $_GET['groupe']; ?>"/>
    <input type="submit" value="Envoi" />
</form>

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

//$groupe = '1TL2';
$groupe = (isset($_GET['groupe'])) ? ($_GET['groupe']) : false;

$dbh = new PDO ( "mysql:host = ".getServer().';dbName = '.$dbName,
    $__INFOS__['user'],$__INFOS__['pswd']);

if(isset($_GET['groupe']))
{
    try
    {
        $sqlT = "call 1617he201365.mc_parentGroup(?)";

        $sth  = $dbh->prepare($sqlT);
        $sth->execute(array($groupe));

        $infos = $sth->fetch(PDO::FETCH_ASSOC);

        if($infos != null || isset($infos))
        {
            $sql = "call 1617he201365.mc_coursesGroup(?)";


            $sth = $dbh->prepare($sql);

            $sth->execute(array($groupe));

            $res = $sth->fetchAll(PDO::FETCH_ASSOC);

            echo 'Groupe : '.$groupe.'<br>';
            echo 'Nom du parent : '. $infos['parentName']."<br>";
            //$query = $dbh->query($sql);
            //$db = $dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            if($res) echo creeTableau($res,'AVEC titre',1);
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
}