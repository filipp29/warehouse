<?php


$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';

error_reporting(E_ALL); //Включаем вывод ошибок
set_time_limit(600); //Устанавливаем максимальное время работы скрипта в секундах
ini_set('display_errors', 1); //Еще один вывод ошибок
ini_set('memory_limit', '512M'); //Устанавливаем ограничение памяти на скрипт (512Мб)


class JournalView {
    static private $type = null;
    static private $view = null;
    
    static private $filterList = [
        
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
    
    static private $tableButtonParams = [
        "getJournalTable" => [
            "name" => "Получить",
            "onclick" => "getJournalTable()",
            "style" => "margin-right: 15px"
        ],
    ];
    
    static private $typeParams = [
        "expense" => [
            "srcType" => "warehouse",
            "srcName" => "Склад",
            "dstType" => "contractor",
            "dstName" => "Контрагент",
            "name" => "Расход со склада",
            "account" => "1310",
        ],
        "expenseWorker" => [
            "srcType" => "profile",
            "srcName" => "Работник",
            "dstType" => "contractor",
            "dstName" => "Контрагент",
            "name" => "Расход от работника",
            "account" => "1310",
        ],
        "income" => [
            "dstType" => "warehouse",
            "dstName" => "Склад",
            "srcType" => "contractor",
            "srcName" => "Контрагент",
            "name" => "Приход",
            "account" => "1310",
        ],
        "transfer" => [
            "srcType" => "warehouse",
            "srcName" => "Склад ист.",
            "dstType" => "warehouse",
            "dstName" => "Склад наз.",
            "name" => "Перемещение между складами",
            "account" => "1310",
        ],
        "toWorker" => [
            "srcType" => "warehouse",
            "srcName" => "Склад ист.",
            "dstType" => "profile",
            "dstName" => "Работник",
            "name" => "Выдача материала рабочему",
            "account" => "1310",
        ],
        "fromWorker" => [
            "srcType" => "profile",
            "srcName" => "Работник",
            "dstType" => "warehouse",
            "dstName" => "Склад наз.",
            "name" => "Прием материала от рабочего",
            "account" => "1310",
        ],
        "asset_expense" => [
            "srcType" => "warehouse",
            "srcName" => "Склад",
            "dstType" => "contractor",
            "dstName" => "Контрагент",
            "name" => "Расход JC со склада",
            "account" => "2410",
        ],
        "asset_expenseWorker" => [
            "srcType" => "profile",
            "srcName" => "Работник",
            "dstType" => "contractor",
            "dstName" => "Контрагент",
            "name" => "Расход ОС от работника",
            "account" => "2410",
        ],
        "asset_income" => [
            "dstType" => "warehouse",
            "dstName" => "Склад",
            "srcType" => "contractor",
            "srcName" => "Контрагент",
            "name" => "Приход ОС",
            "account" => "2410",
        ],
        "asset_transfer" => [
            "srcType" => "warehouse",
            "srcName" => "Склад ист.",
            "dstType" => "warehouse",
            "dstName" => "Склад наз.",
            "name" => "Перемещение ОС между складами",
            "account" => "2410",
        ],
        "asset_toWorker" => [
            "srcType" => "warehouse",
            "srcName" => "Склад ист.",
            "dstType" => "profile",
            "dstName" => "Работник",
            "name" => "Выдача ОС рабочему",
            "account" => "2410",
        ],
        "asset_fromWorker" => [
            "srcType" => "profile",
            "srcName" => "Работник",
            "dstType" => "warehouse",
            "dstName" => "Склад наз.",
            "name" => "Прием ОС от рабочего",
            "account" => "2410",
        ],
        "asset_installWorker" => [
            "srcType" => "profile",
            "srcName" => "Работник",
            "dstType" => "object",
            "dstName" => "Объект",
            "name" => "Установка ОС от работника",
            "account" => "2410",
        ],
        "asset_install" => [
            "srcType" => "warehouse",
            "srcName" => "Склад",
            "dstType" => "object",
            "dstName" => "Объект",
            "name" => "Установка ОС со склада",
            "account" => "2410",
        ],
    ];
    
    
    
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
        self::$view->show("headerBlock.header", $data);
        $data = [
            "id" => $id,
            "type" => $type
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
            $buttonList,
            $style = ""
    ){
        $data = [
            "style" => "width: 100%;". $style 
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
        self::$view = new \View2("/_modules/warehouse/views/JournalView/");
        $data = [
            "title" => self::$typeParams[$type]["name"]
        ];
        self::$view->show("header");
        self::$view->show("journalHeader.header", $data);
        
        $dateData = [
            "id" => "timeStamp1",
            "label" => "Дата 1",
            "type" => "datetime-local"
        ];
        $headerParams = self::$typeParams[$type];
        $dateData["style"] = "width: 30%";
        $dateData["value"] = date("Y-m-d\TH:i",(int)time() - (24*60*60));
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
        
        
        $buttonList = [
            "getJournalTable"
        ];
        
        self::showTableButtonBlock($buttonList);
        self::$view->show("journalHeader.footer");
        
        $data = [
            "value" => $type,
            "id" => "type"
        ];
        self::$view->show("var",$data);
        
        
        $data = [
            "srcName" => self::$typeParams[$type]["srcName"],
            "dstName" => self::$typeParams[$type]["dstName"]
        ];
        
        self::$view->show("table.header",$data);
        self::$view->show("footer");
        
    }
    
    
    
    
    
    
    
    
    
    
    
    /*--------------------------------------------------*/

    static public function showHorizontal(
            $type
    ){
        self::$type = $type;
        self::$view = new \View2("/_modules/warehouse/views/JournalView/");
        $data = [
            "title" => self::$typeParams[$type]["name"]
        ];
        $data = [
            "title" => self::$typeParams[$type]["name"],
            "styleMain" => "flex-direction: row; height: auto",
            "styleTitle" => "border-bottom: 1px #444 dotted; padding-bottom: 10px;"
        ];
        self::$view->show("headerHorizontal",$data);
        $data = [
            "style" => "width: 300px"
        ];
        self::$view->show("journalHeader.header", $data);
        
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
        
        
        $buttonList = [
            "getJournalTable"
        ];
        $style = "justify-content: flex-start;"
                . "padding-left: 15px;"
                . "margin-left: 15px;";
        self::showTableButtonBlock($buttonList,$style);
        self::$view->show("journalHeader.footer");
        
        $data = [
            "value" => $type,
            "id" => "type"
        ];
        self::$view->show("var",$data);
        $data = [
            "style" => "padding-top: 30px;"
        ];
        self::$view->show("tableBox.header",$data);
        $data = [
            "srcName" => self::$typeParams[$type]["srcName"],
            "dstName" => self::$typeParams[$type]["dstName"]
        ];
        
        self::$view->show("table.header",$data);
        self::$view->show("footer");
        self::$view->show("tableBox.footer");
        
    }
    
    
}
    








/*--------------------------------------------------*/


?>