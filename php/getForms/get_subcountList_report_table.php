<?php


$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //????????? ???????? ????? (?????, ?????? ???? ???????? ? ?????????? ????????
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
error_reporting(E_ALL); //???????? ????? ??????
set_time_limit(600); //????????????? ???????????? ????? ?????? ??????? ? ????????
ini_set('display_errors', 1); //??? ???? ????? ??????
ini_set('memory_limit', '512M'); //????????????? ??????????? ?????? ?? ?????? (512??)

setOrgAll("");
$timeStamp1 = $_GET["timeStamp1"];
$timeStamp2 = $_GET["timeStamp2"];
$subcount2 = $_GET["subcount2"];
$listType = $_GET["listType"];
$byType1 = "bySubcount1";
$byType2 = "bySubcount2";
$account = $_GET["account"];

$view = new \View2("/_modules/warehouse/views/ReportView/");
$subcount1List = \Subcount::getSubcountList($listType, true);
$subcount2List = \Subcount::getSubcountList("material", true);
if ($subcount2){
    $flag = true;
}
else{
    $flag = false;
}

$total = [
    "dbtBefore" => 0,
    "dbt" => 0,
    "crt" => 0,
    "dbtAfter" => 0
];

foreach($subcount1List as $v){
    $subcount1 = $v["id"];
    
    $sum = [
        "dbtBefore" => 0,
        "dbt" => 0,
        "crt" => 0,
        "dbtAfter" => 0
    ];
    $sub1Name = $v["name"];
    foreach($subcount2List as $value){
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
        
        $buf = new \Subcount($subcount2);
        $price = $buf->getPrice($timeStamp2);
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
        foreach($list as $key => $value){
            $sum[$key] += (int)$value * (int)$price;
        }

        if ($flag){
            break;
        }
    }
    
    
    
    




    $view->show("table.row.header");
    $data = [
        "text" => $sub1Name,
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
        $total[$key] += $value;
    }
    $view->show("table.row.footer");

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
    "text" => "?????",
];
$view->show("table.cell.data",$data);
foreach($total as $key => $value){
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




















        