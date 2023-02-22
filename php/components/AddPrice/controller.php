<?php
$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //Подключаем библиотеку для работы с БД
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';

error_reporting(E_ALL); //Включаем вывод ошибок
set_time_limit(600); //Устанавливаем максимальное время работы скрипта в секундах
ini_set('display_errors', 1); //Еще один вывод ошибок
ini_set('memory_limit', '512M'); //Устанавливаем ограничение памяти на скрипт (512Мб)


function getForm(){
    $id = $_GET["id"];
    $view = new \View2("/_modules/warehouse/php/components/AddPrice/");
    $data = [
        "id" => $id,
        "date" => date("Y-m-d\TH:i",time())
    ];
    $view->show("main", $data);
}

function addPrice(){
    $id = $_GET["id"];
    $timeStamp = $_GET["timeStamp"];
    $price = $_GET["price"];

    $subcount = new \Subcount($id);
    $subcount->addPrice($price, $timeStamp);
    echo "1 - {$price}; 2 - {$timeStamp}";
}





$action = $_GET["action"];

switch ($action):
    case "getForm":
        getForm();
        break;
    case "addPrice":
        addPrice();
        break;
endswitch;







