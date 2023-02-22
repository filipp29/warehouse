<?php
    $_SERVER['DOCUMENT_ROOT'] = '/var/htdocs/wotom.net';
    ini_set('error_reporting', E_ERROR);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 0);
    ini_set('memory_limit', '512M'); 
    set_time_limit(600);
    require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php');
    require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libSwitches.php');
    require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libProfiles.php');
    require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libMsg.php');
    require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libCity.php');

    
    /*--------------------------------------------------*/
    function utf(
    $str
    ){
        if (is_array($str)){
            $result = [];
            foreach ($str as $key => $value){
                $result[$key] = utf($value);
            }
            return $result;
        }
        else{
            return iconv("windows-1251", "utf-8", $str);
        }
    }

    /*--------------------------------------------------*/



    function win(
            $str
    ){
        if (is_array($str)){
            $result = [];
            foreach ($str as $key => $value){
                $result[$key] = win($value);
            }

            return $result;
        }
        else{
            return iconv("utf-8", "windows-1251", $str);
        }

}
    
    
    /*--------------------------------------------------*/
    
    function getResult(
            $ar,
            $type
    ){
        global $nameList;
        global $formList;
        global $cssList;
        $result = [];
        foreach($ar as $key => $value){
            $result[$key] = [];
            $result[$key]["name"] = $nameList[$key];
            if (is_array($value)){
                $result[$key]["list"] = getResult($value,$type);
            }
            else{
                $result[$key]["list"] = [];
                foreach($formList[$type] as $k => $v){
                    $buf = [];
                    $buf["name"] = $nameList[$k];
                    $buf["file"] = $v;
                    $buf["css"] = $cssList[$type][$k];
                    $buf["type"] = $value;
                    $result[$key]["list"][$k] = $buf;
                }
            }
        }
        return $result;
    }
    
    /*--------------------------------------------------*/
    
