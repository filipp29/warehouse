<?php

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //Подключаем библиотеку для работы с БД
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';


error_reporting(E_ALL); //Включаем вывод ошибок
set_time_limit(600); //Устанавливаем максимальное время работы скрипта в секундах
ini_set('display_errors', 1); //Еще один вывод ошибок
ini_set('memory_limit', '512M'); //Устанавливаем ограничение памяти на скрипт (512Мб)


function showSelect(
        $id,
        $name,
        $ar,
        $view
){
    $data = [];
    $data["id"] = $id;
    $data["name"] = $name;
    $view->show("select.header", $data);
    foreach($ar as $v){
        $data = [
            "value" => $v["value"],
            "name" => $v["name"]
        ];
        $view->show("select.data",$data);
    }
    $view->show("select.footer");
}




/*--------------------------------------------------*/
if (!$org){
    $org = "default";
}
setOrgAll($org);


$view = new \View2("/_modules/ware/views/getAccountBalance/");
$wareList = \Subcount::getSubcountList("warehouse", true);
$matList = \Subcount::getSubcountList("material", true);
$ar = [];
$view->show("header");
foreach($wareList as $k => $v){
    $ar[] = [
        "name" => $v["name"],
        "value" => $v["id"]
    ];
}
showSelect("subcount1", "Склад", $ar, $view);

$ar = [];
foreach($matList as $k => $v){
    $ar[] = [
        "name" => $v["name"],
        "value" => $v["id"]
    ];
}
showSelect("subcount2", "Материал", $ar, $view);

$view->show("footer");

























