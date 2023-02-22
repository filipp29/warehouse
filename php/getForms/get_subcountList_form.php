<?php

error_reporting(E_ALL); //Включаем вывод ошибок
set_time_limit(600); //Устанавливаем максимальное время работы скрипта в секундах
ini_set('display_errors', 1); //Еще один вывод ошибок
ini_set('memory_limit', '512M'); //Устанавливаем ограничение памяти на скрипт (512Мб)

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';


checkAccessLevel(1);


/*--------------------------------------------------*/










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

function show(){
    $groupList = \Subcount::getGroupList();
    $type = $_GET["type"];

    $view = new \View2("/_modules/warehouse/views/subcountListForm/");
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
        ],
        "createSubcount" => [
            "name" => "Добавить",
            "onclick" => "createSubcount('{$type}')",
            "style" => "margin-right: 15px"
        ],
    ];

    $view->show("header");
    $data = [
        "title" => \Subcount::getTypeList()[$type]
    ];
    $view->show("subcountSelectHeader.header",$data);
    $paramList = \Subcount::getParamList($type);
    $searchList = \Subcount::getSearchList($type);
    $data = [
        "id" => "_name",
        "label" => "Имя",
        "type" => "text"
    ];
    showInputBlock($view, $data);
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
                case "string":
                    $data = [
                        "id" => $key,
                        "label" => $value["name"],
                        "type" => "text"
                    ];
                    showInputBlock($view, $data);
                    break;
            endswitch;
        }
    $buttonList = [
        "filterList",
    ];
    if ($type != "asset"){
        $buttonList[] = "createSubcount";
    }
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
        $data = [
            "class" => "",
            "id" => "trow_{$i}"
        ];
        $view->show("table.row.header",$data);
        {
            $view->show("table.cell.data");
            $data = [
                "text" => $subcount['name'],
                "class" => "name",
            ];
            if ($type != "asset"){
                $data["onclick"] = "showSubcountForm('{$subcount["id"]}')";
            }
            else{
                $data["onclick"] = "showAssetTransferTable('{$subcount["id"]}')";
            }
            $params = "data_id='{$subcount["id"]}'";
            $subId = $subcount["id"];
            $subBuf = new \Subcount($subcount["id"]);
            unset($subcount["name"],$subcount["type"],$subcount["#e"],$subcount["id"]);
            foreach($subcount as $key => $val){
                $value = $subBuf->getParams($key);
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
                "onclick" =>"showChangeSubcountForm('{$subId}')",
                "params" => ""
            ];
            $view->show("table.cell.data", $data);
        }
        $view->show("table.row.footer");
    }




    $view->show("table.footer");

    $buttonList = [];
    showButtonBlock($view, $buttonList, $buttonParams);
    $dec = new Decoder();
    $view->show("footer");
}



/*--------------------------------------------------*/



function showHorizontal(){
    $type = $_GET["type"];
    $groupList = \Subcount::getGroupList();
    $view = new \View2("/_modules/warehouse/views/subcountListForm/");
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
        ],
        "createSubcount" => [
            "name" => "Добавить",
            "onclick" => "createSubcount('{$type}')",
            "style" => "margin-right: 15px"
        ],
    ];
    $data = [
        "title" => \Subcount::getTypeList()[$type],
        "styleMain" => "flex-direction: row; height: auto",
        "styleTitle" => "border-bottom: 1px #444 dotted; padding-bottom: 10px;"
    ];
    $view->show("header",$data);
    $data = [
        "style" => "width: 300px; flex-direction: column;"
    ];
    
    $view->show("subcountSelectHeader.header",$data);
    $paramList = \Subcount::getParamList($type);
    $searchList = \Subcount::getSearchList($type);
    $data = [
        "id" => "_name",
        "label" => "Имя",
        "type" => "text"
    ];
    showInputBlock($view, $data);
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
                case "string":
                    $data = [
                        "id" => $key,
                        "label" => $value["name"],
                        "type" => "text"
                    ];
                    showInputBlock($view, $data);
                    break;
            endswitch;
        }
    $buttonList = [
        "filterList",
    ];
    if ($type != "asset"){
        $buttonList[] = "createSubcount";
    }
    showTableButtonBlock($view, $buttonList, $tableButtonParams);

    $view->show("subcountSelectHeader.footer");
    $data = [
        "groupParam" => $groupList[$type]
    ];
    $view->show("groupParam", $data);
    $data = [
        "style" => "width: 40%; padding-top: 30px;"
    ];
    $view->show("tableBox.header",$data);
    $data = [
        "style" => "width: 100%; height: auto"
    ];
    $view->show("table.headerHorizontal",$data);
    $subcountList = \Subcount::getSubcountList($type, false);
    $i = 0;
    foreach($subcountList as $subcount){
        $data = [
            "class" => "",
            "id" => "trow_{$i}"
        ];
        $view->show("table.row.header",$data);
        {
            $view->show("table.cell.data");
            $data = [
                "text" => $subcount['name'],
                "class" => "name",
            ];
            if ($type != "asset"){
                $data["onclick"] = "showSubcountOnPage('{$subcount["id"]}','trow_{$i}')";
            }
            else{
                $data["onclick"] = "showAssetTransferTable('{$subcount["id"]}')";
            }
            $params = "data_id='{$subcount["id"]}'";
            $subId = $subcount["id"];
            $subBuf = new \Subcount($subcount["id"]);
            unset($subcount["name"],$subcount["type"],$subcount["#e"],$subcount["id"]);
            foreach($subcount as $key => $val){
                $value = $subBuf->getParams($key);
                $params .= "data_{$key}='{$value}' ";
            }



            $data["params"] = $params;
            $i++;
            $view->show("table.cell.data", $data);
        }
        {
            $text = "<button style='width: 100%; height: 100%; margin: 0px'>.</button>";
            $data = [
                "text" => $text,
                "class" => "about",
                "onclick" =>"showChangeSubcountForm('{$subId}')",
                "params" => ""
            ];
            $view->show("table.cell.data", $data);
        }
        $view->show("table.row.footer");
    }




    $view->show("table.footerHorizontal");
//    $view->show("tableBox.footer");
    $data = [
        "style" => "width: calc(60% - 350px); padding-top: 30px; margin-left: 20px;",
        "id" => "info"
    ];
    $view->show("tableBox.header",$data);
    $view->show("tableBox.footer");
//    $buttonList = [];
//    showButtonBlock($view, $buttonList, $buttonParams);
    $dec = new Decoder();
    $view->show("footer");
}


$horizontal = isset($_GET["horizontal"]) ? $_GET["horizontal"] : null;
if ($horizontal){
    showHorizontal();
}
else{
    show();
}















