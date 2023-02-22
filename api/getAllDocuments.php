<?php

    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    ini_set('memory_limit', '512M'); 
    set_time_limit(600);
    $_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net';
    require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php');
    require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libSwitches.php');
    require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libProfiles.php');
    require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libMsg.php');
    require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libCity.php');

//    require_once $_SERVER['DOCUMENT_ROOT']."/_modules/warehouse/php/classes/TreeExplorer.php";
//    require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';

    
    
    /*--------------------------------------------------*/


function utf(
    $str
){
    if (is_array($str)){
        $result = [];
        foreach ($str as $key => $value){
            $k = iconv("windows-1251", "utf-8", $key);
            $result[$k] = utf($value);
        }
        return $result;
    }
    else{
        return iconv("windows-1251", "utf-8", $str);
    }
}

/*--------------------------------------------------*/



function win(
        $str
){
    if (is_array($str)){
        $result = [];
        foreach ($str as $key => $value){
            $k = iconv("utf-8", "windows-1251", $key);
            $result[$k] = win($value);
        }

        return $result;
    }
    else{
        return iconv("utf-8", "windows-1251", $str);
    }

}



/*--------------------------------------------------*/


$path = "/ware/uplink/docList/all/20220620/";

$br = array_keys(objLoadBranch($path, false, true));
$result = [];
$test = [];
foreach($br as $value){
    
    $header = objload("{$path}{$value}/header");
    $bufTable = objLoad("{$path}{$value}/table");
    unset($header["#e"],$bufTable["#e"],$header["account"]);
    $header["id"] = $value;
    $table = [];
    foreach($bufTable as $key => $value){
        $buf = explode("_", $key);
        $table[(int)$buf[0]][$buf[1]] = $value;
    }
    
    unset($header["#e"],$table["#e"],$header["account"]);
    $result[] = [
        "header" => $header,
        "table" => $table
    ];
    
}
echo json_encode(utf($result), 256);











?>