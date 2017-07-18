<?php
//require_once('mesFonction.inc.php');
//require_once("dbConnect.inc.php");

function dbConnect() {
    //require_once("./dbConnect.inc.php");
    //require_once("lib.config.inc.php");
    //$config = chargeConfig("config.inc.php");
    try {
        $dbName = $GLOBALS['config']['DB']['dbname'];
        //$dbName = $__INFOS__['dbName'];
        $dbh = new PDO('mysql:host=' . host() . ';dbname=' . $dbName, $GLOBALS['config']['DB']['user'],  $GLOBALS['config']['DB']['pswd']);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbh;
    } catch (PDOException $e) {
        return ["PDOException"=>$e->getMessage()];
    }
}

function host() {
    $config = chargeConfig("config.inc.php");
    if ($_SERVER['REMOTE_ADDR']=='127.0.0.1') {
        //echo('local');
        return $GLOBALS['config']['DB']['host'];
    }
    else {
        //echo ('server');
        return 'localhost';
    }
}

function userInfo() {
    $sqlAllGroups = "call he_userConnect(?,?)";
    $user = $_POST['flg_pseudo'];
    $passwd = $_POST['flg_cle'];
    try {
        $dbh = dbConnect();
        if(is_array($dbh)) return $dbh;
        $donneeUser = $dbh->prepare($sqlAllGroups);
        $donneeUser->execute(array($user, $passwd));
        $tab = $donneeUser->fetchAll(PDO::FETCH_ASSOC);
        $donneeUser->closeCursor();
        $dbh = null;
        return $tab;
    }
    catch (PDOException $e) {
        return ["PDOException"=>$e->getMessage()];
        /*$error1 = array("error"=>$e->getMessage());
        $error = array("error"=>$error1);
        echo(json_encode($error, JSON_FORCE_OBJECT));*/
        die();
    }
}

function listeCours() {
    if (isset($_GET['groupe']) && $_GET['groupe'] != NULL) {
        $groupe = $_GET['groupe'];
        $sqlGroups = "call mc_coursesGroup(?)";

        $sqlParent = "call mc_parentGroup(?)";

        try {
            $dbh = dbConnect();
            if(is_array($dbh)) return $dbh;

            $donneeParent = $dbh->prepare($sqlParent);
            $donneeParent->execute(array($groupe));
            $tab = $donneeParent->fetchAll(PDO::FETCH_ASSOC);

            if ($tab == NULL || !isset($tab) || $tab=='') {
                return ['contenu'=>'Mauvais Groupe'];
                //return(['creeTableau'=>['destination'=>'contenu', 'tableau'=>'{"Résultat":{"groupe":"Mauvais Groupe"}}']]);
            }
            $donneeParent->closeCursor();
            $dbh = null;
        } catch (PDOException $e) {
            return ["PDOException"=>$e->getMessage()];
            /*$error1 = array("error" => $e->getMessage());
            $error = array("error" => $error1);
            echo(json_encode($error, JSON_FORCE_OBJECT));*/
            die();
        }

        try {
            $dbh = dbConnect();
            if(is_array($dbh)) return $dbh;

            $donneeCourses = $dbh->prepare($sqlGroups);
            $donneeCourses->execute(array($groupe));
            $fetch = $donneeCourses->fetchAll(PDO::FETCH_ASSOC);
            if ($tab == NULL || !isset($tab)) {

            } else {
                if ($fetch == null) {
                    return ['contenu'=>'Aucun cours n\'est rattaché à ce groupe !'];
                    //return(['creeTableau'=>['destination'=>'contenu', 'tableau'=>'{"Résultat":{"cours":"Aucun cours n\'est rattaché à ce groupe !"}}']]);
                } else {
                    $destination = isset($_GET['dest']) ? $_GET['dest'] : 'contenu';
                    $tableau = $fetch;
                    $toSend = ['creeTableau' => ['destination' => $destination, 'tableau' => $tableau]];
                    //echo json_encode($toSend);
                    echo(json_encode(($toSend)));
                }
            }
            $donneeCourses->closeCursor();
            $dbh = null;
        } catch (PDOException $e) {
            return ["PDOException"=>$e->getMessage()];
            /*$error1 = array("error" => $e->getMessage());
            $error = array("error" => $error1);
            echo(json_encode($error, JSON_FORCE_OBJECT));*/
            die();
        }
    } else {
        return ['contenu'=>'Pas de groupe'];
        //echo('{"0":{"erreur":"Pas de groupe"}}');
    }
}

