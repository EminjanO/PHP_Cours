<?php
/**
 * Created by PhpStorm.
 * User: eminjan
 * Date: 2/17/17
 * Time: 3:16 PM
 */
/*
$tableau = [
    'bo124' =>['auteur'=> 'B.Y.',  'titre'=> 'Connectique',              'prix'=> 5.20],
    'bo254' =>['auteur'=> 'L.Ch.', 'titre'=> 'Programmation C',          'prix'=> 4.75],
    'bo334' =>['auteur'=> 'L.Ch.', 'titre'=> 'JavaScript',               'prix'=> 6.40],
    'bo250' =>['auteur'=> 'D.A.',  'titre'=> 'Mathématiques',            'prix'=> 6.10],
    'bo604' =>['auteur'=> 'V.V.',  'titre'=> 'Objets',                   'prix'=> 4.95],
    'bo025' =>['auteur'=> 'D.M.',  'titre'=> 'Electricité',              'prix'=> 7.15],
    'bo099' =>['auteur'=> 'D.M.',  'titre'=> 'Phénomènes Périodiques',   'prix'=> 6.95],
    'bo023' =>['auteur'=> 'V.MN.', 'titre'=> 'Programmation Java',       'prix'=> 5.75],
    'bo100' =>['auteur'=> 'D.Y.',  'titre'=> 'Bases de Données',         'prix'=> 6.35],
    'bo147' =>['auteur'=> 'V.V.',  'titre'=> 'Traitement de Signal',     'prix'=> 4.85],
    'bo004' =>['auteur'=> 'B.W.',  'titre'=> 'Sécurité',                 'prix'=> 5.55],
    'bo074' =>['auteur'=> 'B.Y.',  'titre'=> 'Electronique digitale',    'prix'=> 4.35],
    'bo257' =>['auteur'=> 'D.Y.',  'titre'=> 'Programmation Multimedia', 'prix'=> 6.00]
];
*/
/**
 * @param string $p
 */
function scriptInfos($p="info")
{
    static $count=0;

    if($count==0)
    {
        if(!defined('__SCRIPT_NAME__')) define('__SCRIPT_NAME__',$_SERVER["SCRIPT_NAME"]);
        if(!defined('__SCRIPT_DNS__')) define('__SCRIPT_DNS__',$_SERVER["USERDOMAIN"]);
        if(!defined('__SCRIPT_PATH__')) define('__SCRIPT_PATH__',$_SERVER["PATH_TRANSLATED"]);
        if(!defined('__SCRIPT_PROTOCOL__')) define('__SCRIPT_PROTOCOL__',$_SERVER["SERVER_PROTOCOL"]);

    }
    $count++;
    $scriptName=__SCRIPT_NAME__;
    $scriptDns=__SCRIPT_DNS__;
    $scriptPath=__SCRIPT_PATH__;
    $scriptProtocol=__SCRIPT_PROTOCOL__;

    $arr=explode(".",__SCRIPT_NAME__);
    /**
     * @var pour que obtenir array qu'on a eu via explode $arr
     */
    $scriptExtention=".".$arr[count($arr)-1]; // extention avec "."
    $scriptShortName=basename(__SCRIPT_NAME__,".php"); //le scriptName sans l'extention.
    //$cur_dir = basename(dirname($_SERVER[PHP_SELF]));
    $scriptDirs=explode("\\",$_SERVER["PATH_TRANSLATED"]);
    //print_r($scriptDirs);  //un tableau contenant la liste des dossiers composant le path
    $scriptLongPath= __SCRIPT_NAME__; // e chemin complet, nom du fichier compris, depuis la racine du site

    $scriptFullPath = __SCRIPT_PROTOCOL__.__SCRIPT_DNS__.__SCRIPT_NAME__;//le chemin complet (protocole + dns + path + nom)
    // C'est le retour par défaut (si aucun paramètre lors de l'appel)
    $scriptInfos = array("scriptName" =>$_SERVER["SCRIPT_NAME"] , "scriptDns" =>$_SERVER["USERDOMAIN"],
        "scriptPath"=>$_SERVER["PATH_TRANSLATED"], "scriptProtocol"=>$_SERVER["SERVER_PROTOCOL"]);

    $variables = array('scriptName', 'scriptDns', 'scriptPath', 'scriptProtocol', 'scriptExtention',
        'scriptShortName', 'scriptDirs', 'scriptLongPath', 'scriptFullPath','scriptInfos');

    switch (strtolower($p)) {
        case strtolower(substr($variables[0],6)):
            echo $$variables[0];
            break;
        case strtolower(substr($variables[1],6)):
            echo $$variables[1];
            break;
        case strtolower(substr($variables[2],6)):
            echo $$variables[2];
            break;
        case strtolower(substr($variables[3],6)):
            echo $$variables[3];
            break;
        case strtolower(substr($variables[4],6)):
            echo $$variables[4];
            break;
        case strtolower(substr($variables[5],6)):
            echo $$variables[5];
            break;
        case strtolower(substr($variables[6],6)):
            foreach ($scriptDirs as $key => $value) {
                echo "$key => $value<br />";
            };
            break;
        case strtolower(substr($variables[7],6)):
            echo $$variables[7];
            break;
        case strtolower(substr($variables[8],6)):
            echo $$variables[8];
            break;
        case strtolower(substr($variables[9],6)):
            foreach ($scriptInfos as $k => $v) {
                echo "$k => $v<br />";
            };
            break;
    }
    //echo  "<hr>".$count." times defined";
}

