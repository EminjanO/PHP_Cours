<?php
/**
 * Created by PhpStorm.
 * User: eminjan
 * Date: 9/03/17
 * Time: 7:07
 */

require_once 'mesFonctions.inc.php';
require_once 'dbConnect.inc.php';

if (!(isset($_GET['rq']))) $_GET['rq'] = 'rq_nonExiste';
else if (empty($_GET['rq'])) $_GET['rq'] = 'rq_empty';


function listeCours($getGroup)
{
    try
    {
        $dbName = 'minicampus';

        global $__INFOS__;

        $dbh = new PDO ("mysql:host = " . getServer() . ';dbName = ' . $dbName,
            $__INFOS__['user'], $__INFOS__['pswd']);


        if (isset($getGroup) || empty($getGroup))
        {
            $sql = "call 1617he201365.mc_groupIdCourse(?)";

            $sth = $dbh->prepare($sql);

            $sth->execute(array($getGroup));

            $res = $sth->fetchAll(PDO::FETCH_ASSOC);

            if ($res) return $res;
            else return [['résultat' => 'Aucun cours n\'est rattaché à ce groupe !']];
        }
        else
        {
            return [['erreur' => 'Ce group n\'existe pas']];
        }
        $dbh = null;
    }
    catch (PDOException $e)
    {
        return "Erreur !: " . $e->getMessage() . "<br>";
    }
}

$toSend=[];
switch ($_GET['rq'])
{
    case 'tableau':

        echo json_encode([
            'bo124' => [
                'auteur' => 'B.Y.',
                'titre' => 'Connectique',
                'prix' => 5.20
            ],
            'bo254' => [
                'auteur' => 'L.Ch.',
                'titre' => 'Programmation C',
                'prix' => 4.75
            ],
            'bo334' => [
                'auteur' => 'L.Ch.',
                'titre' => 'JavaScript',
                'prix' => 6.40
            ],
            'bo250' => [
                'auteur' => 'D.A.',
                'titre' => 'Mathématiques',
                'prix' => 6.10
            ],
            'bo604' => [
                'auteur' => 'V.V.',
                'titre' => 'Objets',
                'prix' => 4.95
            ],
            'bo025' => [
                'auteur' => 'D.M.',
                'titre' => 'Electricité',
                'prix' => 7.15
            ],
            'bo099' => [
                'auteur' => 'D.M.',
                'titre' => 'Phénomènes Périodiques',
                'prix' => 6.95
            ],
            'bo023' => [
                'auteur' => 'V.MN.',
                'titre' => 'Programmation Java',
                'prix' => 5.75
            ],
            'bo100' => [
                'auteur' => 'D.Y.',
                'titre' => 'Bases de Données',
                'prix' => 6.35
            ],
            'bo147' => [
                'auteur' => 'V.V.',
                'titre' => 'Traitement de Signal',
                'prix' => 4.85
            ],
            'bo004' => [
                'auteur' => 'B.W.',
                'titre' => 'Sécurité',
                'prix' => 5.55
            ],
            'bo074' => [
                'auteur' => 'B.Y.',
                'titre' => 'Electronique digitale',
                'prix' => 4.35
            ],
            'bo257' => [
                'auteur' => 'D.Y.',
                'titre' => 'Programmation Multimedia',
                'prix' => 6.00
            ]
        ]);

        break;

    case 'listeCours':
        if (!isset($_GET['groupe'])) $_GET['groupe'] = '';
        $destination = isset($_GET['dest'])?$_GET['dest']:'contenu';
        $tableau = listeCours($_GET['groupe']);
        $toSend = ['creeTableau'=>['destination' => $destination, 'tableau' => $tableau]];
        break;

    default :
        echo json_encode([
            '0' => [
                'rq' => $_GET['rq'],
                'groupe' => $_GET['groupe'],
                'submit' => $_GET['submit']
            ]
        ]);
    // default : echo require_once('sem03p99.php');//echo json_encode('[]');
}
echo json_encode($toSend);