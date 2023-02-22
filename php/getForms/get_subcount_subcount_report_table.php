<?php


$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //”казываем корневую папку (нужно, только если работаем с консольным скриптом
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
error_reporting(E_ALL); //¬ключаем вывод ошибок
set_time_limit(600); //”станавливаем максимальное врем€ работы скрипта в секундах
ini_set('display_errors', 1); //≈ще один вывод ошибок
ini_set('memory_limit', '512M'); //”станавливаем ограничение пам€ти на скрипт (512ћб)

setOrgAll("");
$timeStamp1 = $_GET["timeStamp1"];
$timeStamp2 = $_GET["timeStamp2"];
$subcount1 = $_GET["subcount1"];
$subcount2 = $_GET["subcount2"];
$subcount3 = $_GET["subcount3"];
$listType = $_GET["listType"];
$byType1 = $_GET["byType1"];
$byType2 = $_GET["byType2"];
$byType3 = $_GET["byType3"];
if (!$listType){
    $listType = "material";
}
$view = new \View2("/_modules/warehouse/views/ReportView/");
$subcountList = \Subcount::getSubcountList($listType, true);
if ($subcount3){
    $flag = true;
}
else{
    $flag = false;
}
foreach($subcountList as $value){
    if (!$flag){
        $subcount3 = $value["id"];
        $subcount3Name = $value["name"];
    }
    else{
        $buf = new \Subcount($subcount3);
        $subcount3Name = $buf->getName();
        unset($buf);
    }
    $dateBefore = date("Ymd", $timeStamp1);
    $dateAfter = date("Ymd", $timeStamp2);
    $crtBefore = (int)\Reports::getBalance("1310/{$byType1}/{$subcount1}/{$byType2}/{$subcount2}/{$byType3}/{$subcount3}/", "crt", $dateBefore);
    $dbtBefore = (int)\Reports::getBalance("1310/{$byType1}/{$subcount1}/{$byType2}/{$subcount2}/{$byType3}/{$subcount3}/", "dbt", $dateBefore);
    
    $crtBefore += (int)\Entry::getDailyBy3($timeStamp1, $subcount1, $subcount2,$subcount3, "crt",$byType1,$byType2,$byType3);
    $dbtBefore += (int)\Entry::getDailyBy3($timeStamp1, $subcount1, $subcount2,$subcount3, "dbt",$byType1,$byType2,$byType3);
    
    $crtAfter = (int)\Reports::getBalance("1310/{$byType1}/{$subcount1}/{$byType2}/{$subcount2}/{$byType3}/{$subcount3}/", "crt", $dateAfter);
    $dbtAfter = (int)\Reports::getBalance("1310/{$byType1}/{$subcount1}/{$byType2}/{$subcount2}/{$byType3}/{$subcount3}/", "dbt", $dateAfter);
    
    $crtAfter += (int)\Entry::getDailyBy3($timeStamp2, $subcount1, $subcount2,$subcount3, "crt",$byType1,$byType2,$byType3);
    $dbtAfter += (int)\Entry::getDailyBy3($timeStamp2, $subcount1, $subcount2,$subcount3, "dbt",$byType1,$byType2,$byType3);
    $data = [
        "onclick" => "getEntryTableBy3('{$subcount1}','{$subcount2}','{$subcount3}','{$timeStamp1}','{$timeStamp2}','{$byType1}','{$byType2}','{$byType3}')"
    ];
    $view->show("table.row.header",$data);
    {

        $data = [
            "text" => $subcount3Name,
            "style" => ""
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
    $view->show("table.row.footer");
    if ($flag){
        break;
    }
}
























