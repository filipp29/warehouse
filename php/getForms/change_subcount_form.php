<?php

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //Подключаем библиотеку для работы с БД
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';

error_reporting(E_ALL); //Включаем вывод ошибок
set_time_limit(600); //Устанавливаем максимальное время работы скрипта в секундах
ini_set('display_errors', 1); //Еще один вывод ошибок
ini_set('memory_limit', '512M'); //Устанавливаем ограничение памяти на скрипт (512Мб)
setOrgAll("");

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
        $data["id"] = "create_".$data["id"];
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
        $params,
        $value,
        $name,
        $style = ""
){
    $data = [
        "style" => $style,
        "label" => $label
    ];
    $view->show("headerBlock.header", $data);
    $data = [
        "id" => "create_". $id,
        "type" => $type,
        "params" => $params,
        "value" => $value,
        "curValue" => $name
    ];
    $view->show("selectForm", $data);
    $view->show("headerBlock.footer");
}





/*--------------------------------------------------*/

key_exists("org", $_GET) ? $org = $_GET["org"] : $org = "";

if (!$org){
    $org = "default";
}
setOrgAll($org);



$buttonParams = [
    "subcountSave" => [
        "name" => "Сохранить",
        "onclick" => "subcountCreate()",
        "style" => "margin-left: 15px"
    ]
];

$view = new \View2("/_modules/warehouse/views/createSubcountForm/");
$typeList = \Subcount::getTypeList();
$id = $_GET["id"];

try{
    $subcount = new \Subcount($id);
    $type = $subcount->getType();
    $vars = [];
    
    $view->show("header");
    $data = [
        "title" => $typeList[$type]
    ];
    $view->show("createSubcountHeader.header", $data);
    
    $data = [
        "id" => "name",
        "label" => "Имя",
        "type" => "text",
        "style" => "width: 100%",
        "value" => $subcount->getName()
    ];
    $dependDir = [];
    showInputBlock($view, $data);
    $paramList = \Subcount::getParamList($type);
    foreach($paramList as $key => $value){
        switch ($value["type"]):
            case "select" :

                $params = "";
                $val = $subcount->getParams($key);
                $name = $subcount->getShow($key);
                if ((isset($value["dir"])) && (!$value["dir"])){
                    $value["dir"] = $dependDir[$key];
                }
                if (isset($value["depend_dir"])){
                    $dependDir[$value["depend_dir"]] = "{$value["dir"]}{$val}/";
                }
                foreach($value as $k => $v){
                    $params .= " data_{$k}='{$v}' ";
                }
                
                
                showSelectFormBlock($view, $key, $value["name"], $type,$params,$val,$name);
                break;
            case "list":

                $params = "data_subcountType='{$type}' data_type='list'";
                $v = $subcount->getParams($key);
                $name = $subcount->getShow($key);
                showSelectFormBlock($view, $key, $value["name"], $type, $params,$v,$name);
                break;
            case "string":
                $v = $subcount->getParams($key);
                $data = [
                    "id" => $key,
                    "label" => $value["name"],
                    "type" => "text",
                    "value" => $v
                ];
                showInputBlock($view, $data);
                break;
        endswitch;
    }
    $dec = new Decoder();
    $str = $dec->arrayToStr($vars);
    $data = [
        "id" => $id
    ];
    $view->show("id", $data);
    $data = [
        "type" => $type
    ];
    $view->show("type",$data);
    $data = [
        "data" => $str
    ];
    $buttonList = [
        "subcountSave"
    ];
    showButtonBlock($view, $buttonList, $buttonParams);
    $view->show("vars", $data);
    $view->show("footer",$data);
}
catch(\Exception $e){
    echo $e->getMessage();
}





















