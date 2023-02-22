<?php

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //��������� �������� ����� (�����, ������ ���� �������� � ���������� ��������
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';

error_reporting(E_ALL); //�������� ����� ������
set_time_limit(600); //������������� ������������ ����� ������ ������� � ��������
ini_set('display_errors', 1); //��� ���� ����� ������
ini_set('memory_limit', '512M'); //������������� ����������� ������ �� ������ (512��)



/*--------------------------------------------------*/
/*
 * ����� ������������ ��� ����������� ����� ���������. ��� ������������� �����
 * ������� ��������� ������, ������� ������������ ��� ���������. ���� ����� ����������
 * ����� ������ ���������, �� ���������� ����� show(). ���� ����� ������� ����� ������������� 
 * ���������, �� ���������� ����� setParams(id,header,table) � ����� ����� show().
 * 
 * ---------------------------------------------------
 * ��������-------------------------------------------
 * 
 * pr $header - ������ ���������� ����� ���������
 * 
 * pr $table - ������ � ����������� ��������� �����
 * 
 * pr $type - ��� ���������
 * 
 * pr $id - ����� ���������
 * 
 * ---------------------------------------------------
 * ����������� ������---------------------------------
 * 
 * 
 * ---------------------------------------------------
 * ��������� ������ ����������------------------------
 * 
 * __construct(type) - ������� ��������� ������ � ������� �����������.
 * 
 * setParams(id,header,table) - ������ ��������� ��� ����������� �������������
 *      ���������. ����� ������� header �������� � $this->headerkeys.
 *      ����� ������� table �������� � $this->tableHeaders.
 * 
 * show() - ���������� ����� ���������. ���� ��� ������ ����� setParams, �� ����������
 *      ����� ������������� ��������� ��� ����������� ��������������. ���� ����� setParams 
 *      �� ��� ������ �� ������������ ����� �������� ������ ���������
 * 
 * --------------------------------------------------*/



class DocumentView{
    
    private $header = [];
    public $new;
    private $table = [];
    private $comment = [];
    private $view;
    private $type;
    private $id;
    private $win_id;
    private $print;
    private $adminList = [
        "filipp",
        "izus"
    ];
    private $filterList = [
        "expense" => [
            "src" => "inCharge"
        ],
        "expenseWorker" => [
            "src" => "supervisor"
        ],
        "income" => [
            "dst" => "inCharge"
        ],
        "transfer" => [
            "src" => "inCharge"
        ],
        "toWorker" => [
            "src" => "inCharge",
            "dst" => "supervisor"
        ],
        "fromWorker" => [
            "src" => "supervisor",
            "dst" => "inCharge"
        ],
        
        /*--------------------------------------------------*/
        "asset_expense" => [
            "src" => "inCharge"
        ],
        "asset_expenseWorker" => [
            "src" => "supervisor"
        ],
        "asset_income" => [
            "dst" => "inCharge"
        ],
        "asset_transfer" => [
            "src" => "inCharge"
        ],
        "asset_toWorker" => [
            "src" => "inCharge",
            "dst" => "supervisor"
        ],
        "asset_fromWorker" => [
            "src" => "supervisor",
            "dst" => "inCharge"
        ],
        
        
        
    ];
    
    static private $accessList = [
        "expense" => "2",
        "expenseWorker" => "2",
        "income" => "2",
        "transfer" => "2",
        "toWorker" => "2",
        "fromWorker" => "2",
        
        /*--------------------------------------------------*/
        "asset_expense" => "2",
        "asset_expenseWorker" => "2",
        "asset_income" => "2",
        "asset_transfer" => "2",
        "asset_toWorker" => "2",
        "asset_fromWorker" => "2",
    ];
    
    private $tableHeader = [
        [
            "type" => "id",
            "name" => "������������"
        ],
        [
            "type" => "price",
            "name" => "����"
        ],
        [
            "type" => "count",
            "name" => "����������"
        ],
        [
            "type" => "mes",
            "name" => "��. ���."
        ]
    ];
    private $headerKeys = [
        "src",
        "srcName",
        "dst",
        "dstName",
        "timeStamp",
        "account",
        "author",
        "authorName",
        "type"
    ];
    
