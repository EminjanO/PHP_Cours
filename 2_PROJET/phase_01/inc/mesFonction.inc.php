<?php
    define ('__SCRIPT_NAME__', $_SERVER["SCRIPT_NAME"]);
    define ('__SCRIPT_DNS__', $_SERVER["SERVER_NAME"]);
    define ('__SCRIPT_PATH__', $_SERVER["DOCUMENT_ROOT"]);
    define ('__SCRIPT_PROTOCOL__', $_SERVER["SERVER_PROTOCOL"]);

    static $fileExtension = null;
    static $slice = null;
    static $scriptInfos = null;
    static $pathArray = null;
    static $shortName = null;
    static $scriptLongPath = null;
    static $scriptFullPath = null;

    function scriptInfos($param) {
        $fileExtension = explode(".", __SCRIPT_NAME__);
        $slice = array_slice($fileExtension, 0, -1);
        $pathArray = explode("/", __SCRIPT_NAME__);
        $shortName = implode("", $slice);
        $scriptLongPath = __SCRIPT_NAME__;
        $scriptFullPath = __SCRIPT_PROTOCOL__ . " " . __SCRIPT_DNS__ . " " . __SCRIPT_NAME__;
        $scriptInfos = array(
            "scriptName" => __SCRIPT_NAME__,
            "scriptExtension" => $fileExtension,
            "scriptShortName" => $shortName,
            "scriptDirs" => $pathArray,
            "scriptLongPath" => $scriptFullPath,
            "scriptFullPath" => $scriptFullPath,
        );
        switch(strtolower($param)) {
            case strtolower("Name"):
                return __SCRIPT_NAME__;
                break;
            case strtolower("Dns"):
                return __SCRIPT_DNS__;
                break;
            case strtolower("Path"):
                return __SCRIPT_PATH__;
                break;
            case strtolower("Protocol"):
                return __SCRIPT_PROTOCOL__;
                break;
            case strtolower("Extension"):
                return '.'.end($fileExtension);
                break;
            case strtolower("ShortName"):
                return $shortName;
                break;
            case strtolower("Dirs"):
                return $pathArray;
                break;
            case strtolower("LongPath"):
                return $scriptLongPath;
                break;
            case strtolower("FullPath"):
                return $scriptFullPath;
                break;
            default:
                return $scriptInfos;
        }
    }

    function creeTableau($liste, $titre='tableau', $index) {
        $keys = array_keys($liste);
        $listeTitre = array_keys($liste[$keys[0]]);

        $table = '<table>';
        $table .= '<caption>'.$titre.'</caption>';
        $table .= '<thead>';
        $table .= '<tr>';
        if($index){
            $table .= '<th>Index</th>';
        }
        for($i=0; $i < count($listeTitre); $i++){
            $table .= '<th>'.ucwords($listeTitre[$i]).'</th>';
        }
        $table .= '</tr>';
        $table .= '</thead>';
        $table .= '<tbody>';
        for($i = 0; $i < count($keys); $i++) {
            $table .= '<tr>';
            if ($index) {
                $table .= '<td>' . $keys[$i] . '</td>';
            }
            for ($j = 0; $j < count($listeTitre); $j++){
                $table .= '<td>' . $liste[$keys[$i]][$listeTitre[$j]] . '</td>';
            }
            $table .= '</tr>';
        }
        $table .= '</tbody>';
        $table .= '</table>';
        return $table;
    }

    function monPrint_r($liste) {
        $myPrint = '<pre>';
        $myPrint .= print_r($liste, true);
        $myPrint .= '</pre>';
        echo $myPrint;
    }

    function getServer() {
        if ($_SERVER['REMOTE_ADDR']=='127.0.0.1') {
            //echo('local');
            return '193.190.65.94';
        }
        else {
            //echo ('server');
            return 'localhost';
        }
    }