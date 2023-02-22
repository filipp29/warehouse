<?php

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //Подключаем библиотеку для работы с БД
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';


error_reporting(E_ALL); //Включаем вывод ошибок
set_time_limit(600); //Устанавливаем максимальное время работы скрипта в секундах
ini_set('display_errors', 1); //Еще один вывод ошибок
ini_set('memory_limit', '512M'); //Устанавливаем ограничение памяти на скрипт (512Мб)




setOrgAll("default");

$type = $_GET["type"];
$horizontal = isset($_GET["horizontal"]) ? $_GET["horizontal"] : "";
$matList = \Subcount::getSubcountList("material", true);
try{
    
    $docView = new \DocumentView($type);
    if ($horizontal){
        $docView->showHorizontal();
    }    
    else{
        $docView->show();
    }
}
catch(\Exception $e){
    $e->getMessage();
}




