    private $typeParams = [
        "expense" => [
            "srcType" => "warehouse",
            "srcName" => "�����",
            "dstType" => "contractor",
            "dstName" => "����������",
            "name" => "������ �� ������",
            "account" => "1310",
            "tableType" => "material",
            "commentList" => [
                "billNumber" => [
                    "name" => "����� ����",
                    "type" => "input"
                ],
                "common" => [
                    "name" => "����� ������",
                    "type" => "checkbox"
                ],
                "comment" => [
                    "name" => "�����������",
                    "type" => "textArea"
                ],
                
                
            ],
            "footer" => [
                [
                    "type" => "author",
                    "name" => "�������������"
                ],
            ]
        ],
        "expenseWorker" => [
            "srcType" => "profile",
            "srcName" => "��������",
            "dstType" => "contractor",
            "dstName" => "����������",
            "name" => "������ �� ���������",
            "account" => "1310",
            "tableType" => "material",
            "commentList" => [
                "billNumber" => [
                    "name" => "����� ����",
                    "type" => "input"
                ],
                "common" => [
                    "name" => "����� ������",
                    "type" => "checkbox"
                ],
                "comment" => [
                    "name" => "�����������",
                    "type" => "textArea"
                ],
            ],
            "footer" => [
                [
                    "type" => "author",
                    "name" => "�������������"
                ],
            ]
        ],
        "income" => [
            "dstType" => "warehouse",
            "dstName" => "�����",
            "srcType" => "contractor",
            "srcName" => "����������",
            "name" => "������",
            "account" => "1310",
            "tableType" => "material",
            "commentList" => [
                "comment" => [
                    "name" => "�����������",
                    "type" => "textArea"
                ]
            ],
            "footer" => [
                [
                    "type" => "author",
                    "name" => "�������������"
                ],
            ]
        ],
        "transfer" => [
            "srcType" => "warehouse",
            "srcName" => "����� ���.",
            "dstType" => "warehouse",
            "dstName" => "����� ���.",
            "name" => "����������� ����� ��������",
            "account" => "1310",
            "tableType" => "material",
            "price" => "0",
            "commentList" => [
                "comment" => [
                    "name" => "�����������",
                    "type" => "textArea"
                ]
            ],
            "footer" => [
                [
                    "type" => "author",
                    "name" => "�����"
                ],
                [
                    "type" => "dst",
                    "name" => "������",
                    "value" => "inCharge"
                ],
            ]
        ],
        "toWorker" => [
            "srcType" => "warehouse",
            "srcName" => "����� ���.",
            "dstType" => "profile",
            "dstName" => "��������",
            "name" => "������ ��������� ��������",
            "account" => "1310",
            "tableType" => "material",
            "price" => "0",
            "commentList" => [
                "comment" => [
                    "name" => "�����������",
                    "type" => "textArea"
                ]
            ],
            "footer" => [
                [
                    "type" => "author",
                    "name" => "�����"
                ],
                [
                    "type" => "dst",
                    "value" => "name",
                    "name" => "������"
                ],
            ]
        ],
        "fromWorker" => [
            "srcType" => "profile",
            "srcName" => "��������",
            "dstType" => "warehouse",
            "dstName" => "����� ���.",
            "name" => "����� ��������� �� ��������",
            "account" => "1310",
            "tableType" => "material",
            "price" => "0",
            "commentList" => [
                "comment" => [
                    "name" => "�����������",
                    "type" => "textArea"
                ]
            ],
            "footer" => [
                [
                    "type" => "author",
                    "name" => "������"
                ],
                [
                    "type" => "src",
                    "value" => "name",
                    "name" => "�����"
                ],
            ]
        ],
        
    /*--------------------------------------------------*/    
        
        "asset_income" => [
            "dstType" => "warehouse",
            "dstName" => "�����",
            "srcType" => "contractor",
            "srcName" => "����������",
            "name" => "������ ��",
            "account" => "2410",
            "tableType" => "asset",
            "count" => "1",
            "noTime" => "1",
            "commentList" => [
                "comment" => [
                    "name" => "�����������",
                    "type" => "textArea"
                ]
            ]
        ],
        "asset_expense" => [
            "srcType" => "warehouse",
            "srcName" => "�����",
            "dstType" => "contractor",
            "dstName" => "����������",
            "name" => "������ �� ������",
            "account" => "2410",
            "tableType" => "asset",
            "tableDepend" => "location",
            "count" => "1",
            "noTime" => "1",
            "commentList" => [
                "comment" => [
                    "name" => "�����������",
                    "type" => "textArea"
                ]
            ]
        ],
        "asset_expenseWorker" => [
            "srcType" => "profile",
            "srcName" => "��������",
            "dstType" => "contractor",
            "dstName" => "����������",
            "name" => "������ �� ���������",
            "account" => "2410",
            "tableType" => "asset",
            "tableDepend" => "location",
            "count" => "1",
            "noTime" => "1",
            "commentList" => [
                "comment" => [
                    "name" => "�����������",
                    "type" => "textArea"
                ]
            ]
        ],
        "asset_transfer" => [
            "srcType" => "warehouse",
            "srcName" => "����� ���.",
            "dstType" => "warehouse",
            "dstName" => "����� ���.",
            "name" => "����������� ����� ��������",
            "account" => "2410",
            "tableType" => "asset",
            "price" => "0",
            "tableDepend" => "location",
            "count" => "1",
            "noTime" => "1",
            "commentList" => [
                "comment" => [
                    "name" => "�����������",
                    "type" => "textArea"
                ]
            ]
        ],
        "asset_toWorker" => [
            "srcType" => "warehouse",
            "srcName" => "����� ���.",
            "dstType" => "profile",
            "dstName" => "��������",
            "name" => "������ ��������� ��������",
            "account" => "2410",
            "tableType" => "asset",
            "price" => "0",
            "tableDepend" => "location",
            "count" => "1",
            "noTime" => "1",
            "commentList" => [
                "comment" => [
                    "name" => "�����������",
                    "type" => "textArea"
                ]
            ]
        ],
        "asset_fromWorker" => [
            "srcType" => "profile",
            "srcName" => "��������",
            "dstType" => "warehouse",
            "dstName" => "����� ���.",
            "name" => "����� ��������� �� ��������",
            "account" => "2410",
            "tableType" => "asset",
            "price" => "0",
            "tableDepend" => "location",
            "count" => "1",
            "noTime" => "1",
            "commentList" => [
                "comment" => [
                    "name" => "�����������",
                    "type" => "textArea"
                ]
            ]
        ],
        "asset_installWorker" => [
            "srcType" => "profile",
            "srcName" => "��������",
            "dstType" => "object",
            "dstName" => "������.",
            "name" => "��������� �� �� ������ �� ��������",
            "account" => "2410",
            "tableType" => "asset",
            "price" => "0",
            "tableDepend" => "location",
            "count" => "1",
            "noTime" => "1",
            "commentList" => [
                "comment" => [
                    "name" => "�����������",
                    "type" => "textArea"
                ]
            ]
        ],
        "asset_install" => [
            "srcType" => "warehouse",
            "srcName" => "�����",
            "dstType" => "object",
            "dstName" => "������.",
            "name" => "��������� �� �� ������ �� ������",
            "account" => "2410",
            "tableType" => "asset",
            "price" => "0",
            "tableDepend" => "location",
            "count" => "1",
            "noTime" => "1",
            "commentList" => [
                "comment" => [
                    "name" => "�����������",
                    "type" => "textArea"
                ]
            ]
        ],
        
    ];
    
