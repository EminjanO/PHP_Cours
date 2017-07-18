<?php
/**
 * Created by PhpStorm.
 * User: eminjan
 * Date: 5/22/17
 * Time: 4:14 PM
 */
$ficherIni = "config.ini";
function chargeConfig($fileName)
{
	$tabIniFile = parse_ini_file($fileName,true);
	return $tabIniFile;     //retournera le tableau de tableau
							// "parsé" par cette fonction de l'API
}
function afficheConfig($config)
{
	//echo "<pre>".Print_r($config,true)."</pre>";
	
	$out = [];
	$out []= "<form id='modifConfig' name='modifConfig' method='post'>";
	foreach ($config as $key => $contentTab)
	{
		$out[] = "<fieldset><legend>".$key."</legend>";
		//$out [] = "<pre>".print_r($contentTab,true)."</pre>";
		//$out [] = gereBloc($key,$contentTab)[0]; // 2.4.6
		$out = array_merge($out, gereBloc($key,$contentTab));
		$out[] = "</fieldset>";
	}
	
	$out[] = "<input type='submit' value='envoie'></form>";
	return implode("\n",$out);
}
//echo "<pre>".print_r($_POST,true) . "</pre>";
function sauveConfig()
{
	if (isset($_POST) && sizeof($_POST) != 0) {
		$tabIniFile = parse_ini_file("config.ini", true);
		echo "<pre>".print_r($tabIniFile,true) . "</pre>";
		//print_r(array_diff_key($tabIniFile,$_POST));
		$file = fopen("config.ini", "w");
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
		
	}
}
sauveConfig();
echo afficheConfig(chargeConfig($ficherIni));

function gereBloc($blocName, $blocContent)
{
	//mémorisation de min et max
	$min = isset($blocContent['min'])?$blocContent['min']:null;
	$max = isset($blocContent['max'])?$blocContent['max']:null;
	$pas = isset($blocContent['pas'])?$blocContent['pas']:1;
	//suppresstion de la liste
	unset($blocContent['min']);
	unset($blocContent['max']);
	unset($blocContent['pas']);
	// la même chose pour le les type et choix
	$type = [];
	$type = isset($blocContent['type'])?$blocContent['type']:array();
	$choix = isset($blocContent['choix'])?$blocContent['choix']:array();
	unset($blocContent['choix']);
	
	$out = [];
	//$out [] = "<pre>".print_r($blocContent,true)."</pre>";
	foreach ($blocContent as $cle => $elem)
	{
		$out [] = "<label for=$blocName"."_$cle>".$cle." : "."</label>";
		$arg = 0;
		switch ($cle)
		{
			case 'taille':
			$out [] ="<input type='number' max=$max min=$min step=$pas
			 id=$blocName"."_$cle name=$blocName"."[".$cle."] title='min=".$min." max=".$max." step=".$pas."'
					value='"."$elem"."' required><br>";
			break;
			
			case "type":
				foreach ($type as $types)
				{
					$verif = 0;
					
					foreach ($choix as $choixValue) {
						if($types == $choixValue){
							$out[] = "<input type=checkbox id=".$blocName."_".$cle."_".$types." name=".$blocName."[choix][".$arg."] value=" . $types . " checked>" . $types;
							$verif = 1;
							$arg++;
							break;
						}
					}
					if($verif == 0){
						$out[] = "<input type=checkbox id=".$blocName."_".$cle."_".$types." name=".$blocName."[choix][".$arg."] value=" . $types . ">" . $types;
						$arg++;
					}
				}
				break;
			default:
				$out [] ="<input type='text' id=$blocName"."_$cle name=$blocName"."[".$cle."]
					value='"."$elem"."' required><br>";
		}
		
	}
	return $out;
}