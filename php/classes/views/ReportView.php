<?php
error_reporting(E_ALL); //Включаем вывод ошибок
set_time_limit(600); //Устанавливаем максимальное время работы скрипта в секундах
ini_set('display_errors', 1); //Еще один вывод ошибок
ini_set('memory_limit', '512M'); //Устанавливаем ограничение памяти на скрипт (512Мб)
$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';




/*--------------------------------------------------*/
/*
 * Класс предназначен для отображения формы отчета
 * 
 * 
 * ---------------------------------------------------
 * Атрибуты-------------------------------------------
 * 
 * ---------------------------------------------------
 * Статические методы---------------------------------
 * 
 * show(type) - возвращает форму отчета выбранного типа type
 * 
 * --------------------------------------------------*/


class ReportView {
    static private $type = null;
    static private $view = null;
    
    
    static private $filterList = [
        "warehouse-material" => [
            "subcount1" => "inCharge"
        ],
        "contractor-material" => [
        ],
        "profile-material" => [
            "subcount1" => "supervisor"
        ],
        "material-warehouse" => [
            "subcount2" => "inCharge"
        ],
        "profile-contractor" => [
            "subcount1" => "supervisor"
        ],
        "warehouse-asset" => [
            "subcount1" => "inCharge"
        ],
        "contractor-asset" => [
        ],
        "profile-asset" => [
            "subcount1" => "supervisor"
        ],
        "object-asset" => [
        ],
    ];
    
    
    static private $buttonParams = [
        "getReport" => [
            "name" => "Получить",
            "onclick" => "getReport()",
            "style" => "margin-right: 15px"
        ],
        "close" => [
            "name" => "Сохранить/Провести",
            "onclick" => "saveRunDoc()",
            "style" => "margin-left: 15px"
        ]
    ];
    
    
    static private $accessList = [
        "warehouse-material" => "2",
        "contractor-material" => "1",
        "profile-material" => "2",
        "material-warehouse" => "1",
        "profile-contractor" => "2",
        "warehouse-asset" => "2",
        "contractor-asset" => "2",
        "profile-asset" => "2",
        "object-asset" => "2",
        "warehouse-list" => "1"
    ];
    