    private $tableButtonParams = [
        "addRow" => [
            "name" => "�������� ������",
            "onclick" => "addDocTableRow",
            "style" => "margin-right: 15px"
        ],
        "addRowTest" => [
            "name" => "�������� ������",
            "onclick" => "addDocTableRowTest",
            "style" => "margin-right: 15px"
        ],
        "clearTable" => [
            "name" => "�������� �������",
            "onclick" => "clearDocTable",
            "style" => "margin-right: 15px"
        ]
    ];
    
    private $buttonParams = [
        "close" => [
            "name" => "�������",
            "onclick" => "closeDocForm",
            "style" => "margin-left: 15px"
        ],
        "saveRun" => [
            "name" => "���������/��������",
            "onclick" => "saveRunDoc",
            "style" => "margin-left: 15px"
        ],
        "execute" => [
            "name" => "��������",
            "onclick" => "executeDoc",
            "style" => "margin-left: 15px;"
        ],
        "unexecute" => [
            "name" => "��������",
            "onclick" => "unexecuteDoc",
            "style" => "margin-left: 15px;"
        ],
        "delete" => [
            "name" => "�������",
            "onclick" => "deleteDoc",
            "style" => "margin-left: 15px;"
        ],
        "print" => [
            "name" => "������",
            "onclick" => "printDoc",
            "style" => "margin-left: 15px; width: 100px"
        ],
        "submit" => [
            "name" => "�����������",
            "onclick" => "submitDoc",
            "style" => "margin-left: 15px; width: 140px"
        ]
    ];
    
