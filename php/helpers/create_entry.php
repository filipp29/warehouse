<?php

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //Подключаем библиотеку для работы с БД
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/Subcount.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/View2.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/Entry.php';

error_reporting(E_ALL); //Включаем вывод ошибок
set_time_limit(600); //Устанавливаем максимальное время работы скрипта в секундах
ini_set('display_errors', 1); //Еще один вывод ошибок
ini_set('memory_limit', '512M'); //Устанавливаем ограничение памяти на скрипт (512Мб)




$params["src"] = $_GET["src"];
$params["dst"] = $_GET["dst"];
$params["count"] = $_GET["count"];
$params["material"] = $_GET["material"];
$params["timeStamp"] = $_GET["timeStamp"];
$params["docId"] = $_GET["docId"];
$params["price"] = $_GET["price"];
$params["account"] = "1310";
$org = $_GET["org"];
if (!$org){
    $org = "default";
}
setOrgAll($org);
if (!$params["timeStamp"]){
    $params["timeStamp"] = time();
   
}
try{
//    $result = \Entry::create($account, $src, $dst, $material, $docId, $timeStamp);
    $result = \Entry::create($params);
    echo "Проводка {$result} добавлена";
}
catch(\Exception $e){
    echo $e->getMessage();
}















