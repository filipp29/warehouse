<?php

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //Подключаем библиотеку для работы с БД

require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';

date_default_timezone_set("Asia/Almaty");

class Request {
    
    static private $path = "/ware/default/request/";
    
    /*--------------------------------------------------*/
     
    
    static public function create(
            $warehouse,
            $material,
            $count
    ){
        $br = array_keys(objLoadBranch(self::$path, true, false));
        foreach($br as $value){
            $buf = explode("_", $value);
            if ($buf[1] == $warehouse){
                $obj = objLoad(self::$path. $value);
                if ($obj["materialId"] == $material){
                    return 1;
                }
            }
        }
        $result = [];
        $sub = new \Subcount($material);
        $result["materialId"] = $material;
        $result["materialName"] = $sub->getName();
        $sub = new \subCount($warehouse);
        $result["warehouseId"] = $warehouse;
        $result["warehouseName"] = $sub->getName();
        $result["author"] = $_COOKIE["login"];
        $result["timeStamp"] = time();
        $result["submit"] = "0";
        $result["count"] = $count;
        objSave(self::$path. time(). "_{$warehouse}", "raw", $result);
        return 0;
    }
    
    
    /*--------------------------------------------------*/
    
    static public function delete(
            $warehouse,
            $material
    ){
        
        $br = array_keys(objLoadBranch(self::$path, true, false));
        foreach($br as $value){
            $buf = explode("_", $value);
            if ($buf[1] == $warehouse){
                $obj = objLoad(self::$path. $value);
                if ($obj["materialId"] == $material){
                    objKill(self::$path.$value);
                    objSave(self::$path. "deleted/{$value}", "raw", $obj);
                    return 0;
                }
            }
        }
        return 1;
    }
    
    /*--------------------------------------------------*/
    
    static public function submit(
            $warehouse,
            $material
    ){
        
        $br = array_keys(objLoadBranch(self::$path, true, false));
        foreach($br as $value){
            $buf = explode("_", $value);
            if ($buf[1] == $warehouse){
                
                $obj = objLoad(self::$path. $value);
                if ($obj["materialId"] == $material){
                    $obj["submit"] = "1";
                    objSave(self::$path. "{$value}", "raw", $obj);
                    return 0;
                }
            }
        }
        return 1;
    }
    
    /*--------------------------------------------------*/
    
    
    
    static public function getTable(){
        $br = array_keys(objLoadBranch(self::$path, true, false));
        $result = [];
        foreach($br as $value){
            $obj = objLoad(self::$path.$value);
            unset($obj["#e"]);
            $result[] = $obj;
        }
        return $result;
    }
    
    /*--------------------------------------------------*/
    
    static public function setOrg(
            $org
    ){
        self::$path = "/ware/{$org}/request/";
    }
    
    /*--------------------------------------------------*/
}