    /*--------------------------------------------------*/
    
    public function __construct(
            $type
    ){
        checkAccessLevel(self::$accessList[$type]);
        $this->type = $type;
        $this->new = true;
        $this->view = new \View2("/_modules/warehouse/views/DocumentView/");
        $this->win_id = (rand()%8900)+1000;
        $this->print = false;
    }
    
    
    /*--------------------------------------------------*/
    
    public function setPrint(
            $print
    ){
        $this->print = (bool)$print;
    }
    
    /*--------------------------------------------------*/
    
    public function setParams(
            $id,
            $header,
            $table,
            $comment
    ){
        $this->id = $id;
        $this->new = false;
        foreach($this->headerKeys as $k){
            if (key_exists($k, $header)){
                $this->header[$k] = $header[$k];
            }
            else{
                throw new Exception("Header {$k} not exists");
            }
        }
        $this->table = $table;
        $this->comment = $comment;
    }
    
    
    /*--------------------------------------------------*/
    
    static public function getAccessList(){
        return static::$accessList;
    }
    
    /*--------------------------------------------------*/
    
    private function showSelectBlock(
        $id,
        $label,
        $ar,
        $style = ""
    ){
        $data = [
            "style" => $style,
            "label" => $label
        ];
        $this->view->show("headerBlock.header", $data);
        $data = [
            "id" => "{$id}_{$this->win_id}"
        ];
        $this->view->show("select.header", $data);
        foreach($ar as $v){
            $data = [
                "value" => $v["value"],
                "name" => $v["name"]
            ];
            $this->view->show("select.data",$data);
        }
        $this->view->show("select.footer");
        $this->view->show("headerBlock.footer");
    }
    
    
    /*--------------------------------------------------*/
    
    
    private function showSelectFormBlock(
        $id,
        $label,
        $type,
        $style = ""
    ){
        $data = [
            "style" => $style,
            "label" => $label
        ];
        isset($this->filterList[$this->type][$id]) ? $filter = $this->filterList[$this->type][$id] : $filter = "";
        $this->view->show("headerBlock.header", $data);
        $data = [
            "id" => $id. "_{$this->win_id}",
            "type" => $type,
            "filter" => $filter
        ];
        $this->view->show("selectForm", $data);
        $this->view->show("headerBlock.footer");
    }
    
    
    /*--------------------------------------------------*/
    
    private function showInputBlock(
            $data
//            $id,
//            $label,
//            $type,
//            $class,
//            $style = "",
//            $value = "",
//            $disabled = ""   
    ){
        $data["id"] .= "_{$this->win_id}";
        $this->view->show("headerBlock.header", $data);
        $this->view->show("input",$data);
        $this->view->show("headerBlock.footer",$data);
    }
    
    /*--------------------------------------------------*/
    
    
    private function showTextBlock(
            $data
//            $id,
//            $label,
//            $type,
//            $style = "",
//            $value = "",
//            $disabled = ""   
    ){
        $data["id"] .= "_{$this->win_id}";
        $this->view->show("comment", $data);
    }
    
    
    /*--------------------------------------------------*/
    
