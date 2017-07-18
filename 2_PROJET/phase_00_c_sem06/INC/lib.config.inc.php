<?php

function chargeConfig($fileName){
    $tabIniFile = parse_ini_file($fileName,true);
    return $tabIniFile;
}
function afficheConfig($config){

    $out = [];
    $out[] = "
    <form id='modifConfig' nom='modifConfig' method='post' action='modifConfig.html' onsubmit='return sendForm(this); return false;'>
        
    ";

    foreach ($config as $cle=>$interTab){

        $out[] = "<fieldset><legend>".$cle."</legend>";
        $out = array_merge($out,gereBloc($cle,$interTab));
        $out[] = "</fieldset>";
    }

    $out[] = "<input type='submit' value='envoie'><span id='resCfgMsg'></span></form>";
    return implode("\n",$out);
}
function sauveConfig()
{
    if (isset($_POST) && sizeof($_POST) != 0) {
        $tabIniFile = parse_ini_file("config.ini", true);
        //echo "<pre>".print_r($tabIniFile,true) . "</pre>";
        //print_r(array_diff_key($tabIniFile,$_POST));
        if(($file = fopen("config.ini", "w"))) {
            foreach ($_POST as $cle => $elem) {
                fwrite($file, "[" . $cle . "]\n");
                foreach ($elem as $clef => $secondElem) {
                    if ($clef == "choix") {
                        foreach ($secondElem as $elemFinal) {
                            fwrite($file, $clef . "[]=" . $elemFinal . "\n");
                        }
                    } else {
                        fwrite($file, $clef . "=" . $secondElem . "\n");
                    }
                }
                foreach (($tabDiff = array_diff_key($tabIniFile[$cle], $_POST[$cle])) as $key => $elemA) {
                    //print_r($elemA);
                    if ($key == "type") {
                        foreach ($elemA as $finalElem) {

                            fwrite($file, $key . "[]=" . $finalElem . "\n");
                        }
                    } else {
                        fwrite($file, $key . "=" . $elemA . "\n");
                    }
                }
            }
            fclose($file);
            return ["modifCfg" => ["OK" => "Configuration sauvegardée dans le fichier idoine"]];
        }
        else{
            return ["modifCfg" => ["KO" => "Une erreur s'est produite !"]];
        }
    }
}
function gereBloc($blocName, $blocContent){
    $min = isset($blocContent['min'])?$blocContent['min']:null;
    $max = isset($blocContent['max'])?$blocContent['max']:null;
    $pas = isset($blocContent['pas'])?$blocContent['pas']:null;
    unset($blocContent['min']);
    unset($blocContent['max']);
    unset($blocContent['pas']);
    $type = [];
    $type = isset($blocContent['type'])?$blocContent['type']:array();
    $choix = isset($blocContent['choix'])?$blocContent['choix']:array();
    unset($blocContent['choix']);
    $out = [];
    foreach ($blocContent as $cle=>$elem){
        //echo "<pre>".print_r($cle)."</pre>";
        //$choix = [];
        $arg = 0;
        switch($cle){
            case "taille":
                $out[] = "<label for=". $elem.">". $cle ."</label><input title='min=".$min." max=".$max." pas=".$pas."' name=".$blocName."[".$cle."] id=". $cle ." type='number' value=".$elem." required  max=". $max ." min=". $min ." step=". $pas ."><br>";
                break;
            case "type":
                foreach ($type as $types){
                    $verif = 0;

                    foreach ($choix as $choixValue) {
                        if($types == $choixValue){
                            $out[] = "<input type=checkbox name=".$blocName."[choix][".$arg."] value=" . $types . " checked>" . $types . "<br>";
                            $verif = 1;
                            $arg++;
                            break;
                        }
                    }
                    if($verif == 0){
                        $out[] = "<input type=checkbox name=".$blocName."[choix][".$arg."] value=" . $types . ">" . $types . "<br>";
                        $arg++;
                    }

                }
                break;
            default:
                $out[] = "<label for=". $elem.">". $cle ."</label><input name=".$blocName."[".$cle."] id=". $cle ." type='text' value=".$elem." required><br>";
                break;
        }
    }

    return $out;
}
//Rappel: sauveConfig();