function getArray($rq) {
    if ($rq == 'tableau') {
        return (['creeTableau'=>['destination'=>'contenu', 'tableau'=>'{"bo124":{"auteur":"B.Y.","titre":"Connectique","prix":5.2},"bo254":{"auteur":"L.Ch.","titre":"Programmation C","prix":4.75},
    "bo334":{"auteur":"L.Ch.","titre":"JavaScript","prix":6.4},"bo250":{"auteur":"D.A.","titre":"Math\u00e9matiques","prix":6.1},
    "bo604":{"auteur":"V.V.","titre":"Objets","prix":4.95},"bo025":{"auteur":"D.M.","titre":"Electricit\u00e9","prix":7.15},
    "bo099":{"auteur":"D.M.","titre":"Ph\u00e9nom\u00e8nes P\u00e9riodiques","prix":6.95},
    "bo023":{"auteur":"V.MN.",
    "titre":"Programmation Java","prix":5.75},"bo100":{"auteur":"D.Y.","titre":"Bases de Donn\u00e9es","prix":6.35},
    "bo147":{"auteur":"V.V.","titre":"Traitement de Signal","prix":4.85},"bo004":{"auteur":"B.W.","titre":"S\u00e9curit\u00e9","prix":5.55},
    "bo074":{"auteur":"B.Y.","titre":"Electronique digitale","prix":4.35},"bo257":{"auteur":"D.Y.","titre":"Programmation Multimedia","prix":6}}']]);
    }
    else if ($rq == 'listeCoursSem03') {
        if (isset($_POST['groupe']) && $_POST['groupe']!=NULL) {
            $groupe = $_POST['groupe'];
            //echo $groupe;
            $sqlGroups = "call mc_coursesGroup(?)";
            $sqlParent = "call mc_parentGroup(?)";

            try {
                $dbh = dbConnect();
                if(is_array($dbh)) return $dbh;

                $donneeParent = $dbh->prepare($sqlParent);
                $donneeParent->execute(array($groupe));
                //print_r($donneeParent);
                $tab = $donneeParent->fetchAll(PDO::FETCH_ASSOC);
                //print_r($tab);


                if($tab == NULL || !isset($tab)) {
                    return ['contenu'=>'Mauvais Groupe'];
                    //return(['creeTableau'=>['destination'=>'contenu', 'tableau'=>'{"erreur":{"groupe":"Mauvais Groupe"}}']]);
                    //echo('{"0":{"erreur":"Mauvais Groupe"}}');
                }
                $donneeParent -> closeCursor();
                $dbh = null;
            } catch (PDOException $e) {
                return ["PDOException"=>$e->getMessage()];
                die();
            }

            try {
                $dbh = dbConnect();
                if(is_array($dbh)) return $dbh;

                $donneeCourses = $dbh->prepare($sqlGroups);
                $donneeCourses->execute(array($groupe));
                $fetch = ['creeTableau'=>['destination'=>'contenu', 'tableau'=>$donneeCourses->fetchAll(PDO::FETCH_ASSOC)]];
                //$fetch = $donneeCourses->fetchAll(PDO::FETCH_ASSOC);
                if($tab == NULL || !isset($tab)) {

                }
                else {
                    if ($fetch == null) {
                        return ['contenu'=>'Aucun cours n\'est rattaché à ce groupe !'];
                        //return(['creeTableau'=>['destination'=>'contenu', 'tableau'=>'{"Résultat":{"cours":"Aucun cours n\'est rattaché à ce groupe !"}}']]);
                        //echo('{"0":{"Résultat":"Aucun cours n\'est rattaché à ce groupe !"}}');
                    }
                    else {
                        return (json_encode(($fetch), JSON_FORCE_OBJECT));
                    }
                }
                $donneeCourses -> closeCursor();
                $dbh = null;
            } catch (PDOException $e) {
                return ["PDOException"=>$e->getMessage()];
                /*$error1 = array("error"=>$e->getMessage());
                $error = array("error"=>$error1);
                echo(json_encode($error, JSON_FORCE_OBJECT));*/
                //echo('{"0":{"erreur":' . '$e->getMessage()' . '}}');
                //echo('{"0":{"erreur":$e->getMessage()}}');
                //echo ("Error : " . $e->getMessage() . "<br/>");
                die();
            }
        }
        else {
            return ['contenu'=>'Pas de groupe'];
            //return(['creeTableau'=>['destination'=>'contenu', 'tableau'=>'{"erreur":{"groupe":"Pas de groupe"}}']]);
        }
    }
    else if ($rq == 'tpSem04') {
        $sqlAllGroups = "call mc_allGroups()";
        try {
            $dbh = dbConnect();
            if(is_array($dbh)) return $dbh;

            $donneeAllGroups = $dbh->prepare($sqlAllGroups);
            $donneeAllGroups->execute();
            $tab = $donneeAllGroups->fetchAll(PDO::FETCH_ASSOC);
            $tabJson = json_encode($tab, JSON_FORCE_OBJECT);
            return $tabJson;
        }
        catch (PDOException $e) {
            return ["PDOException"=>$e->getMessage()];
            /*$error1 = array("error"=>$e->getMessage());
            $error = array("error"=>$error1);
            echo(json_encode($error, JSON_FORCE_OBJECT));*/
            die();
        }
    }
}