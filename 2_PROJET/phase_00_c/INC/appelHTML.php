<?php
include "dbConnect.inc.php";
include "mesFonctions.inc.php";
/**
 * Created by PhpStorm.
 * User: eminjan
 * Date: 9/03/17
 * Time: 1:00
 */
if (  !(isset($_GET['rq'])) ) $_GET['rq'] = 'rq_nonExiste';
else if (empty($_GET['rq']) ) $_GET['rq'] = 'rq_empty';


$dbName = 'minicampus';

$groupe = (isset($_GET['groupe'])) ? ($_GET['groupe']) : false;

$dbh = new PDO ( "mysql:host = ".getServer().';dbName = '.$dbName,
    $__INFOS__['user'],$__INFOS__['pswd']);


    $sql = "call 1617he201365.mc_allGroups()";

    $sth = $dbh->query($sql);

    $infos = $sth->fetchAll(PDO::FETCH_ASSOC);

    $jsonTab = json_encode($infos);


switch ($_GET['rq'])
{

    case 'index':
        echo "<hr>Requête : index<hr>Potentiellement vous êtes déjà dans la page index<hr>";
        break;
    case 'liste':
        echo "<hr>Requête : liste<hr>La liste de tous les gabarits viendra à point pour celui qui sait attendre<hr>";
        break;
    case 'utiliser':
        echo    '<form name="liste" method="get" action="listeCours.html" onsubmit="return newAjaxJSON(this)">
                    <input type="text" name="groupe" placeholder="groupe recherché" value=""/>
                    <input type="submit" value="Envoi" />
                 </form>';
        break;
    case 'tpSem04':
        echo    '<form name="searchFormul" onsubmit="return false">
				<fieldset id="a">
                    <legend>Groupe recherché</legend>
                    
                        <input type="text" name="zoneSearch" title="nom de la groupe" placeholder="nom du groupe recherché" 
                        	oninput="filtre_v2(this)" id="zSearch" value=""/> <br>
                        <label for="begin"><<</label>
                        <input onchange="filtre_v2(this.form.zSearch)" type="radio" name="part" title="début(Begin)" 
                        	id="DEVANT" value="B"> 
                        	
                        >
                        <input onchange="filtre_v2(this.form.zSearch)" type="radio" name="part" title="au milieu(middle)" 
                        	id="DANS" value="I" checked>
                        <
                        
                        <input onchange="filtre_v2(this.form.zSearch)" type="radio" name="part" title="fin(after)" 
                        	id="DERRIERE" value="E"> 
                        <label for="after">>></label>
                     
                 </fieldset>
                 
                 <fieldset id="b">
                     <legend id="bLegend">Suggestion</legend>
                     <span id="pDSuggestion">pas de suggestion</span>
                     
                        <span id="blocOption">
                            <select id="sem04Select" onchange="monChoix(this)" data-url="listeCours.html" data-dest="affiche" 
                        	    size="10">
                                <option></option>
                        </select>
                    </span>
                     
                                      </fieldset>
                 
                 <fieldset id="c">
                    
                    <legend>Liste des cours</legend>
                     
                         <p id="identifiandPhp">Pas de groupe séléctionné</p>
                         <div id="tble"></div>
                    
                 </fieldset>
                 </form>
                 <div id="visu"></div>
                 
                 <script id="monScript" title="listeGroupes">';
                    echo $jsonTab;
                 echo '</script>';

        break;
    case 'credits':
        echo "<hr>Requête : credits<hr>Les liens \"crédits\" sont cachés sous le mot correspondant dans le pied de page<hr>";
        break;
    default: echo 'requête ('.$_GET['rq'].') inconnue';
}


