<?php

error_reporting(E_ALL); //�������� ����� ������
set_time_limit(600); //������������� ������������ ����� ������ ������� � ��������
ini_set('display_errors', 1); //��� ���� ����� ������
ini_set('memory_limit', '512M'); //������������� ����������� ������ �� ������ (512��)
$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //��������� �������� ����� (�����, ������ ���� �������� � ���������� ��������
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //���������� ���������� ��� ������ � ��
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';





/*--------------------------------------------------*/


function utf(
    $str
){
    if (is_array($str)){
        $result = [];
        foreach ($str as $key => $value){
            $result[$key] = utf($value);
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
            $result[$key] = win($value);
        }

        return $result;
    }
    else{
        return iconv("utf-8", "windows-1251", $str);
    }

}



/*--------------------------------------------------*/

function getElement(
        $ar,
        $keyList
){
    global $n;
    if ($n > 5){
        return;
    }
    $n++;
    if (count_u($keyList) == 1){
        return $ar[$keyList[0]];
    }
    else{
        $key = $keyList[0];
        unset($keyList[0]);
        $keyList = array_values($keyList);
        
        return getElement($ar[$key]["list"], $keyList);
    }
}


/*--------------------------------------------------*/

function getLevel(
        $ar,
        $type
){
    if ($type == "subcount"){
        return "1";
    }
    if (key_exists("list", $ar)){
        $max = 0;
        foreach($ar["list"] as $key => $value){
            $level = getLevel($value, $type);
            if (($max < $level)){
                $max = $level;
            }
        }
        return $max;
    }
    else{
        global $accessList;
        return isset($accessList[$type][$ar["type"]]) ? $accessList[$type][$ar["type"]] : "0";
    }
}

/*--------------------------------------------------*/

$accessList["document"] = \DocumentView::getAccessList();
$accessList["report"] = \ReportView::getAccessList();

$profile = $_COOKIE["login"];
$obj = objLoad("/profiles/{$profile}/profile.pro");
$level = $obj["mod_warehouse"];
$json = file_get_contents($_SERVER['DOCUMENT_ROOT']. "/_modules/warehouse/settings/menuTreeCommon.json");
$str = isset($_POST["data"]) ? $_POST["data"] : "";
$data = win(json_decode($json,256));
$keyList = explode("/", $str);
$n = 0;
$root = false;
if (!$str){
    $root = true;
    $params = $data;
}
else{
    $rootType = $keyList[0];
    $params = (getElement($data, $keyList));
    $params = $params["list"];
}
//echo "<pre>";
//print_r($data);
//echo "</pre>";

$view = new \View2("/_modules/warehouse/views/submenuBox/");

$flag = true;

foreach($params as $key => $value){
    if ($root){
        $curLevel = getLevel($value, $key);
    }
    else{
        $curLevel = getLevel($value, $rootType);
    }
    
    
    if ((((int)$curLevel == 0) || ((int)$curLevel < (int)$level))){
        
        continue;
    }
    
    $data = [
        "key" => $key,
        "name" => ($value["name"] != "") ? $value["name"] : "unknown",
    ];
    if ($flag){
        $data["selected"] = "selectedMenBlock";
        $flag = false;
    }
    $view->show("data", $data);
}






