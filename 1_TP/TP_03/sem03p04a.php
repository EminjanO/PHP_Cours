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
        if($infos != null || isset($infos))
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