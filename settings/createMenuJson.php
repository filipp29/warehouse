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
        global $accessList;
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
    
    $accessMenu = [
        "document" => "2",
        "report" => "2",
        "subcount" => "1"
    ];
    
    
    $accessSubmenu = [
        "document" => [
            "income" => [
                "level" => "1"
            ],
            "expense" => [
                "level" => "2"
            ],
            "transfer" => [
                "level" => "2"
            ],
            "giving" => [
                "level" => "2"
            ]
        ],
        "report" => [
            "warehouse" => [
                "level" => "2"
            ],
            "contractor" => [
                "level" => "1"
            ],
            "profile" => [
                "level" => "2"
            ],
            "material" => [
                "level" => "2"
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
            "expense" => [
                "worker" => "expenseWorker",
                "store" => "expense",
            ],
            "transfer" => [
                "store" => "transfer"
            ],
            "giving" => [
                "worker" => "toWorker"
            ]
        ],
        "report" => [
            "warehouse" => [
                "material" => "warehouse-material"
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
        ]
            
    ];
    $nameList = [
        "document" => "????????",
        "income" => "??????",
        "expense" => "??????",
        "transfer" => "???????????",
        "report" => "?????",
        "giving" => "??????",
        "makeReport" => "???????????? ?????",
        /*--------------------------------------------------*/
        "contractor" => "??????????",
        "worker" => "?????????",
        "store" => "?????",
        "profile" => "?????????",
        "warehouse" => "?????",
        "contractor" => "??????????",
        "material" => "????????",
        "object" => "??????",
        /*--------------------------------------------------*/
        "create" => "???????",
        "journal" => "??????"
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
            $result[$key]["list"][$k]["level"] = $accessSubenu[$key][$k]["level"];
        }
    }
    
    
    print_r($result);
    echo "</pre>";
    $json = json_encode(utf($result),256);
    file_put_contents($_SERVER['DOCUMENT_ROOT']."/_FDB/ware/settings/menuTree.json", $json);
    
    echo $_SERVER['DOCUMENT_ROOT']."/_FDB/ware/settings/menuTree.json". "!!!!!!!!<br>";
    
    
    
    
            