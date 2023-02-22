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

$json = file_get_contents($_SERVER['DOCUMENT_ROOT']. "/_modules/warehouse/settings/menuTreeCommon.json");
$str = $_POST["data"];
$data = win(json_decode($json,256));
//echo "<pre>";
//print_r($data);
//echo "</pre>";
$keyList = explode("/", $str);
$n = 0;
$params = (getElement($data, $keyList));
$_GET["type"] = $params["type"];
$_GET["horizontal"] = "1";
$cssFile = "/_modules/warehouse/views/{$params["css"]}/css/style.css";
$scriptFile = "/_modules/warehouse/views/{$params["css"]}/js/script.js";
require_once $_SERVER['DOCUMENT_ROOT']."/_modules/warehouse/php/getForms/{$params["file"]}";
echo "<div style='display: none' id='cssFile'>{$cssFile}</div>";
echo "<div style='display: none' id='scriptFile'>{$scriptFile}</div>";







