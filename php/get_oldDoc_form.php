<?php

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //Подключаем библиотеку для работы с БД
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libProfiles.php');
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';


error_reporting(E_ALL); //Включаем вывод ошибок
set_time_limit(600); //Устанавливаем максимальное время работы скрипта в секундах
ini_set('display_errors', 1); //Еще один вывод ошибок
ini_set('memory_limit', '512M'); //Устанавливаем ограничение памяти на скрипт (512Мб)




setOrgAll("default");

$id = $_GET["id"];
echo $id;
$docParams = \Document::getDocParams($id);
echo "<pre>";
print_r($docParams);
echo "</pre>";

try{
    $docView = new \DocumentView($type);
    $result = \Document::getDocParams($id);
    $header = $result["header"];
    $subcount = new \Subcount($header["src"]);
    $header["srcName"] = $subcount->getName();
    $subcount = new \Subcount($header["dst"]);
    $header["dstName"] = $subcount->getName();
    
    $header["authorName"] = profileGetUsername($header["author"]);
    $buf = $result["table"];
    $table = [];
    $i = 0;
    foreach($buf as $k => $v){
        $subcount = new \Subcount($v["id"]);
        $table[$i][0] = $subcount->getName();
        $table[$i][1] = $v["price"];
        $table[$i][2] = $v["count"];
        $table[$i][3] = $subcount->getParams("units");
        $i++;
    }
    $docView->setParams($id, $header, $table);
    $docView->show();
}
catch(\Exception $e){
    $e->getMessage();
}




