    private function showTableButtonBlock(
            $buttonList,
            $style = ""
    ){
        $data = [
            "style" => "width: 100%;". $style
        ];
        $this->view->show("tableButtonBlock.header",$data);
        foreach($buttonList as $v){
            $params = [];
            $price = isset($this->typeParams[$this->type]["price"]) ? $this->typeParams[$this->type]["price"] : "-1";
            $count = isset($this->typeParams[$this->type]["count"]) ? $this->typeParams[$this->type]["count"] : "-1";
            foreach($this->tableButtonParams[$v] as $k => $v){
                ($k != "onclick") ? $params[$k] = $v : $params[$k] = "{$v}('{$this->win_id}',{$price},{$count})";
            }
            $this->view->show("tableButtonBlock.button", $params);
        }
        $this->view->show("tableButtonBlock.footer");
    }
    
    
    /*--------------------------------------------------*/
    
    
    private function showButtonBlock(
            $buttonList
    ){
        $data = [
            "style" => "width: 100%"
        ];
        $this->view->show("buttonBlock.header",$data);
        foreach($buttonList as $v){
            $params = [];
            foreach($this->buttonParams[$v] as $k => $v){
                ($k != "onclick") ? $params[$k] = $v : $params[$k] = "{$v}({$this->win_id},{$this->typeParams[$this->type]["account"]})";
            }
            $this->view->show("buttonBlock.button", $params);
        }
        $this->view->show("buttonBlock.footer");
    }
    
    
    /*--------------------------------------------------*/
    
    private function showNew(){
        
        $this->view->show("header",$data);
        $this->view->show("docHeader.header", $data);
        $dateData = [
            "id" => "timeStamp",
            "label" => "����",
            "type" => "datetime-local",
            
        ];
        
        $headerParams = $this->typeParams[$this->type];
        $dateData["style"] = "width: 100%";
        $dateData["value"] = date("Y-m-d\TH:i",time());
        if (isset($this->typeParams[$this->type]["noTime"])){
            $dateData["disabled"] = "disabled";
        }
        $this->showInputBlock($dateData);
        
//        $buf = \Subcount::getSubcountList($headerParams["srcType"], true);
//        $ar = [];
//        foreach($buf as $k => $v){
//            $ar[] = [
//                "name" => $v["name"],
//                "value" => $v["id"]
//            ];
//        }
//        $this->showSelectBlock("src", $headerParams["srcName"], $ar, "width: auto");
        $this->showSelectFormBlock("src", $headerParams["srcName"], $headerParams["srcType"], "width: auto");
//        $buf = \Subcount::getSubcountList($headerParams["dstType"], true);
//        $ar = [];
//        foreach($buf as $k => $v){
//            $ar[] = [
//                "name" => $v["name"],
//                "value" => $v["id"]
//            ];
//        }
//        $this->showSelectBlock("dst", $headerParams["dstName"], $ar, "width: 30%");
        $this->showSelectFormBlock("dst", $headerParams["dstName"], $headerParams["dstType"], "width: 30%");
        
        $commentList = $headerParams["commentList"];
        foreach($commentList as $key => $value){
            if ($value["type"] == "textArea"){
                $data = [
                    "id" => "comment_{$key}",
                    "label" => $value["name"],
                    "type" => "text",
                    "style" => "width: 100%; margin-right: 15px;",
                    "styleInput" => "width: 100%"
                ];
                $this->showTextBlock($data);
            }
            else{
                $data = [
                    "id" => "comment_{$key}",
                    "label" => $value["name"],
                    "type" => $value["type"],
                    "style" => "width: 30%;",
                    "styleInput" => "width: 100%",
                    "class" => "docComment"
                ];
                $this->showInputBlock($data);
            }
            
                
        }
        
        $buttonList = [
            "addRow",
            "clearTable"
        ];
        
        $this->showTableButtonBlock($buttonList);
        $this->view->show("docHeader.footer");
        $data = [
            "win_id" => $this->win_id
        ];
        $this->view->show("table.header",$data);
        $this->view->show("table.footer");
        $buttonList = [
            "saveRun"
        ];
        $this->showButtonBlock($buttonList);
        $this->view->show("footer");
        $buf = \Subcount::getSubcountList("material", false);
        $materials = [];
        $units = [];
        foreach($buf as $value){
            $materials[$value["id"]] = $value["name"];
        }
        foreach($buf as $value){
            $units[$value["id"]] = $value["units"];
        }
        $data = [
            "units" => $units,
            "type" => $this->type,
            "tableType" => $this->typeParams[$this->type]["tableType"]
        ];
        if (isset($this->typeParams[$this->type]["tableDepend"])){
            
            $data["tableDepend"] = $this->typeParams[$this->type]["tableDepend"];
        }
        $dec = new \Decoder();
        $str = $dec->arrayToStr($data);
        $data = [
            "data" => $str,
            "win_id" => $this->win_id
        ];
        $this->view->show("vars", $data);
        
        
    }
    