function creeTableau($liste, $titre='', $index = false)
{
    // P27(slide 3) P41
    $style = ["display:".$index , 'font-style: italic'];


    $fatherKeyList = array_keys($liste); // pour obtenir le reference 1er array
    if(is_array($liste[$fatherKeyList[0]]))
    {
        $listKeysKeys=array_keys($liste[$fatherKeyList[0]]); // pour récuperer les titre des sous array
    }

    $tbOut = "<table>";
    if(! empty($titre))
    {
        $tbOut .= '<caption>'.$titre.'</caption>';
    }
    $tbOut .= '<thead>';
    $tbOut .= "<tr>";
    if($index)
    {
        $tbOut .= "<th style='".implode(';',$style)."'>index</th>"; //
    }

    for($i=0; $i < count($listKeysKeys); $i++)
    {
        $tbOut .= "<th>$listKeysKeys[$i]</th>";
    }
    $tbOut .= "</tr>";
    $tbOut .= '</thead>';
    $tbOut .= '<tbody>';

        foreach($liste as $key => $val)
        {
            $tbOut .= "<tr>";
            if($index)
            {
                $tbOut .=  "<td style='".implode(';',$style)."'>$key</td>";
            }
            for($i=0; $i < count($listKeysKeys); $i++)
            {
                $tbOut .= "<td>".$val[$listKeysKeys[$i]]."</td>";
            }
            $tbOut .= "</tr>";
        }

    $tbOut .= "</tbody>";
    $tbOut .= "</table>";

    return $tbOut;
}

function monPrint_r(&$liste)
{
    $out = "<pre>\n";
    if (is_array($liste)) $out .= print_r($liste,1);
    else $out .= '/[] : ' .$liste;
    $out .= "</pre><hr>";
    return $out;
}

function getServer()
{
    if (scriptInfos('scriptDns') == '193.190.65.94') {
        return 'localhost';
    } else {
        return '193.190.65.94';
    }
}
/*
// $a = ['a'=>'bonjour','b'=>[1=>'le',0=>'monde']]; //pour tester
echo monPrint_r($tableau);
echo creeTableau($tableau, 'sans titre', 'none');
echo "<hr>";
echo creeTableau($tableau, 'avec titre', 'inline-block');

scriptInfos("name");
echo "<hr>";
scriptInfos("dns");
echo "<hr>";
scriptInfos("Path");
echo "<hr>";
scriptInfos("PRotoCol");
echo "<hr>";
scriptInfos("Extention");
echo "<hr>";
scriptInfos("shortName");
echo "<hr>";
scriptInfos("dIrs");
echo "<hr>";
scriptInfos("longpaTh");
echo "<hr>";
scriptInfos("fUllpath");
echo "<hr>";
scriptInfos("inFOS");
echo "<hr>";
*/

