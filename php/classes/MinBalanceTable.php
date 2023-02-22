<?php


$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //Подключаем библиотеку для работы с БД
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';

error_reporting(E_ALL); //Включаем вывод ошибок
set_time_limit(600); //Устанавливаем максимальное время работы скрипта в секундах
ini_set('display_errors', 1); //Еще один вывод ошибок
ini_set('memory_limit', '512M'); //Устанавливаем ограничение памяти на скрипт (512Мб)


class MinBalanceTable {
    static private $path = "/ware//minBalanceTable/table.tbl";
    static private $org = "";
    
    /*--------------------------------------------------*/
    
    static public function setOrg(
            $org
    ){
        self::$path = "/ware/{$org}/minBalanceTable/table.tbl";
    }
    
    /*--------------------------------------------------*/
    
    static public function add(
            $subcount1,
            $subcount2,
            $count
    ){
        $obj = objLoad(self::$path);
        foreach($obj as $key => $value){
            $buf = explode("_",$value);
            if (($subcount1 == $buf[0]) && ($subcount2 == $buf[1])){
                $buf[2] = $count;
                $obj[$key] = implode("_", $buf);
                objSave(self::$path, "raw", $obj);
                return 2;
            }
        }
        $buf = [
            $subcount1,
            $subcount2,
            $count
        ];
        $obj[] = implode("_", $buf);
        objSave(self::$path, "raw", $obj);
        return 1;
    }
    
    /*--------------------------------------------------*/
    
    static public function delete(
            $subcount1,
            $subcount2
    ){
        $obj = objLoad(self::$path);
        unset($obj["#e"]);
        foreach($obj as $key => $value){
            $buf = explode("_",$value);
            if (($subcount1 == $buf[0]) && ($subcount2 == $buf[1])){
                unset($obj[$key]);
                $obj = array_values($obj);
                objSave(self::$path, "raw", $obj);
                return 2;
            }
        }
        return 1;
    }
    
    /*--------------------------------------------------*/
    
    static public function getTable(
            $filterSubcount1 = "",
            $filterSubcount2 = ""
    ){
        $timeStamp = time();
        $date = date("Ymd", $timeStamp);
        $account = "1310";
        $byType1 = "bySubcount1";
        $byType2 = "bySubcount2";
        $obj = objLoad(self::$path);
        unset($obj["#e"]);
        $result = [];
        foreach($obj as $key => $value){
            $buf = explode("_",$value);
            if (($filterSubcount1) && ($filterSubcount1 != $buf[0])){
                continue;
            }
            if (($filterSubcount2) && ($filterSubcount2 != $buf[1])){
                continue;
            }
            $subcount1 = $buf[0];
            $subcount2 = $buf[1];
            $minCount = (int)$buf[2];
            $crt = (int)\Reports::getBalance("{$account}/{$byType1}/{$subcount1}/{$byType2}/{$subcount2}/", "crt", $date);
            $dbt = (int)\Reports::getBalance("{$account}/{$byType1}/{$subcount1}/{$byType2}/{$subcount2}/", "dbt", $date);
            $crt += (int)\Entry::getDailyBy2($timeStamp, $subcount1, $subcount2, "crt",$byType1,$byType2,$account);
            $dbt += (int)\Entry::getDailyBy2($timeStamp, $subcount1, $subcount2, "dbt",$byType1,$byType2,$account);
            $curCount = $dbt - $crt;
            $result[] = [
                "subcount1" => $subcount1,
                "subcount2" => $subcount2,
                "minCount" => $minCount,
                "curCount" => $curCount
            ];
        }
        return $result;
    }
    
    /*--------------------------------------------------*/
    
    static public function getOne(
            $subcount1,
            $subcount2
    ){
        $result = self::getTable($subcount1, $subcount2);
        return isset($result[0]["minCount"]) ? $result[0]["minCount"] : "0";
    }
    
    /*--------------------------------------------------*/
    
    
    
    
    
}
