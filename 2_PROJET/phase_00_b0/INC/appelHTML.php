<?php
/**
 * Created by PhpStorm.
 * User: eminjan
 * Date: 9/03/17
 * Time: 1:00
 */


switch ($_GET['rq'])
{
    case ( $_GET['rq'] == null ||  !(isset($_GET['rq'])) ):
        echo 'inconnu';
        break;
    case 'index':
        echo "<hr>Requête : index<hr>Potentiellement vous êtes déjà dans la page index<hr>";
        break;
    case 'liste':
        echo "<hr>Requête : liste<hr>La liste de tous les gabarits viendra à point pour celui qui sait attendre<hr>";
        break;
    case 'utiliser':
        echo    '<form name="liste" method="get" action="listeCours.html" onsubmit="return ajaxJSON(this)">
                    <input type="text" name="groupe" placeholder="groupe recherché" value=""/>
                    <input type="submit" value="Envoi" /></form>';
        break;
    case 'licence':
        echo "<hr>Requête : licence<hr>Avons nous la \"licence\" puisque cela n'est plus sur le net ??<hr>";
        break;
    case 'credits':
        echo "<hr>Requête : credits<hr>Les liens \"crédits\" sont cachés sous le mot correspondant dans le pied de page<hr>";
        break;
}


