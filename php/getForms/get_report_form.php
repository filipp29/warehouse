<?php
error_reporting(E_ALL); //Включаем вывод ошибок
set_time_limit(600); //Устанавливаем максимальное время работы скрипта в секундах
ini_set('display_errors', 1); //Еще один вывод ошибок
ini_set('memory_limit', '512M'); //Устанавливаем ограничение памяти на скрипт (512Мб)
date_default_timezone_set("Asia/Almaty");
$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //Подключаем библиотеку для работы с БД
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';





setOrgAll("default");

$type = $_GET["type"];
checkAccessLevel(\ReportView::getAccessList()[$type]);
$horizontal = isset($_GET["horizontal"]) ? $_GET["horizontal"] : null;
try{
    if ($horizontal){
        \ReportView::showHorizontal($type);
    }
    else {
        \ReportView::show($type);
    }
}
catch(\Exception $e){
    $e->getMessage();
}
