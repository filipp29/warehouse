<?php

error_reporting(E_ALL); //Включаем вывод ошибок
set_time_limit(600); //Устанавливаем максимальное время работы скрипта в секундах
ini_set('display_errors', 1); //Еще один вывод ошибок
ini_set('memory_limit', '512M'); //Устанавливаем ограничение памяти на скрипт (512Мб)

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';





/*--------------------------------------------------*/


$adminList = [
    "filipp",
    "izus"
];


$groupList = \Subcount::getGroupList();



/*--------------------------------------------------*/

function showSelectBlock(
        $view,
        $id,
        $label,
        $ar,
        $style = ""
    ){
        $data = [
            "style" => $style,
            "label" => $label
        ];
        $view->show("headerBlock.header", $data);
        $data = [
            "id" => $id
        ];
        $view->show("select.header", $data);
        foreach($ar as $v){
            $data = [
                "value" => $v["value"],
                "name" => $v["name"]
            ];
            $view->show("select.data",$data);
        }
        $view->show("select.footer");
        $view->show("headerBlock.footer");
    }
    
    /*--------------------------------------------------*/
    
    function showInputBlock(
            $view,
            $data
//            $id,
//            $label,
//            $type,
//            $style = "",
//            $value = "",
//            $disabled = ""   
    ){
        $view->show("headerBlock.header", $data);
        $view->show("input",$data);
        $view->show("headerBlock.footer",$data);
    }
    
    
    /*--------------------------------------------------*/
    
    function showTableButtonBlock(
            $view,
            $buttonList,
            $tableButtonParams
    ){
        $data = [
            "style" => "width: 100%"
        ];
        $view->show("tableButtonBlock.header",$data);
        foreach($buttonList as $v){
            $view->show("tableButtonBlock.button", $tableButtonParams[$v]);
        }
        $view->show("tableButtonBlock.footer");
    }
    
    
    /*--------------------------------------------------*/
    
    
    function showButtonBlock(
            $view,
            $buttonList,
            $buttonParams
    ){
        $data = [
            "style" => "width: 100%"
        ];
        $view->show("buttonBlock.header",$data);
        foreach($buttonList as $v){
            $view->show("buttonBlock.button", $buttonParams[$v]);
        }
        $view->show("buttonBlock.footer");
    }

function showSelectFormBlock(
        $view,
        $id,
        $label,
        $type,
        $params = "",
        $style = "",
        $curValue = ""
){
    $data = [
        "style" => $style,
        "label" => $label
    ];
    $view->show("headerBlock.header", $data);
    $data = [
        "id" => $id,
        "type" => $type,
        "params" => $params,
        "style" => $style,
        "value" => $curValue
    ];
    $view->show("selectForm", $data);
    $view->show("headerBlock.footer");
}

/*--------------------------------------------------*/


function isAdmin(
        $profile
){
    $obj = objLoad("/profiles/{$profile}/profile.pro");
    if ($obj["mod_warehouse"] == "1"){
        return true;
    }
    else{
        return false;
    }
}





/*--------------------------------------------------*/

$str = $_GET["data"];
$dec = new \Decoder();
$data = $dec->strToArray($str);
$type = $data["type"];
$subcount1 = $data["subcount1"];
$timeStamp = isset($data["timeStamp"]) ? $data["timeStamp"] : time();
if ((isset($data["searchParams"])) && ($data["searchParams"] != null)){
    $searchParams = $data["searchParams"];
}
else{
    $searchParams = [];
}
$view = new \View2("/_modules/warehouse/views/subcountSelectForm/");
$buttonParams = [
    "submitSelect" => [
        "name" => "OK",
        "onclick" => "submitSelect('{$type}')",
        "style" => "margin-right: 15px"
    ]
];

$tableButtonParams = [
    "filterList" => [
        "name" => "Фильтр",
        "onclick" => "subcountFilter()",
        "style" => "margin-right: 15px"
    ]
];

