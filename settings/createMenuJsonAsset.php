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
    
    
    $keyList = [
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
        "asset_income" => "?????? ??",
        "asset_expense" => "?????? ??",
        "asset_transfer" => "??????????? ??",
        "report" => "?????",
        "asset_giving" => "?????? ??",
        "makeReport" => "???????????? ?????",
        "asset_install" => "????????? ??",
        /*--------------------------------------------------*/
        "contractor" => "??????????",
        "worker" => "?????????",
        "store" => "?????",
        "profile" => "?????????",
        "warehouse" => "?????",
        "contractor" => "??????????",
        "material" => "????????",
        "object" => "??????",
        "asset" => "??",
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
    
    
    print_r($result);
    echo "</pre>";
    $json = json_encode(utf($result),256);
    file_put_contents($_SERVER['DOCUMENT_ROOT']."/_FDB/ware/settings/menuTreeAsset.json", $json);
    
    echo $_SERVER['DOCUMENT_ROOT']."/_FDB/ware/settings/menuTreeAsset.json". "!!!!!!!!<br>";
    
    
    
    
            