//    $accessList = [
//        "document" => [
//            "level" => "2",
//            "list" => [
//                "income" => [
//                    "level" => "2",
//                    "list" => [
//                        "contractor" => [
//                            "level" => "1"
//                        ],
//                        "worker" => [
//                            "level" => "2"
//                        ]
//                    ]
//                ],
//                "expense" => [
//                    "level" => "2",
//                    "list" => [
//                        "warehouse" => [
//                            "level" => "2"
//                        ],
//                        "worker" => [
//                            "level" => "2"
//                        ]
//                    ]
//                ],
//                "transfer" => [
//                    "level" => "2",
//                    "list" => [
//                        "store" => [
//                            "level" => "2"
//                        ]
//                    ]
//                ],
//                "giving" => [
//                    "level" => "2",
//                    "list" => [
//                        "worker" => [
//                            "level" => "2"
//                        ]
//                    ]
//                ]
//            ]
//        ],
//        "report" => [
//            "level" => 
//        ]
//    ];
    
    
    
    $accessMenu = [
        "document" => "2",
        "report" => "2",
        "subcount" => "1"
    ];
    
    
    $accessSubmenu = [
        "document" => [
            "income" => [
                "level" => "2"
            ],
            "transfer" => [
                "level" => "2"
            ],
            "giving" => [
                "level" => "2"
            ],
            "expense" => [
                "level" => "2"
            ]
        ],
        "report" => [
            "warehouse" => [
                "level" => "1"
            ],
            "contractor" => [
                "level" => "1"
            ],
            "profile" => [
                "level" => "2"
            ],
            "material" => [
                "level" => "1"
            ]
        ],
        "subcount" => [
            "material" => [
                "level" => "1"
            ],
            "contractor" => [
                "level" => "1"
            ],
            "warehouse" => [
                "level" => "1"
            ],
            "profile" => [
                "level" => "1"
            ],
            "object" => [
                "level" => "1"
            ]
        ]
    ];
    
    
    $keyList = [
        "document" => [
            "income" => [
                "contractor" => "income",
                "worker" => "fromWorker",
            ],
            
            "transfer" => [
                "store" => "transfer"
            ],
            "giving" => [
                "worker" => "toWorker"
            ],
            "expense" => [
                "worker" => "expenseWorker",
                "store" => "expense",
            ],
            
        ],
        "report" => [
            "warehouse" => [
                "material" => "warehouse-material",
                "list" => "warehouse-list",
            ],
            "contractor" => [
                "material" => "contractor-material"
            ],
            "profile" => [
                "material" => "profile-material",
                "contractor" => "profile-contractor"
            ],
            "material" => [
                "warehouse" => "material-warehouse"
            ]
        ],
        "subcount" => [
            "material" => "material",
            "contractor" => "contractor",
            "warehouse" => "warehouse",
            "profile" => "profile",
            "object" => "object"
        ],
        
        /*--------------------------------------------------*/
        
        
        "asset_document" => [
            "asset_income" => [
                "contractor" => "asset_income",
                "worker" => "asset_fromWorker",
            ],
            "asset_expense" => [
                "worker" => "asset_expenseWorker",
                "store" => "asset_expense",
            ],
            "asset_transfer" => [
                "store" => "asset_transfer"
            ],
            "asset_giving" => [
                "worker" => "asset_toWorker"
            ],
            "asset_install" => [
                "worker" => "asset_installWorker",
                "warehouse" => "asset_install"
            ]
        ],
        "asset_report" => [
            "asset_warehouse" => [
                "asset" => "warehouse-asset"
            ],
            "asset_contractor" => [
                "asset" => "contractor-asset"
            ],
            "asset_profile" => [
                "asset" => "profile-asset",
            ],
            "asset_object" => [
                "asset" => "object-asset"
            ]
        ],
        
        "asset_subcount" => [
            "asset" => "asset"
        ]
        
        
        
            
    ];
    $nameList = [
        "document" => "Документ",
        "income" => "Приход",
        "expense" => "Расход",
        "transfer" => "Перемещение",
        "report" => "Отчет",
        "giving" => "Выдача",
        "makeReport" => "Сформировать отчет",
        "subcount" => "Справочник",
        "list" => "Список",
        /*--------------------------------------------------*/
        
        "asset_document" => "Документ ОС",
        "asset_income" => "Приход ОС",
        "asset_expense" => "Расход ОС",
        "asset_transfer" => "Перемещение ОС",
        "asset_report" => "Отчет ОС",
        "asset_giving" => "Выдача ОС",
        
        /*--------------------------------------------------*/
        "contractor" => "Контрагент",
        "worker" => "Сотрудник",
        "store" => "Склад",
        "profile" => "Сотрудник",
        "warehouse" => "Склад",
        "contractor" => "Контрагент",
        "material" => "Материал",
        "object" => "Объект",
        
        /*--------------------------------------------------*/
        
        "asset_contractor" => "Контрагент",
        "asset_worker" => "Сотрудник",
        "asset_store" => "Склад",
        "asset_profile" => "Сотрудник",
        "asset_warehouse" => "Склад",
        "asset_contractor" => "Контрагент",
        "asset_material" => "Материал",
        "asset_object" => "Объект",
        "asset" => "ОС",
        
        /*--------------------------------------------------*/
        "create" => "Создать",
        "journal" => "Журнал"
    ];
    $formList = [
        "document" => [
            "create" => "get_newDoc_form.php",
            "journal" => "get_journal_form.php"
        ],
        "report" => [
            "makeReport" => "get_report_form.php"
        ],
        "subcount" => [
            "journal" => "get_subcountList_form.php"
        ],
        
        
        /*--------------------------------------------------*/
        
        "asset_document" => [
            "create" => "get_newDoc_form.php",
            "journal" => "get_journal_form.php"
        ],
        "asset_report" => [
            "makeReport" => "get_report_form.php"
        ],
        "asset_subcount" => [
            "create" => "create_asset_form.php",
            "journal" => "get_subcountList_form.php"
        ]
        
        
    ];
    $cssList = [
        "document" => [
            "create" => "DocumentView",
            "journal" => "JournalView"
        ],
        "report" => [
            "makeReport" => "ReportView"
        ],
        "subcount" => [
            "journal" => "subcountListForm"
        ],
        /*--------------------------------------------------*/
        
        "asset_document" => [
            "create" => "DocumentView",
            "journal" => "JournalView"
        ],
        "asset_report" => [
            "makeReport" => "ReportView"
        ],
        "asset_subcount" => [
            "create" => "createAssetForm",
            "journal" => "subcountListForm"
        ]
        
    ];
    
    $result = [];
    echo "<pre>";
    foreach($keyList as $key => $value){
        $result[$key]["name"] = $nameList[$key];
        $result[$key]["list"] = getResult($value, $key);
    }
    
    
    foreach($result as $key => $value){
        $result[$key]["level"] = $accessMenu[$key];
        foreach($value["list"] as $k => $v){
            $result[$key]["list"][$k]["level"] = $accessSubmenu[$key][$k]["level"];
        }
    }
    
    
    /*Исключения!!!--------------------------------------------------*/
    
    
    /*--------------------------------------------------*/
    
    
    print_r($result);
    echo "</pre>";
    $json = json_encode(utf($result),256);
    file_put_contents($_SERVER['DOCUMENT_ROOT']."/_FDB/ware/settings/menuTreeCommon.json", $json);
    
    echo $_SERVER['DOCUMENT_ROOT']."/_FDB/ware/settings/menuTreeCommon.json". "!!!!!!!!<br>";
    
    
    
    
            