    static private $typeParams = [
        "warehouse-material" => [
            "subcount1" => "warehouse",
            "subcount1Name" => "Склад",
            "subcount2" => "material",
            "subcount2Name" => "Материал",
            "name" => "Отчет по складу",
            "account" => "1310",
            "byType1" => "bySubcount1",
            "byType2" => "bySubcount2",
            "onclick" => "getSubcountMaterialTable()"
        ],
        "contractor-material" => [
            "subcount1" => "contractor",
            "subcount1Name" => "Контрагент",
            "subcount2" => "material",
            "subcount2Name" => "Материал",
            "name" => "Отчет по контрагенту",
            "account" => "1310",
            "byType1" => "bySubcount1",
            "byType2" => "bySubcount2",
            "onclick" => "getSubcountMaterialTable()"
        ],
        "profile-material" => [
            "subcount1" => "profile",
            "subcount1Name" => "Работник",
            "subcount2" => "material",
            "subcount2Name" => "Материал",
            "name" => "Отчет по работнику",
            "account" => "1310",
            "byType1" => "bySubcount1",
            "byType2" => "bySubcount2",
            "onclick" => "getSubcountMaterialTable()"
        ],
        "material-warehouse" => [
            "subcount1" => "material",
            "subcount1Name" => "Материал",
            "subcount2" => "warehouse",
            "subcount2Name" => "Склад",
            "name" => "Отчет по материалу на складах",
            "account" => "1310",
            "byType1" => "bySubcount2",
            "byType2" => "bySubcount1",
            "onclick" => "getSubcountMaterialTable()"
        ],
        "profile-contractor" => [
            "subcount1" => "profile",
            "subcount1Name" => "Работник",
            "subcount2" => "contractor",
            "subcount2Name" => "Контрагент",
            "subcount3" => "material",
            "subcount3Name" => "Материал",
            "name" => "Отчет работник - контрагент",
            "account" => "1310",
            "byType1" => "bySubcount1",
            "byType2" => "bySubcount1",
            "byType3" => "bySubcount2",
            "onclick" => "getSubcountSubcountTable()",
            "byThree" => true
        ],
        "warehouse-list" => [
            "subcount1" => "warehouse",
            "subcount1Name" => "Склад",
            "subcount2" => "material",
            "subcount2Name" => "Материал",
            "name" => "Отчет по складу",
            "account" => "1310",
            "byType1" => "bySubcount1",
            "byType2" => "bySubcount2",
            "onclick" => "getSubcountListTable()",
            "byList" => true
        ],
        "warehouse-asset" => [
            "subcount1" => "warehouse",
            "subcount1Name" => "Склад",
            "subcount2" => "asset",
            "subcount2Name" => "ОС",
            "name" => "Отчет по складу ОС",
            "account" => "2410",
            "byType1" => "bySubcount1",
            "byType2" => "bySubcount2",
            "onclick" => "getSubcountMaterialTable()"
        ],
        "contractor-asset" => [
            "subcount1" => "contractor",
            "subcount1Name" => "Контрагент",
            "subcount2" => "asset",
            "subcount2Name" => "ОС",
            "name" => "Отчет по контрагенту ОС",
            "account" => "2410",
            "byType1" => "bySubcount1",
            "byType2" => "bySubcount2",
            "onclick" => "getSubcountMaterialTable()"
        ],
        "profile-asset" => [
            "subcount1" => "profile",
            "subcount1Name" => "Работник",
            "subcount2" => "asset",
            "subcount2Name" => "ОС",
            "name" => "Отчет по работнику ОС",
            "account" => "2410",
            "byType1" => "bySubcount1",
            "byType2" => "bySubcount2",
            "onclick" => "getSubcountMaterialTable()"
        ],
        "object-asset" => [
            "subcount1" => "object",
            "subcount1Name" => "Объект",
            "subcount2" => "asset",
            "subcount2Name" => "ОС",
            "name" => "Отчет по ОС на объекте",
            "account" => "2410",
            "byType1" => "bySubcount1",
            "byType2" => "bySubcount2",
            "onclick" => "getSubcountMaterialTable()"
        ],
    ];
    
    static private $tableButtonParams = [
        "getReport" => [
            "name" => "Получить",
            "style" => "margin-right: 15px"
        ],
    ];
    
    
    /*--------------------------------------------------*/
    
    public function __construct(
            $type
    ){
        $this->type = $type;
        $this->new = true;
        $this->view = new \View2("/_modules/warehouse/views/ReportView/");
    }
    
    /*--------------------------------------------------*/
    
    static public function getAccessList(){
        return static::$accessList;
    }
    
    /*--------------------------------------------------*/
    
    static private function showSelectBlock(
        $id,
        $label,
        $ar,
        $style = ""
    ){
        $data = [
            "style" => $style,
            "label" => $label
        ];
        self::$view->show("headerBlock.header", $data);
        $data = [
            "id" => $id
        ];
        self::$view->show("select.header", $data);
        foreach($ar as $v){
            $data = [
                "value" => $v["value"],
                "name" => $v["name"]
            ];
            self::$view->show("select.data",$data);
        }
        self::$view->show("select.footer");
        self::$view->show("headerBlock.footer");
    }
    
    /*--------------------------------------------------*/
    
    static private function showSelectFormBlock(
        $id,
        $label,
        $type,
        $style = ""
    ){
        $data = [
            "style" => $style,
            "label" => $label
        ];
        isset(self::$filterList[self::$type][$id]) ? $filter = self::$filterList[self::$type][$id] : $filter = "";
        self::$view->show("headerBlock.header", $data);
        $data = [
            "id" => $id,
            "type" => $type,
            "filter" => $filter
        ];
        self::$view->show("selectForm", $data);
        self::$view->show("headerBlock.footer");
    }
    
