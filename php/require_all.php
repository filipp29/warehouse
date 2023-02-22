<?php

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //Подключаем библиотеку для работы с БД
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/Entry.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/Subcount.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/Document.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/Decoder.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/Reports.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/Request.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/TreeExplorer.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/MinBalanceTable.php';
if (($_COOKIE["login"] != "1")){
    require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/views/DocumentView.php';
}
else{
    require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/views/DocumentViewTest.php';
}
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/views/ReportView.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/views/JournalView.php';
date_default_timezone_set("Asia/Almaty");

function setOrgAll(
        $org
){
    $org = (isset($_COOKIE["organization"])) ? $_COOKIE["organization"] : "";
    if ($org == ""){
        echo "Не выбрана организация!";
        exit();
    }
    \Entry::setOrg($org);
    \Document::setOrg($org);
    \Subcount::setOrg($org);
    \Reports::setOrg($org);
    \MinBalanceTable::setOrg($org);
    \TreeExplorer::setOrg($org);
    \Request::setOrg($org);
}
/*--------------------------------------------------*/
function getAccessLevel(){
    $login = $_COOKIE["login"];
    $profile = objLoad("/profiles/{$login}/profile.pro");
    return $profile["mod_warehouse"];
}
/*--------------------------------------------------*/
function checkAccessLevel(
        $level
){
    $profile = isset($_COOKIE["login"]) ? $_COOKIE["login"] : "";
    $obj = objLoad("/profiles/{$profile}/profile.pro");
    $curLevel = (int)isset($obj["mod_warehouse"]) ? $obj["mod_warehouse"] : 0;
    if (($curLevel == 0) || ($curLevel > $level)){
        echo "<h1 style='width: 100%; text-align: center;'>Отказано в доступе</h1>";
        exit();
    }
}
/*--------------------------------------------------*/

function getSubordinateList(
        $profile
){
    $result = [];
    $list = \Subcount::getSubcountList("profile", false);
    foreach($list as $key => $value){
        if ($value["supervisor"] == $profile){
            $result[] = $value["login"];
        }
    }
    return $result;
}

function getParamStringFromArray(
        $params
){
    $result = "";
    foreach($params as $key => $value){
        $result .= " {$key}='{$value}'";
    }
    return $result;
}

/*--------------------------------------------------*/

function count_u(
        $ar
){
    if (!is_array($ar)){
        return 0;
    }
    else{
        return count($ar);
    }
}

/*--------------------------------------------------*/



setOrgAll("");

