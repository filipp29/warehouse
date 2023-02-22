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

    
    
    function show(
            $ar
    ){
        if (!is_array($ar)){
            echo " {$ar}<br>";
            return;
        }
        else{
            foreach($ar as $key => $value){
                echo "'{$key}' => ";
                if (!is_array($value)){
                    echo " '{$value}',<br>";
                }
                else {
                    echo " [<br>";
                    show($value);
                    echo "],<br>";
                }
            }
        }
    }
    
    
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
    


$json = file_get_contents($_SERVER['DOCUMENT_ROOT']. "/_modules/warehouse/settings/menuTreeCommon.json");
$data = win(json_decode($json,256));

show($data);








