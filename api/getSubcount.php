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
    
function getMaterial(){    
    
    $data = [];
    $path = "/ware/uplink/subcount/material/";
    $br = array_keys(objLoadBranch($path));
    foreach($br as $value){
        $obj = objLoad($path.$value."/info");
        $obj["id"] = $value;
        unset($obj["#e"],$obj["type"]);
        $data[] = $obj;
    }
    echo json_encode(utf($data), 256);
    
} 


/*--------------------------------------------------*/

function getWarehouse(){
    $data = [];
    $path = "/ware/uplink/subcount/warehouse/";
    $br = array_keys(objLoadBranch($path));
    foreach($br as $value){
        $obj = objLoad($path.$value."/info");
        $obj["id"] = $value;
        unset($obj["#e"],$obj["type"],$obj["city"],$obj["inCharge"]);
        $data[] = $obj;
    }
    echo json_encode(utf($data), 256);
    
}

/*--------------------------------------------------*/

function getContractor(){
    $data = [];
    $path = "/ware/uplink/subcount/contractor/";
    $br = array_keys(objLoadBranch($path));
    foreach($br as $value){
        $obj = objLoad($path.$value."/info");
        $obj["id"] = $value;
        unset($obj["#e"],$obj["type"],$obj["city"],$obj["address"]);
        $data[] = $obj;
    }
    echo json_encode(utf($data), 256);
}


/*--------------------------------------------------*/

function getWorker(){
    $data = [];
    $path = "/ware/uplink/subcount/profile/";
    $br = array_keys(objLoadBranch($path));
    foreach($br as $value){
        $obj = objLoad($path.$value."/info");
        $obj["id"] = $value;
        unset($obj["#e"],$obj["type"]);
        $data[] = $obj;
    }
    echo json_encode(utf($data), 256);
}

/*--------------------------------------------------*/


$type = $_GET["type"];

switch ($type):
    case "material":
        getMaterial();
        break;
    case "warehouse":
        getWarehouse();
        break;
    case "contractor":
        getContractor();
        break;
    case "worker":
        getWorker();
        break;
    
endswitch;
    
    
    
    
   
    
    
    
    
    
    
    
    
    
    ?>