$view->show("header");
$data = [
    "title" => \Subcount::getTypeList()[$type]
];
$view->show("subcountSelectHeader.header",$data);
$paramList = \Subcount::getParamList($type);
$searchList = \Subcount::getSearchList($type);
$data = [
    "id" => "_subcountName",
    "label" => "Имя",
    "type" => "text"
];
showInputBlock($view, $data);
    foreach($searchList as $key){
        $value = $paramList[$key];
        if (key_exists($key, $searchParams)){
            if ((isset($value["dir"])) && ($value["dir"] == "/profiles/") && (isAdmin($searchParams[$key]))){
                $style = "";
                $curValue = "";
            }
            else {
                $style = "display: none";
                $curValue = $searchParams[$key];
            }
        }
        else{
            $style = "";
            $curValue = "";
        }
        switch ($value["type"]):
            case "select" :
//                $buf = \Subcount::getParamValues($type, $key);
//                $ar = [];
//
//                foreach($buf as $k => $v){
//                    $ar[] = [
//                        "value" => $k,
//                        "name" => $v
//                    ];
//
//                }
//                $vars[$key] = $ar;
                $params = "";
                
                foreach($value as $k => $v){
                    $params .= " data_{$k}='{$v}' ";
                }
                showSelectFormBlock($view, $key, $value["name"],$type,$params,$style,$curValue);
                break;
            case "list":
//                $buf = \Subcount::getParamValues($type, $key);
//                $ar = [];
//                foreach($buf as $v){
//                    $ar[] = [
//                        "value" => $v,
//                        "name" => $v
//                    ];
//                }
//                $vars[$key] = $ar;
//                
                $params = "data_subcountType='{$type}' data_type='list'";
                showSelectFormBlock($view, $key, $value["name"], $type,$params,$style,$curValue);
                break;
            case "subcount":
                $style = "display: none";
                $params = "data_subcountType='{$type}'";
                showSelectFormBlock($view, $key, $value["name"], $type,$params,$style,$curValue);
                break;
        endswitch;
    }
$buttonList = [
    "filterList"
];
showTableButtonBlock($view, $buttonList, $tableButtonParams);

$view->show("subcountSelectHeader.footer");
$data = [
    "groupParam" => $groupList[$type]
];
$view->show("groupParam", $data);

$view->show("table.header");
$subcountList = \Subcount::getSubcountList($type, false);
$i = 0;
foreach($subcountList as $subcount){
    if(($type == "material") && ($subcount["matType"] == "НЕ УЧИТЫВАТЬ")){
        continue;
    }
    $data = [
        "class" => "",
        "id" => "trow_{$i}"
    ];
    $view->show("table.row.header",$data);
    {
        
        if (($type == "material") && ($subcount1)){
            $timeStamp2 = time();
            $subcount2 = $subcount["id"];
            $byType1 = "bySubcount1";
            $byType2 = "bySubcount2";
            $account = "1310";
            $dateAfter = date("Ymd", $timeStamp2);

            $crtAfter = (int)\Reports::getBalance("{$account}/{$byType1}/{$subcount1}/{$byType2}/{$subcount2}/", "crt", $dateAfter);
            $dbtAfter = (int)\Reports::getBalance("{$account}/{$byType1}/{$subcount1}/{$byType2}/{$subcount2}/", "dbt", $dateAfter);
            $crtAfter += (int)\Entry::getDailyBy2($timeStamp2, $subcount1, $subcount2, "crt",$byType1,$byType2,$account);
            $dbtAfter += (int)\Entry::getDailyBy2($timeStamp2, $subcount1, $subcount2, "dbt",$byType1,$byType2,$account);
            $count = $dbtAfter - $crtAfter;
            if ($count > 0){
                $color = "green";
            }
            else if ($count < 0){
                $color = "red";
            }
            else{
                $color = "blue";
            }
            $subName = "<div style='display: flex; justify-content: space-between;'><div>{$subcount["name"]}</div> <div style='padding: 0px 10px; font-size: 14px; color: {$color}'><span style='white-space: nowrap;'>(В наличии : {$count})</span></div></div>";
        }
        else{
            $subName = $subcount["name"];
        }
        $data = [
            "text" => $subName,
            "class" => "name",
            "onclick" => "selectRow('trow_{$i}')",
        ];
        
        $params = "data_id='{$subcount["id"]}'";
        $subId = $subcount["id"];
        $subBuf = new \Subcount($subcount["id"]);
        unset($subcount["name"],$subcount["type"],$subcount["#e"],$subcount["id"]);
        foreach($subcount as $key => $val){
            $value = $subBuf->getParams($key,$timeStamp);
            $params .= "data_{$key}='{$value}' ";
        }
        
        
        
        $data["params"] = $params;
        $i++;
        $view->show("table.cell.data", $data);
    }
    {
        $text = "<button style='width: 100%; height: 100%; margin: 0px'>...</button>";
        $data = [
            "text" => $text,
            "class" => "about",
            "onclick" =>"showSubcountForm('{$subId}')",
            "params" => ""
        ];
        $view->show("table.cell.data", $data);
    }
    $view->show("table.row.footer");
}




$view->show("table.footer");

$buttonList = [
    "submitSelect"
];
showButtonBlock($view, $buttonList, $buttonParams);
$dec = new Decoder();
$view->show("footer");




















