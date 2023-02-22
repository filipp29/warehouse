<?php

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/views/subcountForm/php/base.php';

error_reporting(E_ALL); //Включаем вывод ошибок
set_time_limit(600); //Устанавливаем максимальное время работы скрипта в секундах
ini_set('display_errors', 1); //Еще один вывод ошибок
ini_set('memory_limit', '512M'); //Устанавливаем ограничение памяти на скрипт (512Мб)



/*--------------------------------------------------*/

function materialExtra(
        $id
){
    $subcount2 = $id;
    $material = new \Subcount($id);
    $wareList = \Subcount::getSubcountList("warehouse", false);
    $result = [];
    $result[] = [
        "Цена",
        (int)$material->getPrice(). "<button style=\"margin: 0px 10px\" onclick=\"showAddPriceForm(`{$id}`)\">Установить</button>"
    ];
    $obj = objLoad("/profiles/{$_COOKIE["login"]}/profile.pro");
    $level = $obj["mod_warehouse"];
    $profile = $obj["login"];
    foreach($wareList as $key => $value){
        if (($level == "2") && ($value["inCharge"] != $profile)){
            continue;
        }
        
        $account = "1310";
        $byType1 = "bySubcount1";
        $byType2 = "bySubcount2";
        $subcount1 = $value["id"];
        
        $dateAfter = date("Ymd",time());
        $timeStamp2 = time();
        $crtAfter = (int)\Reports::getBalance("{$account}/{$byType1}/{$subcount1}/{$byType2}/{$subcount2}/", "crt", $dateAfter);
        $dbtAfter = (int)\Reports::getBalance("{$account}/{$byType1}/{$subcount1}/{$byType2}/{$subcount2}/", "dbt", $dateAfter);
        $crtAfter += (int)\Entry::getDailyBy2($timeStamp2, $subcount1, $subcount2, "crt",$byType1,$byType2,$account);
        $dbtAfter += (int)\Entry::getDailyBy2($timeStamp2, $subcount1, $subcount2, "dbt",$byType1,$byType2,$account);
        $result[] = [
            $value["name"],
            (int)$dbtAfter - (int)$crtAfter
        ];
    }
    return $result;
}

/*--------------------------------------------------*/


$id = $_GET["id"];
$subcount = new \Subcount($id);
$view = new \View2("/_modules/warehouse/views/subcountForm/");
$data = [
    "class" => "noHover"
];
$view->show("table.header",$data);
$params= [
    [
        "name" => "Имя",
         "value" => $subcount->getName()
    ],
    [
        "name" => "Тип",
        "value" => \Subcount::getTypeList()[$subcount->getType()]
    ],
    [
        "name" => "Номер",
        "value" => $subcount->getId()
    ]
];
foreach($subcount->getParams() as $k => $v){
    $params[] = [
        "name" => $subcount->getParamName($k),
        "value" => $v,
        "key" => $k
    ];
}
$paramList = \Subcount::getParamList($subcount->getType());
foreach($params as $k => $v){
    $view->show("table.row.header");
    {
        $data = [
            "text" => $v["name"]
        ];
        $view->show("table.cell.data",$data);
    }
    {   
        if ((isset($v["key"])) && (isset($paramList[$v["key"]]))){
            $buf = $paramList[$v["key"]];
        }
        if ((isset($buf)) && ($buf["type"] == "select")){
            if (isset($buf["dir"])){
                if (isset($buf['obj'])){
                    $value = objLoad("{$buf['dir']}{$v["value"]}/{$buf['obj']}","raw")[$buf['show']];
                }
                else{
                    $value = $v["value"];
                }
            }
        }
        else{
            $value = $v["value"];
        }
        $data = [
            "text" => $value
        ];
        $view->show("table.cell.data",$data);
    }
    $view->show("table.row.footer");
}
$result = [];
$type = $subcount->getType();
switch ($type):
    case "material":
        $result = materialExtra($id);
        break;
    
endswitch;
foreach($result as $value){
    $view->show("table.row.header");
    foreach($value as $text){
        $data = [
            "text" => $text
        ];
        $view->show("table.cell.data", $data);
    }
    $view->show("table.row.footer");
}
$view->show("table.footer");
$view->show("footer");















