<?php
/**
 * Created by PhpStorm.
 * User: eminjan
 * Date: 8/6/17
 * Time: 3:10 PM
 */
if (  !(isset($_GET['rq'])) ) $_GET['rq'] = 'rq_nonExiste';
else if (empty($_GET['rq']) ) $_GET['rq'] = 'rq_empty';

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
	case 'licence':
		echo "<hr>Requête : licence<hr>Avons nous la \"licence\" puisque cela n'est plus sur le net ??<hr>";
		break;
	case 'credits':
		echo "<hr>Requête : credits<hr>Les liens \"crédits\" sont cachés sous le mot correspondant dans le pied de page<hr>";
		break;
}