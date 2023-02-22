<?php
$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //Подключаем библиотеку для работы с БД
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';

error_reporting(E_ALL); //Включаем вывод ошибок
set_time_limit(600); //Устанавливаем максимальное время работы скрипта в секундах
ini_set('display_errors', 1); //Еще один вывод ошибок
ini_set('memory_limit', '512M'); //Устанавливаем ограничение памяти на скрипт (512Мб)



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

/*--------------------------------------------------*/


$profile = $_COOKIE["login"];
$obj = objLoad("/profiles/{$profile}/profile.pro");
$level = $obj["mod_warehouse"];



$json = file_get_contents($_SERVER['DOCUMENT_ROOT']. "/_modules/warehouse/settings/menuTreeCommon.json");
$str = $_POST["data"];
$data = win(json_decode($json,256));


$view = new \View2("/_modules/warehouse/views/submenuBox/");

$flag = true;

foreach($data as $key => $value){
    if ((int)$data["level"] < (int)$level){
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







