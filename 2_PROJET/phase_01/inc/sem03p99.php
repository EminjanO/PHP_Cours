<form action="" method="get">
    Groupe : <input name="groupe" id="inputGroupe" type="text" placeholder="groupe recherché" value="<?php echo (isset($_GET['groupe']))?$_GET['groupe']:'';?>"><br>
    <input type="submit" id="envoi" value="Envoi">
</form>

<?php
//include ('dbConnect.inc.php');
//include ('mesFonction.inc.php');

//$groupe = $_GET['groupe'];
//$groupe = !empty($_GET['groupe']) && is_string($_GET['groupe']) ? $_GET['groupe'] : '1TL2';

/*$groupe = '2TL1'; // default
if (isset($_GET['groupe']) ) {
    $groupe = $_GET['groupe'];
}*/

if (isset($_GET['groupe']) && $_GET['groupe']!=NULL) {
    $groupe = $_GET['groupe'];
    //echo $groupe;
    $sqlGroups = "call mc_coursesGroup(?)";

    $sqlParent = "call mc_parentGroup(?)";
    $dbName = '1617he201365';

    try {
        $dbh = new PDO('mysql:host=' . getServer() . ';dbname=' . $dbName, 'OBULKASIM', 'Eminjan62bW');
        $donneeParent = $dbh->prepare($sqlParent);
        $donneeParent->execute(array($groupe));
        //print_r($donneeParent);
        $tab = $donneeParent->fetchAll(PDO::FETCH_ASSOC);
        //print_r($tab);


        if($tab == NULL || !isset($tab)) {
            echo("Mauvais Groupe");
        }
        else {
            echo "Groupe : " . $tab[0]['enfant'] . "<br>";
            echo "Nom du parent : " . $tab[0]['parent'] . "<br>";
        }
        $donneeParent -> closeCursor();
        $dbh = null;
    } catch (PDOException $e) {
        echo ("Error : " . $e->getMessage());
        die();
    }

    try {
        $dbh = new PDO('mysql:host=' . getServer() . ';dbname=' . $dbName, 'OBULKASIM', 'Eminjan62bW');
        $donneeCourses = $dbh->prepare($sqlGroups);
        $donneeCourses->execute(array($groupe));
        $fetch = $donneeCourses->fetchAll(PDO::FETCH_ASSOC);
        if($tab == NULL || !isset($tab)) {

        }
        else {
            if ($fetch == null) {
                echo ("Aucun cours n'est rattaché à ce groupe !");
            }
            //print_r (json_encode(($donneeCourses->fetchAll(PDO::FETCH_ASSOC)), JSON_FORCE_OBJECT));
            else {
                echo(creeTableau($fetch, 'Liste des cours', true));
            }
        }
        $donneeCourses -> closeCursor();
        $dbh = null;
    } catch (PDOException $e) {
        echo ("Error : " . $e->getMessage());
        die();
    }
}
else {
    echo("Pas de groupe");
}