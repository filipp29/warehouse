<?php

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //Подключаем библиотеку для работы с БД

require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';






/*--------------------------------------------------*/
/*
 * 
 * Класс для работы с отчетами по складу ТМЦ.
 * 
 * 
 * ---------------------------------------------------
 * Атрибуты-------------------------------------------
 * 
 * 
 * ---------------------------------------------------
 * Статические методы---------------------------------
 * 
 * setBalance(id, params) - метод для установки остатков по стчетам. Вызывается из 
 *      класса entry. id - номер проводки(entry.id) params - параметры проводки.
 *      Автоматически корректирует остатки по счетам за каждый день. Если проводка за
 *      текущий день помещает ее в каталог current соответствующего счета для последующего
 *      формирования остатков на конец дня. Остатки хранятся в виде дебета и кредита соответствующего счета
 * 
 * getBalance(path, type, date) - метод возвращает остаток по счету на начало дня date.
 *      path - путь к счету вида "/account/subcount1/subcount2/" где account - номер 
 *      счета(в текущей версии есть только счет 1310) subcount1 и subcount2 соответственно субконто1 и субконто2
 *      (могут быть как оба субконто так и только один из них). 
 *      type - тип счета "dbt" - дебет "crt" - кредит
 *      date - дата в виде "YYmmdd"
 * 
 * calcCurrentBalance() - метод переводит текущие проводки из папки current в остатки
 *      
 *      
 * 
 * 
 * --------------------------------------------------*/







class Reports {
    
    static private $path = "/ware/default/reports/";
    static private $count;
    static private $id;
    
    
    
    
    /*--------------------------------------------------*/
    
    static public function setOrg(
            $org
    ){
        self::$path = "/ware/{$org}/reports/";
    }
    
    /*--------------------------------------------------*/
    
    
    static private function setSubBalance(
            $path,
            $id,
            $count
    ){
        $timeStamp = explode(".", $id)[0];
        $date = date("Ymd",$timeStamp);
        $br = array_keys(objLoadBranch($path, true, false));
        rsort($br);
        $start = new DateTime(date("Y-m-d",$timeStamp));
        $end = new DateTime(date("Y-m-d",time()));
        $end->add(new DateInterval('P1D'));
        $int = new DateInterval("P1D");
        $period = new DatePeriod($start, $int, $end);
        $today = $end->format("Ymd");
        foreach($period as $v){
            $el = $v->format("Ymd");
            if (((int)$el >= (int)$date)/* && ((int)$el < (int)$today)*/){
                $obj = objLoad($path. "{$el}");
//                print_u($obj);
                $obj["count"] = isset($obj["count"]) ? (int)$obj["count"] + (int)$count : (int)$count;
                objSave($path. "{$el}", "raw", $obj);
            }
            
        }
//        if ((int)$date == (int)$today){
//            $obj = objLoad($path. "current/{$id}");
//            $obj["count"] = isset($obj["count"]) ? (int)$obj["count"] + (int)$count : (int)$count;
//            objSave($path. "current/{$id}", "raw", $obj);
//        }
    }
    
    
    /*--------------------------------------------------*/
    
    
    static public function setBalance(
            $id,
            $params
//            $id,
//            $account,
//            $src,
//            $dst,
//            $material,
//            $count
    ){
        extract($params);
        self::$count = $count;
        $pathCrt1 = self::$path. "{$account}/bySubcount1/{$src}/bySubcount2/{$material}/crt/";
        self::setZero($pathCrt1);
        self::setSubBalance($pathCrt1,$id,(int)$count);
        
        $pathDbt1 = self::$path. "{$account}/bySubcount1/{$dst}/bySubcount2/{$material}/dbt/";
        self::setZero($pathDbt1);
        self::setSubBalance($pathDbt1,$id,(int)$count);
        
        $pathCrt1 = self::$path. "{$account}/bySubcount1/{$src}/bySubcount1/{$dst}/bySubcount2/{$material}/crt/";
        self::setZero($pathCrt1);
        self::setSubBalance($pathCrt1,$id,(int)$count);
        
        $pathDbt1 = self::$path. "{$account}/bySubcount1/{$dst}/bySubcount1/{$src}/bySubcount2/{$material}/dbt/";
        self::setZero($pathDbt1);
        self::setSubBalance($pathDbt1,$id,(int)$count);

        $pathCrt2 = self::$path. "{$account}/bySubcount2/{$material}/bySubcount1/{$src}/crt/";
        self::setZero($pathCrt2);
        self::setSubBalance($pathCrt2,$id,(int)$count);
        
        $pathDbt2 = self::$path. "{$account}/bySubcount2/{$material}/bySubcount1/{$dst}/dbt/";
        self::setZero($pathDbt2);
        self::setSubBalance($pathDbt2,$id,(int)$count);
    }
    
