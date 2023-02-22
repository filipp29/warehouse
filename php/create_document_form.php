<?php


$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //Подключаем библиотеку для работы с БД
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/Subcount.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/View2.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/Entry.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
error_reporting(E_ALL); //Включаем вывод ошибок
set_time_limit(600); //Устанавливаем максимальное время работы скрипта в секундах
ini_set('display_errors', 1); //Еще один вывод ошибок
ini_set('memory_limit', '512M'); //Устанавливаем ограничение памяти на скрипт (512Мб)


$count = $_GET["count"];
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
            "value" => $v["id"],
            "name" => $v["name"]
        ];
        $view->show("select.data",$data);
    }
    $view->show("select.footer");
}

/*--------------------------------------------------*/


function showTableSelect(
        $id,
        $ar,
        $view
){
    $data = [];
    $data["id"] = $id;
    $view->show("table.select.header", $data);
    foreach($ar as $v){
        $data = [
            "value" => $v["id"],
            "name" => $v["name"]
        ];
        $view->show("table.select.data",$data);
    }
    $view->show("table.select.footer");
}


/*--------------------------------------------------*/
if (!$org){
    $org = "default";
}
setOrgAll($org);


$view = new \View2("/_modules/warehouse/views/createDocumentForm/");
$wareList = \Subcount::getSubcountList("warehouse", true);
$matList = \Subcount::getSubcountList("material", true);
$view->show("header", $data);
showSelect("src", "Склад источник", $wareList,$view);
showSelect("dst", "Склад назначения", $wareList,$view);
//showSelect("material", "Материал", $matList,$view);

$view->show("table.header");
for($i = 0; $i < $count; $i++){
    $view->show("table.row.header");
    {
        $view->show("table.cell.header");
        showTableSelect("material_".$i,$matList,$view);
        $view->show("table.cell.footer");
    }
    {
        $view->show("table.cell.header");
        $data = [
            "id" => "price_".$i
        ];
        $view->show("table.cell.input",$data);
        $view->show("table.cell.footer");
    }
    {
        $view->show("table.cell.header");
        $data = [
            "id" => "count_".$i
        ];
        $view->show("table.cell.input",$data);
        $view->show("table.cell.footer");
    }
    $view->show("table.row.footer");
}
$view->show("table.footer");

$data =[
    "count" => $count
];
$view->show("footer", $data);

















