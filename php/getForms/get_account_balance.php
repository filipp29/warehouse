<?php

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //Подключаем библиотеку для работы с БД
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';





$subcount1 = $_GET["subcount1"];
$subcount2 = $_GET["subcount2"];
$timeStamp = $_GET["timeStamp"];
$date = date("Ymd", $timeStamp);
$path = "/1310/";
if ($subcount1){
    $path .= "bySubcount1/".$subcount1. "/";
}
if ($subcount2){
    if (!$subcount1){
        $path .= "bySubcount2/";
    }
    $path .= $subcount2. "/";
}

$dbt = \Reports::getBalance($path, "dbt", $date);
$crt = \Reports::getBalance($path, "crt", $date);

echo "Кредит: {$crt}; Дебет: {$dbt}";