    /*--------------------------------------------------*/
    
    
    static public function getBalance(
            $path,
            $type,
            $date
    ){
        
        $br = array_keys(objLoadBranch(self::$path.$path, false, true));
        
        $result = 0;
        if (in_array($type, $br)){
//            $obj = objLoad(self::$path.$path. "{$type}/{$date}", "raw");
//            $result = (int)$obj["count"];
            $dateList = array_keys(objLoadBranch(self::$path.$path. "{$type}/", true, false));
            rsort($dateList);
            $i=0;
            if (is_array($dateList)){
                $bufCount = count_u($dateList);
            }
            else{
                $bufCount = 0;
            }
            if ($bufCount > 0){
                
                while($dateList[$i] >= $date){
                    $i++;
                    if ($i >= $bufCount){
                        break;
                    }
                }
                isset($dateList[$i]) ? $obj = objLoad(self::$path.$path. "{$type}/{$dateList[$i]}", "raw") : $obj = [];
                
                isset($obj["count"]) ? $balance = (int)$obj["count"] : $balance = 0;
            }
            else{
                $balance = 0;
            }
            return $balance;
        }
        else{
            $result = 0;
            foreach($br as $value){
                $result += self::getBalance($path. "{$value}/", $type, $date);
                
            }
        }
        return $result;
    }
    
    
    
    /*--------------------------------------------------*/
    
    
    static private function setZero(
            $path
    ){
        $br = array_keys(objLoadBranch($path, true, false));
        if (is_array($br)){
            $bufCount = count_u($br);
        }
        else{
            $bufCount = 0;
        }
        if ($bufCount == 0){
            return;
        }
        rsort($br);
        $date = $br[0];
        $count = objLoad($path. $date, "raw")["count"];
        $time = substr($date, 0, 4)."-".substr($date, 4, 2)."-".substr($date, 6, 2);
        $start = new DateTime($time);
        $end = new DateTime(date("Y-m-d",time()));
        $end->add(new DateInterval('P1D'));
        $int = new DateInterval("P1D");
        $period = new DatePeriod($start, $int, $end);
        $today = $end->format("Ymd");
        foreach($period as $v){
            $el = $v->format("Ymd");
            
            if (((int)$el > (int)$date) /*&& ((int)$el < (int)$today)*/){
                $obj = objLoad($path. "{$el}");
                if (!isset($obj["count"])){
                    $obj["count"] = (int)$count;
                    objSave($path. "{$el}", "raw", $obj);
                }
                
            }
            
        }
    }
    
    
    /*--------------------------------------------------*/
    
    
    static public function calcCurrentBalance_old(){
        
        $accountList = array_keys(objLoadBranch(self::$path, false, true));
        $date = date("Ymd",time());
        foreach($accountList as $account){
            $byTypeList1 = array_keys(objLoadBranch(self::$path. "{$account}/", false, true));
            foreach($byTypeList1 as $byType1){
                $subcount1List = array_keys(objLoadBranch(self::$path. "{$account}/{$byType1}/", false, true));
                foreach($subcount1List as $subcount1){
                    $byTypeList2 = array_keys(objLoadBranch(self::$path. "{$account}/{$byType1}/{$subcount1}/", false, true));
                    foreach($byTypeList2 as $byType2){
                        
                        $subcount2List = array_keys(objLoadBranch(self::$path. "{$account}/{$byType1}/{$subcount1}/{$byType2}/", false, true));
                        foreach($subcount2List as $subcount2){
                            $path = self::$path. "{$account}/{$byType1}/{$subcount1}/{$byType2}/{$subcount2}/dbt/";
                            self::setZero($path);

                            $br = array_keys(objLoadBranch($path. "current/", true, false));
                            foreach($br as $id){
                                if (date("Ymd",$id) == $date){
                                    continue;
                                }
                                $obj = objLoad($path. "current/{$id}","raw");
//                                echo $path. "current/{$id} - {$obj['count']}\n";
                                self::setSubBalance($path, $id, $obj["count"]);
                                objKill($path. "current/{$id}");
                            }
                            $path = self::$path. "{$account}/{$byType1}/{$subcount1}/{$byType2}/{$subcount2}/crt/";
                            self::setZero($path);
                            $br = array_keys(objLoadBranch($path. "current/", true, false));
//                            echo $path. "\n";
                            foreach($br as $id){
                                if (date("Ymd",$id) == $date){
                                    continue;
                                }
                                $obj = objLoad($path. "current/{$id}","raw");
//                                echo $path. "current/{$id} - {$obj['count']}\n";
                                
                                self::setSubBalance($path, $id, $obj["count"]);
                                objKill($path. "current/{$id}");
                            }
                        }
                    
                    }
                    
                }
            }
        }
    }
    
    
    /*--------------------------------------------------*/
    
    
    
    static public function calcCurrentBalance(
            $path = null
    ){
        if (!$path){
            $path = self::$path;
        }
        $br = array_keys(objLoadBranch($path, false, true));
        if (in_array("current", $br)){
            $date = date("Ymd",time());
            $br = array_keys(objLoadBranch($path. "current/", true, false));
            
            foreach($br as $id){
                if (date("Ymd",explode(".",$id)[0]) == $date){
                    continue;
                }
                $obj = objLoad($path. "current/{$id}","raw");
                self::setZero($path);
                self::setSubBalance($path, $id, $obj["count"]);
//                echo $path. "current/{$id}\n";
                objKill($path. "current/{$id}");
            }
            return;
            
        }
        foreach($br as $value){
            self::calcCurrentBalance($path."{$value}/");
        }
        
        
    }
    
    
    /*--------------------------------------------------*/
    
    
    
}
