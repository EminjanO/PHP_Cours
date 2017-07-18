<?php
//require_once('lib.db.inc.php');
//require_once("lib.config.inc.php");

function gereRequete($rq)
{
    $toSend = [];
    //echo $_GET['rq'];

    if ($rq == 'listeCours') {
        listeCours();
    } else if ($rq == 'index') {
        $toSend['contenu'] = texteHTML($rq);
        //$toSend['colorSiteName'] = $GLOBALS['config']['test']['color'];
        echo(json_encode($toSend));
    } else if ($rq == 'liste') {
        $toSend['contenu'] = texteHTML($rq);
        echo(json_encode($toSend));
    } else if ($rq == 'utiliser') {
        $toSend['contenu'] = utiliser();
        echo(json_encode($toSend));
    } else if ($rq == 'tpSem04') {
        $toSend = tpSem04();
        echo(json_encode($toSend));
    } else if ($rq == 'tableau') {
        $toSend = getArray($rq);
        echo json_encode($toSend);
    } else if ($rq == 'listeCoursSem03') {
        $toSend = getArray($rq);
        echo json_encode($toSend);
    } else if ($rq == 'formContact') {
        $toSend['contenu'] = chargeTemplate('contact');
        echo(json_encode($toSend));
    } else if ($rq == 'formLogo') {
        $toSend['contenu'] = chargeTemplate('logo');
        echo(json_encode($toSend));
    } else if ($rq == 'formLogin') {
        $toSend['contenu'] = chargeTemplate('connexion');
        echo(json_encode($toSend));
    } else if ($rq == 'config') {
        //require_once("lib.config.inc.php");
        //$config = chargeConfig("inc/config.inc.php");
        $toSend['contenu'] = afficheConfig($GLOBALS['config']);
        echo(json_encode($toSend));
    } else if ($rq == 'ephec') {
        //require_once("lib.config.inc.php");
        //$config = chargeConfig("inc/config.inc.php");
        $toSend['contenu'] = afficheEphec($GLOBALS['config']);
        echo(json_encode($toSend));
    } else if ($rq == 'sendFormContact') {
        //print_r($GLOBALS);
        //echo ("<pre>print_r($GLOBALS)</pre>");
        $toSend['contenu'] = sendmail();
        echo(json_encode($toSend));
    } else if ($rq == 'sendFormLogo') {
        $toSend['changeLogo'] = chargeLogo();
        echo(json_encode($toSend));
    } else if ($rq == 'sendFormLogin') {
        $toSend = connexion();
        //print_r($toSend);
        echo json_encode($toSend);
    } else if ($rq == 'modifConfig') {
        //require_once("lib.config.inc.php");
        //include("lib.config.inc.php");
        //$toSend = sauveConfig("config.inc.php");
        //$toSend = sauveConfig('conftest.php');
        $toSend = sauveConfig('inc/config.inc.php');
        //sauveConfig("config.inc.php");
        echo json_encode($toSend);

    } else {
        $toSend = ['contenu' => 'Requete inconnue : ' . $rq];
    }
}

function chargeTemplate($template) {
    $tabSortie = [];
    if ($template == 'contact' || $template == 'logo' || $template == 'connexion' || $template == 'avatar' || $template == 'background') {
        $tabSortie = file('inc/template.' . $template . ".inc.php");
        if(!$tabSortie) {
            $tabSortie[] = 'probleme de fichier';
        }
    }
    else if ($template == 'tpSem04') {
        $tabSortie = file("inc/" . $template . ".html");
        if(!$tabSortie) {
            $tabSortie[] = 'probleme de fichier';
        }
    }
    else {
        $tabSortie[] = "<span class='erreur'>Template inconnu : " . $template . "</span>";
    }
    return implode("\n", $tabSortie);
}

function sendmail() {
    //$config = chargeConfig("config.inc.php");
    $msg = &$_POST;
    $mail = $GLOBALS['config']['ADMIN']['mail'];
    //print_r($config);
    $replyto = $_POST['fc_email'];
    $sujet = $_POST['fc_sujet'];
    $sortie = array_merge (
        [
            '<html>',
            '<head>',
            '<title>Titre</title>',
            '<style>',
            '</style>',
            '</head>',
            '<body>',
            '<div>'
        ],
        $corps = [
            '<fieldset>',
            '<table>',
            "<tr class='msgFrom'><td>DE : </td><td>$replyto</td></tr>",
            "<tr class='msgSubject'><td>SUJET : </td><td>$sujet</td></tr>",
            "<tr class='msgMsg'><td>MESSAGE : </td><td>" . $msg['fc_message'] . "</td></tr>",
            '</table>',
            '</fieldset>' ],
            [
            '</div>',
            '</body>',
            '<html>'
        ]
    );
    ini_set('sendmail_from', $mail);
    $message = implode("\n", $sortie);
    $headers = implode("\r\n", ['MIME-Version: 1.0', 'Content-Type:text/html;charset=utf-8\r\n', "from: $mail"]);
    $result = mail($replyto, $sujet, $message, $headers);
    $result2 = mail($mail, $sujet, $message, $headers);
    return implode("\n", array_merge($corps));
}

