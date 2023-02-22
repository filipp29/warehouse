<?php


$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //”казываем корневую папку (нужно, только если работаем с консольным скриптом
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
error_reporting(E_ALL); //¬ключаем вывод ошибок
set_time_limit(600); //”станавливаем максимальное врем€ работы скрипта в секундах
ini_set('display_errors', 1); //≈ще один вывод ошибок
ini_set('memory_limit', '512M'); //”станавливаем ограничение пам€ти на скрипт (512ћб)


$timeStamp1 = $_GET["timeStamp1"];
$timeStamp2 = $_GET["timeStamp2"];
$subcount1 = $_GET["subcount1"];
$subcount2 = $_GET["subcount2"];
$view = new \View2("/_modules/warehouse/views/ReportView/");
$subcountList = \Subcount::getSubcountList("material", true);
if ($subcount2){
    $flag = true;
}
else{
    $flag = false;
}
foreach($subcountList as $value){
    if (!$flag){
        $subcount2 = $value["id"];
        $subcount2Name = $value["name"];
    }
    else{
        $buf = new \Subcount($subcount2);
        $subcount2Name = $buf->getName();
        unset($buf);
    }
    $dateBefore = date("Ymd", $timeStamp1);
    $dateAfter = date("Ymd", $timeStamp2);
    $crtBefore = (int)\Reports::getBalance("/1310/bySubcount1/{$subcount1}/{$subcount2}/", "crt", $dateBefore);
    $dbtBefore = (int)\Reports::getBalance("/1310/bySubcount1/{$subcount1}/{$subcount2}/", "dbt", $dateBefore);
    
    $crtBefore += (int)\Entry::getDaily($timeStamp1, $subcount1, $subcount2, "crt");
    $dbtBefore += (int)\Entry::getDaily($timeStamp1, $subcount1, $subcount2, "dbt");
    
    $crtAfter = (int)\Reports::getBalance("/1310/bySubcount1/{$subcount1}/{$subcount2}/", "crt", $dateAfter);
    $dbtAfter = (int)\Reports::getBalance("/1310/bySubcount1/{$subcount1}/{$subcount2}/", "dbt", $dateAfter);
    
    $crtAfter += (int)\Entry::getDaily($timeStamp2, $subcount1, $subcount2, "crt");
    $dbtAfter += (int)\Entry::getDaily($timeStamp2, $subcount1, $subcount2, "dbt");
    $data = [
        "onclick" => "getEntryTable({$subcount1},{$subcount2},{$timeStamp1},{$timeStamp2})"
    ];
    $view->show("table.row.header",$data);
    {
//        $view->show("table.cell.header");
//        $data = [
//            "type" => "text",
//            "value" => $value["name"],
//            "style" => ""
//        ];
//        $view->show("table.cell.input", $data);
//        $view->show("table.cell.footer");
        $data = [
            "text" => $subcount2Name,
            "style" => ""
        ];
        $view->show("table.cell.data",$data);
        
    }
    {
//        $view->show("table.cell.header");
//        $data = [
//            "type" => "text",
//            "value" => $dbtBefore,
//            "style" => "text-align: right;width: 100px"
//        ];
//        $view->show("table.cell.input", $data);
//        $view->show("table.cell.footer");
        $data = [
            "text" => $dbtBefore,
            "style" => "text-align: right;width: 100px"
        ];
        $view->show("table.cell.data",$data);
    }
    {
//        $view->show("table.cell.header");
//        $data = [
//            "type" => "text",
//            "value" => $crtBefore,
//            "style" => "text-align: right;width: 100px"
//        ];
//        $view->show("table.cell.input", $data);
//        $view->show("table.cell.footer");
        $data = [
            "text" => $crtBefore,
            "style" => "text-align: right;width: 100px"
        ];
        $view->show("table.cell.data",$data);
    }
    
    {
//        $view->show("table.cell.header");
//        $data = [
//            "type" => "text",
//            "value" => $dbtAfter - $dbtBefore,
//            "style" => "text-align: right;width: 100px"
//        ];
//        $view->show("table.cell.input", $data);
//        $view->show("table.cell.footer");
        $data = [
            "text" => $dbtAfter - $dbtBefore,
            "style" => "text-align: right;width: 100px"
        ];
        $view->show("table.cell.data",$data);
    }
    {
//        $view->show("table.cell.header");
//        $data = [
//            "type" => "text",
//            "value" => $crtAfter - $crtBefore,
//            "style" => "text-align: right;width: 100px"
//        ];
//        $view->show("table.cell.input", $data);
//        $view->show("table.cell.footer");
        $data = [
            "text" => $crtAfter - $crtBefore,
            "style" => "text-align: right;width: 100px"
        ];
        $view->show("table.cell.data",$data);
    }
    
    {
//        $view->show("table.cell.header");
//        $data = [
//            "type" => "text",
//            "value" => $dbtAfter,
//            "style" => "text-align: right;width: 100px"
//        ];
//        $view->show("table.cell.input", $data);
//        $view->show("table.cell.footer");
        $data = [
            "text" => $dbtAfter,
            "style" => "text-align: right;width: 100px"
        ];
        $view->show("table.cell.data",$data);
    }
    {
//        $view->show("table.cell.header");
//        $data = [
//            "type" => "text",
//            "value" => $crtAfter,
//            "style" => "text-align: right;width: 100px"
//        ];
//        $view->show("table.cell.input", $data);
//        $view->show("table.cell.footer");
        $data = [
            "text" => $crtAfter,
            "style" => "text-align: right;width: 100px"
        ];
        $view->show("table.cell.data",$data);
    }
    $view->show("table.row.footer");
    if ($flag){
        break;
    }
}
























