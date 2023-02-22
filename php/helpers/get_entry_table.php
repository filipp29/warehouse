<?php

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //Подключаем библиотеку для работы с БД
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';


error_reporting(E_ALL); //Включаем вывод ошибок
set_time_limit(600); //Устанавливаем максимальное время работы скрипта в секундах
ini_set('display_errors', 1); //Еще один вывод ошибок
ini_set('memory_limit', '512M'); //Устанавливаем ограничение памяти на скрипт (512Мб)

$str = $_GET["data"];
$dec = new \Decoder();
$typeName = [
    "crt" => "Дебет",
    "dbt" => "Кредит"
];
$data = $dec->strToArray($str);
$timeStamp1 = $data["timeStamp1"];
$timeStamp2 = $data["timeStamp2"];
$subcount1 = $data["subcount1"];
$subcount2 = $data["subcount2"];
$result = \Entry::getMany($subcount1, $subcount2, $timeStamp1, $timeStamp2);


$view = new \View2("/_modules/warehouse/views/ReportView/");

$view->show("header");
$view->show("table.header_entry");
foreach($result as $subcount => $typeList){
    $sub = new \Subcount($subcount);
    
    $data = [
        "style" => "background-color: #e3d8e1"
    ];
    $view->show("table.row.header",$data);
    $data = [
        "text" => $sub->getName(),
        "colspan" => 3
    ];
    $view->show("table.cell.data", $data);
    $view->show("table.row.footer");
    foreach($typeList as $type => $entryList){
        $data = [
        "style" => "background-color: #c9dbc8"
        ];
        $view->show("table.row.header",$data);
        $data = [
            "text" => $typeName[$type],
            "colspan" => 3
        ];
        $view->show("table.cell.data", $data);
        $view->show("table.row.footer");
        foreach($entryList as $entry){
            $data = [
                "style" => "background-color: #c8cedb",
                "onclick" => "getDocumentForm('{$entry["docId"]}')"
            ];
            $view->show("table.row.header",$data);
            $view->show("table.cell.data");
            $data = [
                "text" => date("d.m.Y H:i:s", explode(".",$entry["id"])[0])
            ];
            $view->show("table.cell.data",$data);
            $data = [
                "text" => $entry["count"]
            ];
            $view->show("table.cell.data",$data);
            $view->show("table.row.footer");
        }
    }
}

$view->show("table.footer");
$view->show("footer");



















