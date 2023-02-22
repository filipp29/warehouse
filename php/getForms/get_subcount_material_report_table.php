<?php
error_reporting(E_ALL); //Включаем вывод ошибок
set_time_limit(600); //Устанавливаем максимальное время работы скрипта в секундах
ini_set('display_errors', 1); //Еще один вывод ошибок
ini_set('memory_limit', '512M'); //Устанавливаем ограничение памяти на скрипт (512Мб)

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';


setOrgAll("");
$timeStamp1 = $_GET["timeStamp1"];
$timeStamp2 = $_GET["timeStamp2"];
$subcount1 = $_GET["subcount1"];
$subcount2 = $_GET["subcount2"];
$listType = $_GET["listType"];
$byType1 = $_GET["byType1"];
$byType2 = $_GET["byType2"];
$account = $_GET["account"];
if (!$listType){
    $listType = "material";
}
$view = new \View2("/_modules/warehouse/views/ReportView/");
$subcountList = \Subcount::getSubcountList($listType, true);
if ($subcount2){
    $flag = true;
}
else{
    $flag = false;
}
$sum = [
    "dbtBefore" => 0,
    "dbt" => 0,
    "crt" => 0,
    "dbtAfter" => 0
];
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
    $crtBefore = (int)\Reports::getBalance("{$account}/{$byType1}/{$subcount1}/{$byType2}/{$subcount2}/", "crt", $dateBefore);
    $dbtBefore = (int)\Reports::getBalance("{$account}/{$byType1}/{$subcount1}/{$byType2}/{$subcount2}/", "dbt", $dateBefore);
    
    $crtBefore += (int)\Entry::getDailyBy2($timeStamp1, $subcount1, $subcount2, "crt",$byType1,$byType2,$account);
    $dbtBefore += (int)\Entry::getDailyBy2($timeStamp1, $subcount1, $subcount2, "dbt",$byType1,$byType2,$account);
    
    $crtAfter = (int)\Reports::getBalance("{$account}/{$byType1}/{$subcount1}/{$byType2}/{$subcount2}/", "crt", $dateAfter);
    $dbtAfter = (int)\Reports::getBalance("{$account}/{$byType1}/{$subcount1}/{$byType2}/{$subcount2}/", "dbt", $dateAfter);
    $crtAfter += (int)\Entry::getDailyBy2($timeStamp2, $subcount1, $subcount2, "crt",$byType1,$byType2,$account);
    $dbtAfter += (int)\Entry::getDailyBy2($timeStamp2, $subcount1, $subcount2, "dbt",$byType1,$byType2,$account);
    $dbt = $dbtAfter - $dbtBefore;
    $crt = $crtAfter - $crtBefore;
    $dbtAfter -= $crtAfter;
    $crtAfter = 0;
    $dbtBefore -= $crtBefore;
    $crtBefore = 0;
    if ($byType1 == "bySubcount2"){
        $buf = new \Subcount($subcount1);
        $price = $buf->getPrice($timeStamp2);
    }
    if ($byType1 == "bySubcount1"){
        $buf = new \Subcount($subcount2);
        $price = $buf->getPrice($timeStamp2);
    }
//    $sum = $crtAfter + $crtBefore + $dbtAfter + $dbtBefore + $dbt + $crt;
    
    if (($crt == 0) && ($crtAfter == 0) && ($crtBefore == 0) && ($dbtAfter == 0) && ($dbtBefore == 0) && ($dbt == 0)){
        continue;
    }
    $list = [
        "dbtBefore" => $dbtBefore,
        "dbt" => $dbt,
        "crt" => $crt,
        "dbtAfter" => $dbtAfter
    ];
    $data = [
        "onclick" => "getEntryTableBy2('{$subcount1}','{$subcount2}','{$timeStamp1}','{$timeStamp2}','{$byType1}','{$byType2}','{$account}')"
    ];
    $minCount = \MinBalanceTable::getOne($subcount1, $subcount2);
    
    if (($minCount > 0) && ((int)$minCount > (int)$dbtAfter)){
        $bgColor = "background-color: #FA8072";
    }
    else{
        $bgColor = "";
    }
    $view->show("table.row.header",$data);
    {
        $data = [
            "text" => $subcount2Name,
            "style" => "". $bgColor
        ];
        $view->show("table.cell.data",$data);
        foreach($list as $key => $value){
            $data = [
                "text" => $value,
                "style" => "". $bgColor
            ];
            $view->show("table.cell.data",$data);
            $data = [
                "text" => (int)$value * (int)$price,
                "style" => "". $bgColor
            ];
            $view->show("table.cell.data",$data);
            $sum[$key] += (int)$value * (int)$price;
        }
//     
        
    }
    
    
    
    
    
    $view->show("table.row.footer");
    if ($flag){
        break;
    }
}

$view->show("table.row.header");
for($i = 0; $i < 9; $i++){
    $data = [
        "text" => "",
        "style" => "border: none; background-color: white"
    ];
    $view->show("table.cell.data",$data);
    
}
$view->show("table.row.footer");

$view->show("table.row.header");
for($i = 0; $i < 9; $i++){
    $data = [
        "text" => "",
        "style" => "border: none; background-color: white"
    ];
    $view->show("table.cell.data",$data);
    
}
$view->show("table.row.footer");


$view->show("table.row.header");
$data = [
    "text" => "Итого",
];
$view->show("table.cell.data",$data);
foreach($sum as $key => $value){
    $data = [
        "text" => "",
        "style" => ""
    ];
    $view->show("table.cell.data",$data);
    $data = [
        "text" => $value,
        "style" => ""
    ];
    $view->show("table.cell.data",$data);
}
$view->show("table.row.footer");



















