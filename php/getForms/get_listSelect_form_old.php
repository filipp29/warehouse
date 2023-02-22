<?php


$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //”казываем корневую папку (нужно, только если работаем с консольным скриптом
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/views/listSelectForm/php/base.php';

error_reporting(E_ALL); //¬ключаем вывод ошибок
set_time_limit(600); //”станавливаем максимальное врем€ работы скрипта в секундах
ini_set('display_errors', 1); //≈ще один вывод ошибок
ini_set('memory_limit', '512M'); //”станавливаем ограничение пам€ти на скрипт (512ћб)



$str = iconv("UTF-8", "cp1251", $_POST['data']); 
//$str = $_GET["data"];
$dec = new Decoder();
$list = $dec->strToArray($str);
$view = new \View2("/_modules/warehouse/views/listSelectForm/");
$view->show("header");
$data = [
    
];
$view->show("listSelectHeader.header",$data);

$buttonParams = [
    "submitSelect" => [
        "name" => "OK",
        "onclick" => "submitListSelect('{$type}')",
        "style" => "margin-right: 15px"
    ]
];



$view->show("listSelectHeader.footer");



$view->show("table.header");
$i = 0;
foreach($list as $el){
    $data = [
        "class" => ""
    ];
    $view->show("table.row.header",$data);
    {
        $data = [
            "text" => $el['name'],
            "class" => "name",
            "onclick" => "selectListRow('{$i}')",
            "id" => $el["value"]
        ];
        $i++;
        $view->show("table.cell.data", $data);
    }
    $view->show("table.row.footer");
}




$view->show("table.footer");

$buttonList = [
    "submitSelect"
];
showButtonBlock($view, $buttonList, $buttonParams);
$view->show("footer");




















