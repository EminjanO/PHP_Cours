<?php
/**
 * Created by PhpStorm.
 * User: eminjan
 * Date: 8/6/17
 * Time: 3:10 PM
 */
include "dbConnect.inc.php";
include "mesFonctions.inc.php";

if (  !(isset($_GET['rq'])) ) $_GET['rq'] = 'rq_nonExiste';
else if (empty($_GET['rq']) ) $_GET['rq'] = 'rq_empty';

if(empty($_GET['rq'])) return [['résultat' => 'nomGroup vide !']];
try
{
	$dbName = 'minicampus';
	global $__INFOS__;
	$dbh = new PDO ( "mysql:host = ".getServer().';dbName = '.$dbName,
	                 $__INFOS__['user'],$__INFOS__['pswd']);
	
	$sql = "call 1617he201365.mc_allGroups()";
	
	$sth = $dbh->query($sql);
	
	$infos = $sth->fetchAll(PDO::FETCH_ASSOC);
	
	$jsonTab = json_encode($infos);
	$dbh = null;
}
catch (PDOException $e)
{
	
	return [["PDOException ! " => $e->getMessage()]]; // problème est là !!!
}

switch ($_GET['rq'])
{
	case 'index':
		echo "<hr>Requête : index<hr>Potentiellement vous êtes déjà dans la page index<hr>";
		break;
	case 'liste':
		echo "<hr>Requête : liste<hr>La liste de tous les gabarits viendra à point pour celui qui sait attendre<hr>";
		break;
	case 'utiliser':
		echo    '<hr>Requête utiliser<hr>
				<form name="listeCours" method="get" action="listeCours.html" onsubmit="return ajaxJSON(this)">
                    <input type="text" name="groupe" placeholder="groupe recherché" value=""/>
                    <input type="submit" name="submit" value="Envoi" /></form>
                   <hr>';
		break;
	case 'tpSem04':
		echo '<form method=get name=tpSem04 onsubmit=false>
                    <fieldset id="fieldsetA">
	                    <legend>Groupe recherché</legend>
		                    <div class="form">
		                        <input name=groupe type="text" placeholder="nom du groupe recherché" oninput="filtre_v2(this);"><br>
		                        <label title="début" for="debut"><<<input id=debut type=radio name="posFiltre" value="debut" onchange="filtre_v2(this);"><label title="milieu" for="milieu">>
		                        <input id=milieu type=radio name="posFiltre" value="milieu" checked onchange="filtre_v2(this);"><label title="milieu" for="milieu"><
		                        <input id=fin type=radio name="posFiltre" value="fin" onchange="filtre_v2(this);"><label title="fin" for="fin">>>
		                    </div>
                	</fieldset>
                	<fieldset id="fieldsetB">
                    	<legend>Suggestion <span id="nb"></span></legend>
                    	<div id=selectBlock class="form">
                        	<select id=selectGroup name="select" form="tpSem04" size=0 title="choisissez le groupe à afficher" data-url="listeCours.html" data-dest="listeCoursTable" data-groupe="">
                        	</select>
                    	</div>
                    	<div id="msg">
                        	Pas de suggestion
                    	</div>
                	</fieldset>
                	<fieldset id="fieldsetC">
                    	<legend>Liste des cours</legend>
                    	<div class="form">
                        	<p id="listeCoursMsg">
                            	Pas de groupe sélectionné
                        	</p>
	                        <div id="listeCoursTable">
	                        </div>
                    	</div>
                	</fieldset>
                </form>
                <div id="visu">
                </div>
                 <script id=monScript title=listeGroup>'. $jsonTab.'</script>';
		break;
	case 'credits':
		echo "<hr>Requête : credits<hr>Les liens \"crédits\" sont cachés sous le mot correspondant dans le pied de page<hr>";
		break;
}