<?php
error_reporting(E_ALL); //Включаем вывод ошибок
set_time_limit(600); //Устанавливаем максимальное время работы скрипта в секундах
ini_set('display_errors', 1); //Еще один вывод ошибок
ini_set('memory_limit', '512M'); //Устанавливаем ограничение памяти на скрипт (512Мб)

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
//require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/views/subcountListForm/php/base.php';








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

/*--------------------------------------------------*/

    
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




$type = $_GET["type"];

$view = new \View2("/_modules/warehouse/views/subcountListForm/");
$view->show("header");
$data = [
    "title" => \Subcount::getTypeList()[$type]
];
$view->show("subcountHeader.header",$data);

$paramList = \Subcount::getParamList($type);
    foreach($paramList as $key => $value){
            $style = "";
            $curValue = "";
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

$tableButtonParams = [
    "createSubcount" => [
        "name" => "Добавить",
        "onclick" => "createSubcount('{$type}')",
        "style" => "margin-right: 15px"
    ],
    "filter" => [
        "name" => "Фильтр",
        "onclick" => "filterSubcount()"
    ]
];

$buttonList = [
    "createSubcount",
    "filter"
];

showTableButtonBlock($view, $buttonList, $tableButtonParams);

$view->show("subcountHeader.footer");
$theadParams= [
    "Имя",
    "Номер"
];
$keyList = [
    "name",
    "id"
];
$paramList = \Subcount::getParamList($type);
foreach($paramList as $key => $value){
    $theadParams[] = $value["name"];
    $keyList[] = $key;
}

$view->show("table.header.header");
foreach ($theadParams as $value){
    $data = [
        "text" => $value
    ];
    if (($value != "Имя")&&($value != "Номер")){
        $data["style"] = "width: 200px";
    }
    
    $view->show("table.header.cell",$data);
}
$view->show("table.header.footer");
$subcountList = \Subcount::getSubcountList($type, false);

foreach($subcountList as $subcount){
    $data = [
        "onclick" => "showChangeSubcountForm('{$subcount["id"]}')"
    ];
    $view->show("table.row.header",$data);
    foreach($keyList as $key){
        (key_exists($key, $paramList)) ? $buf = $paramList[$key] : $buf = [];
        if ((key_exists("type", $buf)) && ($buf["type"] == "select")){
            if (isset($buf["dir"])){
                if (key_exists("show", $buf)){
                    $value = objLoad("{$buf['dir']}{$subcount[$key]}/{$buf['obj']}","raw")[$buf['show']];
                }
                else{
                    $value = $subcount[$key];
                }
            }
        }
        else{
            $value = $subcount[$key];
        }
        $data = [
            "text" => $value
        ];
        $view->show("table.cell.data",$data);
    }
    $view->show("table.row.footer");
}




$view->show("table.footer");
$view->show("footer");




