    /*--------------------------------------------------*/
    
    static private function showInputBlock(
            $data
//            $id,
//            $label,
//            $type,
//            $style = "",
//            $value = ""
    ){
        self::$view->show("headerBlock.header", $data);
        self::$view->show("input",$data);
        self::$view->show("headerBlock.footer",$data);
    }
    
    
    /*--------------------------------------------------*/
    
    static private function showTableButtonBlock(
            $buttonList
    ){
        $data = [
            "style" => "width: 100%"
        ];
        self::$view->show("tableButtonBlock.header",$data);
        foreach($buttonList as $v){
            self::$view->show("tableButtonBlock.button", self::$tableButtonParams[$v]);
        }
        self::$view->show("tableButtonBlock.footer");
    }
    
    
    /*--------------------------------------------------*/
    
    
    static private function showButtonBlock(
            $buttonList
    ){
        $data = [
            "style" => "width: 100%"
        ];
        self::$view->show("buttonBlock.header",$data);
        foreach($buttonList as $v){
            self::$view->show("buttonBlock.button", $this->buttonParams[$v]);
        }
        self::$view->show("buttonBlock.footer");
    }
    
    
    /*--------------------------------------------------*/
    
    static public function show(
            $type
    ){
        self::$type = $type;
        self::$view = new \View2("/_modules/warehouse/views/ReportView/");
        $data = [
            "title" => self::$typeParams[$type]["name"]
        ];
        self::$view->show("header");
        self::$view->show("reportHeader.header", $data);
        
        $dateData = [
            "id" => "timeStamp1",
            "label" => "Дата 1",
            "type" => "datetime-local"
        ];
        $headerParams = self::$typeParams[$type];
        $dateData["style"] = "width: 30%";
        $dateData["value"] = date("Y-m-d\TH:i",((int)time() - (24*60*60)));
        self::showInputBlock($dateData);
        
        $dateData = [
            "id" => "timeStamp2",
            "label" => "Дата 2",
            "type" => "datetime-local"
        ];
        $headerParams = self::$typeParams[$type];
        $dateData["style"] = "width: 60%";
        $dateData["value"] = date("Y-m-d\TH:i",time());
        self::showInputBlock($dateData);
        
//        $buf = \Subcount::getSubcountList($headerParams["subcount"], true);
//        $ar = [];
//        foreach($buf as $k => $v){
//            $ar[] = [
//                "name" => $v["name"],
//                "value" => $v["id"]
//            ];
//        }
//        self::showSelectBlock("src", $headerParams["subcountName"], $ar, "width: auto");
        if (!isset($headerParams["byList"])){
            self::showSelectFormBlock("subcount1", $headerParams["subcount1Name"], $headerParams["subcount1"]);
        }
        self::showSelectFormBlock("subcount2", $headerParams["subcount2Name"], $headerParams["subcount2"]);
        if (isset($headerParams["byThree"])){
            self::showSelectFormBlock("subcount3", $headerParams["subcount3Name"], $headerParams["subcount3"]);
        }
        $buttonList = [
            "getReport"
        ];
        
        self::$tableButtonParams["getReport"]["onclick"] = $headerParams["onclick"];
        
        self::showTableButtonBlock($buttonList);
        self::$view->show("reportHeader.footer");
        if (isset($headerParams["byThree"])){
            $data = [
                "listType" => $headerParams["subcount3"],
                "byType1" => $headerParams["byType1"],
                "byType2" => $headerParams["byType2"],
                "byType3" => $headerParams["byType3"]
            ];
        }
        else if (isset($headerParams["byList"])){
            $data = [
                "listType" => $headerParams["subcount1"]
            ];
        }
        else{
            $data = [
                "listType" => $headerParams["subcount2"],
                "byType1" => $headerParams["byType1"],
                "byType2" => $headerParams["byType2"]
            ];
        }
        $data["account"] = self::$typeParams[self::$type]["account"];
        $dec = new Decoder();
        $result = $dec->arrayToStr($data);
        self::$view->show("vars", ["data" => $result]);
        if (isset($headerParams["byThree"])){
            self::$view->show("table.header_by_three");
        }
        else{
            self::$view->show("table.header");
        }
        self::$view->show("footer");
        
    }
    
    
    
    
    /*--------------------------------------------------*/
    
    
    static public function showHorizontal(
            $type
    ){
        self::$type = $type;
        self::$view = new \View2("/_modules/warehouse/views/ReportView/");
        $data = [
            "title" => self::$typeParams[$type]["name"]
        ];
        $data = [
            "title" => self::$typeParams[$type]["name"],
            "styleMain" => "flex-direction: row; height: auto",
            "styleTitle" => "border-bottom: 1px #444 dotted; padding-bottom: 10px;"
        ];
        self::$view->show("headerHorizontal", $data);
        $data = [
            "style" => "width: 300px"
        ];
        self::$view->show("reportHeader.header",$data);
        
        $dateData = [
            "id" => "timeStamp1",
            "label" => "Дата 1",
            "type" => "datetime-local"
        ];
        $headerParams = self::$typeParams[$type];
        $dateData["style"] = "width: 100%";
        $dateData["value"] = date("Y-m-d\TH:i",((int)time() - (24*60*60)));
        self::showInputBlock($dateData);
        
        $dateData = [
            "id" => "timeStamp2",
            "label" => "Дата 2",
            "type" => "datetime-local"
        ];
        $headerParams = self::$typeParams[$type];
        $dateData["style"] = "width: 100%";
        $dateData["value"] = date("Y-m-d\TH:i",time());
        self::showInputBlock($dateData);
        
//        $buf = \Subcount::getSubcountList($headerParams["subcount"], true);
//        $ar = [];
//        foreach($buf as $k => $v){
//            $ar[] = [
//                "name" => $v["name"],
//                "value" => $v["id"]
//            ];
//        }
//        self::showSelectBlock("src", $headerParams["subcountName"], $ar, "width: auto");
        if (!isset($headerParams["byList"])){
            self::showSelectFormBlock("subcount1", $headerParams["subcount1Name"], $headerParams["subcount1"]);
        }
        self::showSelectFormBlock("subcount2", $headerParams["subcount2Name"], $headerParams["subcount2"], "width: 100%");
        if (isset($headerParams["byThree"])){
            self::showSelectFormBlock("subcount3", $headerParams["subcount3Name"], $headerParams["subcount3"], "width: 100%");
        }
        $buttonList = [
            "getReport"
        ];
        
        self::$tableButtonParams["getReport"]["onclick"] = $headerParams["onclick"];
        
        self::showTableButtonBlock($buttonList);
        self::$view->show("reportHeader.footer");
        if (isset($headerParams["byThree"])){
            $data = [
                "listType" => $headerParams["subcount3"],
                "byType1" => $headerParams["byType1"],
                "byType2" => $headerParams["byType2"],
                "byType3" => $headerParams["byType3"]
            ];
        }
        else if (isset($headerParams["byList"])){
            $data = [
                "listType" => $headerParams["subcount1"]
            ];
        }
        else{
            $data = [
                "listType" => $headerParams["subcount2"],
                "byType1" => $headerParams["byType1"],
                "byType2" => $headerParams["byType2"]
            ];
        }
        $data["account"] = self::$typeParams[self::$type]["account"];
        $dec = new Decoder();
        $result = $dec->arrayToStr($data);
        self::$view->show("vars", ["data" => $result]);
        $data = [
            "style" => "padding-top: 30px;"
        ];
        self::$view->show("tableBox.header",$data);
        if (isset($headerParams["byThree"])){
            self::$view->show("table.header_by_three");
        }
        else{
            self::$view->show("table.header");
        }
        self::$view->show("footer");
        
    }
    
    
    /*--------------------------------------------------*/
   
    
    
    
    
    
}
?>