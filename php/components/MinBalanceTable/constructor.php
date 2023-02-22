<?php

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //Подключаем библиотеку для работы с БД
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
require_once $_SERVER['DOCUMENT_ROOT']."/_modules/warehouse/php/components/MinBalanceTable/php/Viewer.php";

error_reporting(E_ALL); //Включаем вывод ошибок
set_time_limit(600); //Устанавливаем максимальное время работы скрипта в секундах
ini_set('display_errors', 1); //Еще один вывод ошибок
ini_set('memory_limit', '512M'); //Устанавливаем ограничение памяти на скрипт (512Мб)

$model = new \MinBalanceTable();
$view = new \Viewer("/_modules/warehouse/php/components/MinBalanceTable/views");

$action = $_GET["action"];

if ($action == "add"){
    $subcount1 = $_GET["subcount1"];
    $subcount2 = $_GET["subcount2"];
    $count = $_GET["count"];
    $result = $model->add($subcount1, $subcount2, $count);
    if ($result == 1){
        echo "<h2>Данные добавлены<h2>";
    }
    if ($result == 2){
        echo "<h2>Данные изменены<h2>";
    }
    
}
/*--------------------------------------------------*/
if ($action == "getTable"){
    $subcount1 = isset($_GET["subcount1"]) ? $_GET["subcount1"] : "";
    $subcount2 = isset($_GET["subcount2"]) ? $_GET["subcount2"] : "";
    
    $table = $model->getTable($subcount1, $subcount2);
    $headerBlockList = [
        [
            "label" => "Склад",
            "id" => "filter_subcount1",
            "type" => "text"
        ],
        [
            "label" => "Материал",
            "id" => "filter_subcount2",
            "type" => "text"
        ],
        [
            "label" => "Показать только нехватку",
            "id" => "filter_notFull",
            "type" => "checkbox"
        ]
    ];
    $tableButtonList = [
        [
            "name" => "Добавить",
            "onclick" => "showAddMinBalanceForm(`{$subcount1}`)"
        ]
    ];
    foreach($headerBlockList as $block){
        $view->addHeaderBlock($block);
    }
    
    foreach($table as $row){
        $result = [];
        foreach($row as $key => $value){
            switch ($key):
                case "subcount1":
                case "subcount2":
                    $subcount = new \Subcount($value);
                    $result[$key] = [
                        "name" => $subcount->getName(),
                        "id" => $value
                    ];
                    break;
                case "curCount":
                case "minCount":
                    $result[$key] = [
                        "name" => $value
                    ];
            endswitch;
        }
        $view->addRow($result);
    }
    foreach($tableButtonList as $button){
        $view->addTableButton($button);
    }
    $view->show();
}
/*--------------------------------------------------*/
if ($action == "getAddForm"){
    $view->show("addForm");
}

if ($action == "delete"){
    $subcount1 = $_GET["subcount1"];
    $subcount2 = $_GET["subcount2"];
    $result = $model->delete($subcount1, $subcount2);
    echo $result;
}









