    /*--------------------------------------------------*/
    
    
    private function showOld(){
        $disabled = "disabled";
        $doc = new \Document($this->id);
        $submitList = $doc->getSubmitList();
        if (count_u($submitList) != 0){
            $submit = "<a style='color:red;font-size:15px; margin-left: 10px;' onclick='event.preventDefault(); showSubmitList(`{$this->id}`)' href='#'>(�� �����������)</a>";
        }
        else{
            $submit = "<span style='color:green;font-size:15px; margin-left: 10px;'> (�����������)</span>";
        }
        $executed = ($doc->isExecuted()) ? "<span style='color:green;font-size:15px; margin-left: 10px;'> (��������)</span>" : "<span style='color:red;font-size:15px; margin-left: 10px;'> (�� ��������)</span>";
        $headerParams = $this->typeParams[$this->type];
        $data = [
            "title" => $this->typeParams[$this->type]["name"]. $executed. $submit
        ];
        if ($this->print){
            $this->view->show("headerPrint",$data);
        }
        else{
            $this->view->show("header",$data);
        }
        
        $this->view->show("docHeader.header", $data);
        $dateData = [
            "id" => "timeStamp",
            "label" => "����",
            "type" => "datetime-local",
            "disabled" => $disabled
        ];
        
        $dateData["style"] = "width: 30%;". $disabled;
        $dateData["value"] = date("Y-m-d\TH:i",$this->header["timeStamp"]);
        $this->showInputBlock($dateData);
        $data = [
            "id" => "id",
            "label" => "�����",
            "type" => "text",
            "value" => $this->id,
            "style" => "width: 30%;",
            "disabled" => $disabled
        ];
        $this->showInputBlock($data);
        $data = [
            "id" => "author_{$this->win_id}",
            "label" => "�����",
            "type" => "text",
            "value" => $this->header["authorName"],
            "style" => "width: 30%;",
            "disabled" => $disabled
        ];
        $this->showInputBlock($data);
        
        $data = [
            "id" => "src",
            "label" => $headerParams["srcName"],
            "type" => "text",
            "value" => $this->header["srcName"],
            "onclick" => "showSubcountForm('{$this->header['src']}')",
            "style" => "width: 30%;",
            "styleInput" => "cursor: pointer",
            "disabled" => "readonly"
        ];
        $this->showInputBlock($data);
        $data = [
            "id" => "dst",
            "label" => $headerParams["dstName"],
            "type" => "text",
            "value" => $this->header["dstName"],
            "onclick" => "showSubcountForm('{$this->header['dst']}')",
            "style" => "width: 30%;",
            "styleInput" => "cursor: pointer",
            "disabled" => "readonly"
        ];
        $this->showInputBlock($data);
        
        if (!$this->print){
            $commentList = $headerParams["commentList"];
            foreach($commentList as $key => $value){
                if ($value["type"] == "textArea"){
                    $data = [
                        "id" => "comment_{$key}",
                        "label" => $value["name"],
                        "type" => "text",
                        "style" => "width: 100%; margin-right: 15px;",
                        "styleInput" => "width: 100%",
                        "disabled" => "readonly",
                        "value" => isset($this->comment[$key]) ? $this->comment[$key] : ""
                    ];
                    $this->showTextBlock($data);
                }
                else{
                    if ($this->comment[$key]){
                        $checked = "checked";
                    }
                    else{
                        $checked = "";
                    }
                    $data = [
                        "id" => "comment_{$key}",
                        "label" => $value["name"],
                        "type" => $value["type"],
                        "style" => "width: 30%;",
                        "styleInput" => "width: 100%; resize: none;",
                        "class" => "docComment",
                        "disabled" => "readonly",
                        "value" => isset($this->comment[$key]) ? $this->comment[$key] : "",
                        "checked" => $checked
                    ];
                    $this->showInputBlock($data);
                }


            }
        }
        else if((isset($this->comment["comment"])) && ($this->comment["comment"])){
            $key = "comment";
            $data = [
                "id" => "comment_{$key}",
                "label" => "�����������",
                "type" => "text",
                "style" => "width: 100%; margin-right: 15px;",
                "styleInput" => "width: 100%; resize: none;",
                "disabled" => "readonly",
                "value" => isset($this->comment[$key]) ? $this->comment[$key] : ""
            ];
            $this->showTextBlock($data);
        }
        $this->showTableButtonBlock([]);
        $this->view->show("docHeader.footer");
        $this->view->show("table.headerOld");
        foreach($this->table as $t){
            $data = [
                "class" => "hoverable"
            ];
            $this->view->show("table.row.header",$data);
            $sub = new \subCount($t[0]);
            $onclick = "showSubcountForm(`{$t[0]}`)";
            $t[0] = $sub->getName();
            foreach ($t as  $k => $value){
                if ($k > 0){
                    $style = ";text-align: right;padding-right: 5px";
                }
                else{
                    $style = "";
                }
                $data = [
                    "type" => "text",
                    "value" => $value,
                    "style" => $style,
                    "disabled" => $disabled,
                    "onclick" => $onclick
                ];
                $this->view->show("table.cell.header",$data);
                
                $this->view->show("table.cell.inputOld", $data);
                $this->view->show("table.cell.footer");
                
            }
            $this->view->show("table.row.footer");
        }
        $this->view->show("table.footer");
        if (!$this->print){
            $buttonList = [];
            $doc = new \Document($this->id);
            if (count_u($submitList) > 0){
                $profile = $_COOKIE["login"];
                if (key_exists($profile, $submitList)){
                    $buttonList[] = "submit";
                }
            }
            if (($doc->isExecuted()) && (getAccessLevel() == "1")){
                $buttonList[] = "unexecute";
            }
            else{
                $profile = $_COOKIE["login"];
                $author = $doc->getHeader()["author"];
                $list = getSubordinateList($profile);
                $list[] = $profile;
                if ((getAccessLevel() == "1")){
                    $buttonList[] = "delete";
                }
                if ((in_array($author, $list)) || (getAccessLevel() == "1")){
                    $buttonList[] = "execute";
                }
            }
            $buttonList[] = "print";
        }
        else{
            $this->view->show("printFooter.header");
            if (isset($this->typeParams[$this->type]["footer"])){
                foreach($this->typeParams[$this->type]["footer"] as $value){
                    switch($value["type"]):
                        case "none":
                            $data = [
                                "name" => $value["name"]
                            ];
                            $this->view->show("printFooter.data", $data);
                            break;
                        case "author":
                            $data = [
                                "name" => $value["name"],
                                "value" => $this->header["authorName"]
                            ];
                            $this->view->show("printFooter.data", $data);
                            break;
                        default:
                            $subcount = new \subCount($this->header[$value["type"]]);
                            if ($value["value"] == "name"){
                                $val = $subcount->getName();
                            }
                            else{
                                $val = $subcount->getShow($value["value"]);
                            }
                            $data = [
                                "name" => $value["name"],
                                "value" => $val
                            ];
                            $this->view->show("printFooter.data", $data);
                            break;
                    endswitch;
                }
            }
            $this->view->show("printFooter.footer");
            $buttonList = [];
        }
        $this->showButtonBlock($buttonList);
        $this->view->show("footer");
        
    }
    
    
    /*--------------------------------------------------*/
    
