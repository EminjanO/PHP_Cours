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

function chargeTemplate($form)
{
	$out = [];
	switch ($form)
	{
		case 'contact':
			$out = file('template.'.$form.'.inc.php'); // machans filename:'template.'.....
			if(!$out) $out[]='problème fichier';
			break;

        case 'logo' :
            $out = file('template.logo.inc.php'); // machans filename:'template.'.....
            if(!$out) $out[]='problème fichier';
            break;

		default : $out[]='<span class=erreur>Template inconnu : '.$form.'</span>';
    }
	return implode("\n", $out);
}

function sendMail()
{
    $msg=&$_POST;
    $out = array_merge(
        [
            '<http>'
            ,'<head>'
            ,'<title>Mon page mail</title>'
           //,'<style>'
            //,'table, td { border: 1px solid black;}'
            //,'td:firstchild {font-weight: bold;}'
            //,'</style>'
            ,'</head>'
            ,'<body>'
            ,'<div>'
        ],
        $corps = [
            '<fieldset class = "fSet" title="Message provenant de \'contact\'">'
            ,'<legend>Message provenant de "contact"</legend>'
            ,'<table style="border: 1px solid black; border-collapse: collapse">'
            ,'<tr class="msgFrom"><td style="border: 1px solid black;font-weight: bold; padding: 1.5em;">mail</td>
                                                    <td style="border: 1px solid black; padding: 0.5em;">'.$msg['fc_email'].'</td></tr>'
            ,'<tr class="megSubject"><td style="border: 1px solid black;font-weight: bold; padding: 1.5em;">sujet</td>
                                                    <td style="border: 1px solid black; padding: 0.5em;">'.$msg['fc_sujet'].'</td></tr>'
            ,'<tr class="msgMsg"><td style="border: 1px solid black;font-weight: bold; padding: 1.5em;">message</td>
                                                    <td style="border: 1px solid black; padding: 0.5em;">'.$msg['fc_message'].'</td></tr>'
            ,'</table>'
            ,'</fieldset>'
        ],
    ['</div>'
        ,'</body>'
        ,'</html>'
    ]
    );
    ini_set('sendmail_from','e.obulkasim@strudents.ephec.be');
    $headers = implode("\r\n",['MIME-Version: 1.0'
                                                ,'Content-type: text/html; charset=ISO-8859-1'
                                                ,'From:'.___MATRICULE___.'@students.ephec.be'
                                                ]
                                    );
    $to = $msg['fc_email'];
    $sujet = $msg['fc_sujet'];
    $message = implode("\n", $out);
    $result = mail($to, $sujet, $message, $headers);
    return implode("\n", array_merge($corps));
}

function chargeLogo()
{
	$target_dir = "../IMG/";
	$target_file = $target_dir . "logo.jpg";
	$avatarMaxSize = $_POST["fl_size"];
	//calcul des nouvelle
	list($width_orig, $height_orig) = getimagesize($_FILES['fl_file']['tmp_name']);
	$ratio_orig = $width_orig / $height_orig;
	$new_height = $avatarMaxSize;
	$new_width = $avatarMaxSize;
	if ($new_width / $new_height > $ratio_orig) {
		$new_width = $new_height * $ratio_orig;
	} else {
		$new_height = $new_width / $ratio_orig;
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
	//chargement
	imagecopyresampled($thumb, $image, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
	switch($_FILES["fl_file"]["type"]){
		case "image/jpeg":
			imagejpeg($thumb, $target_file);
			break;
		case "image/jpg":
			imagejpeg($thumb, $target_file);
			break;
		case "image/gif":
			imagegif($thumb, $target_file);
			break;
		case "image/png":
			imagepng($thumb, $target_file);
			break;
		default:
			echo 'Une erreur est survenue lors de la création de l\'avatar';
	}
	return ["changeLogo" => "IMG/logo.jpg"/*.'?'.time()*/];
	//return monPrint_r($GLOBALS);
}

function connexion(){
	$fond=['', 'black', 'Fuchsia', 'DarkBlue', 'DeepPink', 'OrangeRed', 'Teal', 'DarkRed', 'DarkMagenta'];
	//return monPrint_r($GLOBALS);
	$tab = userInfo();
	if(sizeof($tab) != 0) return ['contenu' =>"<pre>".print_r($tab,true)."</pre>",'fond'=>$fond[$tab[0]["uId"]]];
	else return ['contenu' =>"pseudo et/ou mot de passe incorrect(s)"];
}

function userInfo(){
	define('___MATRICULE___','HE201365');
	$__INFOS__ = array(   'matricule'=> ___MATRICULE___
	                      ,'host' => 'localhost'
	                      ,'user' => 'OBULKASIM'
	                      ,'pswd' => 'Eminjan62bW'
	                      ,'dbName' => '1617he201365'
	                      ,'nom' => 'OBULKASIM'
	                      ,'prenom' => 'Eminjan'
	                      ,'classe' => '2TL2'
	);
	$dbname = "1617he201365";
	$sqlQuerry = "call 1617he201365.he_userConnect(?,?);";
	$sql = new PDO('mysql:host=localhost;dbname=' . $dbname, $__INFOS__['user'], $__INFOS__['pswd']);
	$request = $sql->prepare($sqlQuerry);
	$sth = $request->execute(array($_POST["flg_pseudo"],$_POST["flg_cle"]));
	$tab = $request->fetchAll(PDO::FETCH_ASSOC);
	
	return $tab;
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
        
	case 'config':
		$tosend = ['contenu'=>afficheConfig(chargeConfig("config.ini"))];
		break;
	
	case 'modifConfig':
		$tosend = sauveConfig();//;
		break;
		
	case 'formContact':
		$toSend['contenu'] = chargeTemplate('contact'); // y a un bazzard comme form: ici !!!
		break;

	case 'sendFormContact':
		$toSend['contenu'] = sendMail();
		break;

    case 'formLogo':
        $toSend['contenu'] = chargeTemplate('logo');
        break;
        
	case 'sendFormLogo':
		$toSend/*['contenu']*/ = chargeLogo();
		break;
		
    case 'listeCours':
        if (!isset($_GET['groupe'])) $_GET['groupe'] = '';
        $destination = isset($_GET['dest'])?$_GET['dest']:'contenu';
        $tableau = listeCours($_GET['groupe']);
        $toSend = ['creeTableau'=>['destination' => $destination, 'tableau' => $tableau]];
        break;
        
	case 'sendFormLogin':
		$toSend = connexion();
		break;
	case 'formLogin':
		$toSend = ['contenu' => chargeTemplate('connexion')];
		break;
    default :
	    $toSend=[
            'contenu' => 'Requête incunnue : '.$_GET['rq']
            /*[
                'rq' => $_GET['rq'],
                'groupe' => $_GET['groupe'],
                'submit' => $_GET['submit']
            ]*/
        ];
    // default : echo require_once('sem03p99.php');//echo json_encode('[]');
}
//echo json_encode($toSend['creeTableau']['tableau']);    // c'etais comme ça : echo json_encode($tableau);
echo json_encode($toSend);