function chargeLogo() {
    $dossier = "img/";
    $fichier = $dossier . "logo.jpg";
    $avatarMaxSize = $_POST["fl_size"];
    list($source_image_width, $source_image_height) = getimagesize($_FILES['fl_file']['tmp_name']);

    $source_aspect_ratio = $source_image_width / $source_image_height;
    $thumbnail_aspect_ratio = $avatarMaxSize / $avatarMaxSize;

    if ($source_image_width <= $avatarMaxSize && $source_image_height <= $avatarMaxSize) {
        $new_width = $source_image_width;
        $new_height = $source_image_height;
    } elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
        $new_width = (int) ($avatarMaxSize * $source_aspect_ratio);
        $new_height = $avatarMaxSize;
    } else {
        $new_width = $avatarMaxSize;
        $new_height = (int) ($avatarMaxSize / $source_aspect_ratio);
    }

    if ($new_width / $new_height > $source_aspect_ratio) {
        $new_width = $new_height * $source_aspect_ratio;
    } else {
        $new_height = $new_width / $source_aspect_ratio;
    }
    $thumb = imagecreatetruecolor($new_width, $new_height);
    switch($_FILES["fl_file"]["type"]){
        case "image/jpeg":
            $image = imagecreatefromjpeg($_FILES['fl_file']['tmp_name']);
            break;
        case "image/jpg":
            $image = imagecreatefromjpeg($_FILES['fl_file']['tmp_name']);
            break;
        case "image/gif":
            $image = imagecreatefromgif($_FILES['fl_file']['tmp_name']);
            break;
        case "image/png":
            $image = imagecreatefrompng($_FILES['fl_file']['tmp_name']);
            break;
        default:
            echo 'une erreur est survenue dans la fonction reSize()';
            return false;
    }
    imagecopyresampled($thumb, $image, 0, 0, 0, 0, $new_width, $new_height, $source_image_width, $source_image_height);
    switch($_FILES["fl_file"]["type"]){
        case "image/jpeg":
            imagejpeg($thumb, $fichier);
            break;
        case "image/jpg":
            imagejpeg($thumb, $fichier);
            break;
        case "image/gif":
            imagegif($thumb, $fichier);
            break;
        case "image/png":
            imagepng($thumb, $fichier);
            break;
        default:
            echo 'Une erreur est survenue lors de la création de l\'avatar';
    }
    return ['changeLogo' => 'img/logo.jpg'
                . '?'. time()
            ];
}

function connexion() {
    //return ['contenu'=>print_r($GLOBALS, true)];
    $user = userInfo();
    //print_r($user);
    //$usertext = print_r($user, true);
    //echo($usertext);
    $fond=['', 'black', 'Fuchsia', 'DarkBlue', 'DeepPink', 'OrangeRed', 'Teal', 'DarkRed', 'DarkMagenta'];
    if ($user[0]['uId'] != null) {
        return ['contenu'=>print_r($user, true), 'fond'=>$fond[$user[0]['uId']]];
    }
    else {
        return ['contenu'=>'pseudo ou incorrect : <i>' . $_POST['flg_pseudo'] . '</i>'];
    }
}

function texteHTML ($rq) {
    //echo "<hr>TRequête : index<hr>Potentiellement vous êtes déjà  dans la page index<hr>";
    $textes = ['index'=>'Potentiellement vous êtes déjà  dans la page index',
                'liste'=>'La liste de tous les gabarits viendra à point pour celui qui sait attendre',
                'utiliser'=>'',
                'licence'=>'',
                'credits'=>'Les liens "crédits" sont cachés sous le mot correspondant dans le pied de page',
                'tpSem04'=>'',
                'avatar'=>"salut AVATAR",
                ''=>'Bien essayé ! ... mais raté !'];
    return $textes[$rq];
}

function utiliser() {
    return '<form name=\'listeCoursSem03\' action=\'listeCoursSem03.html\' method=\'GET\' onsubmit="newAjaxJSON(this); return false;">
            <input type=\'text\' name=\'groupe\' placeholder=\'groupe recherché\' value=\'\'>
            <input type=\'submit\' name=\'submit\' id=\'envoi\' value=\'Envoi\'></form>';
}

function tpSem04() {
    if (isset(getArray('tpSem04')['PDOException'])) {
        return ['PDOException'=>getArray('tpSem04')];
    }
    else if (getArray('tpSem04') == ""){
        //print_r(getArray('tpSem04'));
        return ['contenu'=>'Mauvais Groupe'];
    }
    //$getArr = print_r (getArray('tpSem04')['PDOException'], true);
    //echo $getArr;
    //include ("tpSem04.html");
    else {
        return ['contenu' => chargeTemplate('tpSem04') . '<div id=\'visu\' name=\'visu\'></div>',
            'listeGroupes' => getArray('tpSem04')
        ];
    }
}