    public function show(){
        if ($this->new){
            $this->showNew();
        }
        else{
            $this->showOld();
        }
        
    }
    
    
    /*--------------------------------------------------*/
    
    
    public function showHorizontal(){
        
        
        
        
        $data = [
            "title" => $this->typeParams[$this->type]["name"],
            "styleMain" => "flex-direction: row; height: auto",
            "styleTitle" => "border-bottom: 1px #444 dotted; padding-bottom: 10px;"
        ];
        $this->view->show("headerHorizontal",$data);
        $data = [
            "style" => "width: 300px"
        ];
        $this->view->show("docHeader.header", $data);
        $dateData = [
            "id" => "timeStamp",
            "label" => "����",
            "type" => "datetime-local",
            
        ];
        
        $headerParams = $this->typeParams[$this->type];
        $dateData["style"] = "width: 100%";
        $dateData["value"] = date("Y-m-d\TH:i",time());
        if (isset($this->typeParams[$this->type]["noTime"])){
            $dateData["disabled"] = "disabled";
        }
        $this->showInputBlock($dateData);
//        $buf = \Subcount::getSubcountList($headerParams["srcType"], true);
//        $ar = [];
//        foreach($buf as $k => $v){
//            $ar[] = [
//                "name" => $v["name"],
//                "value" => $v["id"]
//            ];
//        }
//        $this->showSelectBlock("src", $headerParams["srcName"], $ar, "width: auto");
        $this->showSelectFormBlock("src", $headerParams["srcName"], $headerParams["srcType"], "width: 100%");
//        $buf = \Subcount::getSubcountList($headerParams["dstType"], true);
//        $ar = [];
//        foreach($buf as $k => $v){
//            $ar[] = [
//                "name" => $v["name"],
//                "value" => $v["id"]
//            ];
//        }
//        $this->showSelectBlock("dst", $headerParams["dstName"], $ar, "width: 30%");
        $this->showSelectFormBlock("dst", $headerParams["dstName"], $headerParams["dstType"], "width: 100%");
        $commentList = $headerParams["commentList"];
        foreach($commentList as $key => $value){
            if ($value["type"] == "textArea"){
                $data = [
                    "id" => "comment_{$key}",
                    "label" => $value["name"],
                    "type" => "text",
                    "style" => "width: 100%; margin-right: 15px;",
                    "styleInput" => "width: 100%"
                ];
                $this->showTextBlock($data);
            }
            else{
                $data = [
                    "id" => "comment_{$key}",
                    "label" => $value["name"],
                    "type" => $value["type"],
                    "style" => "width: 100%;",
                    "styleInput" => "width: 100%",
                    "class" => "docComment"
                ];
                $this->showInputBlock($data);
            }
            
                
        }
        $buttonList = [
            "saveRun"
        ];
        $this->showButtonBlock($buttonList);
        $this->view->show("docHeader.footer");
        $data = [
            "win_id" => $this->win_id
        ];
        $this->view->show("tableBox.header");
        $buttonList = [
            "addRowTest",
            "clearTable"
        ];
        
        
    
        
        $style = "justify-content: flex-start;"
                . "padding-left: 15px;";
        $this->showTableButtonBlock($buttonList,$style);
        $this->view->show("table.header",$data);
        $this->view->show("table.footer");
        $this->view->show("tableBox.footer");
        $this->view->show("footer");
        $buf = \Subcount::getSubcountList("material", false);
        $materials = [];
        $units = [];
        foreach($buf as $value){
            $materials[$value["id"]] = $value["name"];
        }
        foreach($buf as $value){
            $units[$value["id"]] = $value["units"];
        }
        $data = [
            "units" => $units,
            "type" => $this->type,
            "tableType" => $this->typeParams[$this->type]["tableType"]
        ];
        if (isset($this->typeParams[$this->type]["tableDepend"])){
            
            $data["tableDepend"] = $this->typeParams[$this->type]["tableDepend"];
        }
        $dec = new \Decoder();
        $str = $dec->arrayToStr($data);
        $data = [
            "data" => $str,
            "win_id" => $this->win_id
        ];
        $this->view->show("vars", $data);
        
        
    }
    
    
    /*--------------------------------------------------*/
    
    
}






/*--------------------------------------------------*/
/*--------------------------------------------------*/
/*--------------------------------------------------*/


?>