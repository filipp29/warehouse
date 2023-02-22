<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';




/*--------------------------------------------------*/
/*
 * 
 * 
 * Класс для работы с бухгалтерскими проводками.
 * 
 * ---------------------------------------------------
 * Атрибуты-------------------------------------------
 * 
 * pr $id - id проводки
 * 
 * pr $params - параметры проводки
 * 
 * pr $date - дата формата YYYMMDD
 * 
 * ---------------------------------------------------
 * Статические методы---------------------------------
 * 
 * create(account, src, dst, material, count, docId, timeStamp) - функция создает
 *      новую проводку. account - счет, src - источник, dst - назначение, material - материал,
 *      count - количество, docId - номер документа, price - цена за еденицу
 *      (если цена = -1 то значит перемещение происходит внутри компании) 
 *      timeStamp - время (документа).
 * 
 * delete(id) - удаляет проводку из всех подкаталогов
 * 
 * getOne(id) - получает массив с параметрами проводки по id
 * 
 * getMany(subcount1,subcount2,timestamp1,timestamp2) - возвращает массив проводок
 *      subcount1 - контрагент, сотрудник, склад и тд.
 *      subcount2 - материал
 *      timestamp1 - начальный timestamp
 *      timestamp2 - конечный timestamp
 * 
 * getDaily(timestamp,subcount1,subcount2,type,account) - возвращает количество материала
 *      проведенного за определенную дату до определенного времени, используется для формирования
 *      таблицы остатков на счетах. 
 *      
 * 
 * --------------------------------------------------
 * Публичные методы экземпляра-----------------------
 * 
 * 
 * 
 * --------------------------------------------------*/






class Entry {
    private $id = null;
    private $params = [];
    private $date = null;
    static private $path = "/ware/default/entry/";
    
    
    
    
    
    /*--------------------------------------------------*/
    
    
    
    public function __construct(
            $id
    ){  
        $this->id = $id;
        $timeStamp = explode(".", $id)[0];
        $this->date = date("Ymd",$timeStamp);
        $this->params = objLoad(self::$path. "all/{$this->date}/$id","raw");
        
    }
    
    static public function setOrg(
            $org
    ){
        self::$path = "/ware/{$org}/entry/";
    }
    
    /*--------------------------------------------------*/
    
    
    static public function getOne(
            $id
    ){
        $timeStamp = explode(".", $id)[0];
        $day = date("Ymd",$timeStamp);
        $result = objLoad(self::$path. "all/{$day}/{$id}");
        $result ["id"] = $id;
        $result ["timeStamp"] = $timeStamp;
        return $result;
    }
    
    
    /*--------------------------------------------------*/
    
    
    static public function getManyBy2(
            $subcount1,
            $subcount2,
            $timeStamp1,
            $timeStamp2,
            $byType1,
            $byType2,
            $account = "1310"
    ){
        
        $result = [];
        $date1 = (int)date("Ymd", $timeStamp1);
        $date2 = (int)date("Ymd", $timeStamp2);
        $path = self::$path. "{$byType1}/{$subcount1}/{$byType2}/{$subcount2}/";
        $dateList = array_keys(objLoadBranch($path, false, true));
        foreach($dateList as $date){
            if (((int)$date >= $date1) && ((int)$date <= $date2)){
                $br = array_keys(objLoadBranch("{$path}{$date}/{$account}/dbt/"),true,false);
                foreach($br as $id){
                    $timeStamp = (int)explode("_", $id)[0];
                    if (($timeStamp >= (int)$timeStamp1) && ($timeStamp <= (int)$timeStamp2)){
                        $obj = objLoad("{$path}{$date}/{$account}/dbt/{$id}","raw");
                        $obj["id"] = $id;
                        if (($obj["src"] != $subcount1)&&($obj["src"] != $subcount2)){
                            $result[$obj["src"]]["dbt"][] = $obj;
                        }
                        else{
                            
                            $result[$obj["dst"]]["crt"][] = $obj;
                        }
                    }
                }
                $br = array_keys(objLoadBranch("{$path}{$date}/{$account}/crt/"),true,false);
                foreach($br as $id){
                    $timeStamp = (int)explode("_", $id)[0];
                    if (($timeStamp >= (int)$timeStamp1) && ($timeStamp <= (int)$timeStamp2)){
                        $obj = objLoad("{$path}{$date}/{$account}/crt/{$id}","raw");
                        $obj["id"] = $id;
                        if (($obj["src"] != $subcount1)&&($obj["src"] != $subcount2)){
                            $result[$obj["src"]]["dbt"][] = $obj;
                        }
                        else{
                            
                            $result[$obj["dst"]]["crt"][] = $obj;
                        }
                    }
                }
            }
        }
        return $result;
    }
    
    
    
    
    /*--------------------------------------------------*/
    
    
    static public function getManyBy3(
            $subcount1,
            $subcount2,
            $subcount3,
            $timeStamp1,
            $timeStamp2,
            $byType1,
            $byType2,
            $byType3,
            $account = "1310"
    ){
        
        $result = [];
        $date1 = (int)date("Ymd", $timeStamp1);
        $date2 = (int)date("Ymd", $timeStamp2);
        $path = self::$path. "{$byType1}/{$subcount1}/{$byType2}/{$subcount2}/{$byType3}/{$subcount3}/";
        $dateList = array_keys(objLoadBranch($path, false, true));
        foreach($dateList as $date){
            if (((int)$date >= $date1) && ((int)$date <= $date2)){
                
                $br = array_keys(objLoadBranch("{$path}{$date}/{$account}/dbt/"),true,false);
                foreach($br as $id){
                    $timeStamp = (int)explode("_", $id)[0];
                    if (($timeStamp >= (int)$timeStamp1) && ($timeStamp <= (int)$timeStamp2)){
                        $obj = objLoad("{$path}{$date}/{$account}/dbt/{$id}","raw");
                        $obj["id"] = $id;
                        $result["dbt"][] = $obj;
                    }
                }
                $br = array_keys(objLoadBranch("{$path}{$date}/{$account}/crt/"),true,false);
                foreach($br as $id){
                    $timeStamp = (int)explode("_", $id)[0];
                    if (($timeStamp >= (int)$timeStamp1) && ($timeStamp <= (int)$timeStamp2)){
                        $obj = objLoad("{$path}{$date}/{$account}/crt/{$id}","raw");
                        $obj["id"] = $id;
                        $result["crt"][] = $obj;
                    }
                }
                
            }
        }
        return $result;
    }
    
    
    
    /*--------------------------------------------------*/
    
    
    static private function getId(
            $timeStamp
    ){
        $rand1 = (rand() % 8900)+1000;
        $rand2 = (rand() % 8900)+1000;
        return  $timeStamp.".". $rand1. ".". $rand2;
    }
    
    
    
    /*--------------------------------------------------*/
    
    
    
    static private function save(
            $id,
            $result
    ){
        
        $timeStamp = explode(".", $id)[0];
        $date = date("Ymd",$timeStamp);
        extract($result);
        objSave(self::$path. "all/". $date. "/". $id, "raw", $result);
        

        
        $path = self::$path."bySubcount2/{$material}/bySubcount1/{$src}/$date/{$account}/crt/{$id}";
        $buf = [];
        objSave($path, "raw", $result);
        
        $path = self::$path."bySubcount2/{$material}/bySubcount1/{$dst}/$date/{$account}/dbt/{$id}";
        $buf = [];
        objSave($path, "raw", $result);
        
        $path = self::$path."bySubcount1/{$src}/bySubcount2/{$material}/$date/{$account}/crt/{$id}";
        $buf = [];
        objSave($path, "raw", $result);
        
        $path = self::$path."bySubcount1/{$dst}/bySubcount2/{$material}/$date/{$account}/dbt/{$id}";
        $buf = [];
        objSave($path, "raw", $result);
        
        $path = self::$path."bySubcount1/{$src}/bySubcount1/{$dst}/bySubcount2/{$material}/$date/{$account}/crt/{$id}";
        $buf = [];
        objSave($path, "raw", $result);
        
        $path = self::$path."bySubcount1/{$dst}/bySubcount1/{$src}/bySubcount2/{$material}/$date/{$account}/dbt/{$id}";
        $buf = [];
        objSave($path, "raw", $result);
        
        $path = self::$path."byAccount/{$account}/$date/{$id}";
        $buf = [];
        objSave($path, "raw", $result);
        \Reports::setBalance($id,$result);
        
    }
    
    
    
    /*--------------------------------------------------*/
    
    
    static public function create(
//            $docId,
//            $timeStamp,
//            $account,
//            $src,
//            $dst,
//            $material,
//            $count,
//            $price = -1
              $params  
    ){
        extract($params);
        if (!$price){
            $price = -1;
        }
        $result = [];
        if (isset($account)){
            $result["account"] = $account;
        }
        else {
            throw new Exception("Account not exists");
        }
        if (isset($src)){
            $result["src"] = $src;
        }
        else {
            throw new Exception("Src not exists");
        }
        if (isset($dst)){
            $result["dst"] = $dst;
        }
        else {
            throw new Exception("Dst not exists");
        }
        if (isset($material)){
            $result["material"] = $material;
        }
        else {
            throw new Exception("Material not exists");
        }
        if (isset($count)){
            $result["count"] = $count;
        }
        else {
            throw new Exception("Count not exists");
        }
        if (!is_numeric($count)){
            throw new Exception("Count must be numeric. {$count}");
        }
        else{
            $result["count"] = $count;
        }
        if (isset($price)){
            $result["price"] = $price;
        }
        else {
            throw new Exception("Price not exists");
        }
        if (!is_numeric($price)){
            throw new Exception("Price must be numeric. {$price}");
        }
        else{
            $result["price"] = $price;
        }
        if(!$docId){
            throw new Exception("DocId not exists");
        }
        else{
            $result["docId"] = $docId;
        }
        if ((int)date("Y",$timeStamp) < 2010){
            throw new Exception("Date must be after 2010");
        }
        
        $id = self::getId($timeStamp);
        $date = date("Ymd",$timeStamp);
        self::save($id, $result);

        
        return $id;
    }
    
    
    
    
    
    /*--------------------------------------------------*/
    
    
    static public function delete(
            $id
    ){
                
        $timeStamp = explode(".", $id)[0];
        $date = date("Ymd",$timeStamp);
        $params = self::getOne($id);
        extract(self::getOne($id));
        objKill(self::$path. "all/". $date. "/". $id);
        
        $path = self::$path."bySubcount2/{$material}/bySubcount1/{$src}/$date/{$account}/crt/{$id}";
        $buf = [];
        objKill($path);
        
        $path = self::$path."bySubcount2/{$material}/bySubcount1/{$dst}/$date/{$account}/dbt/{$id}";
        $buf = [];
        objKill($path);
        
        $path = self::$path."bySubcount1/{$src}/bySubcount2/{$material}/$date/{$account}/crt/{$id}";
        $buf = [];
        objKill($path);
        
        $path = self::$path."bySubcount1/{$dst}/bySubcount2/{$material}/$date/{$account}/dbt/{$id}";
        $buf = [];
        objKill($path);
        
        $path = self::$path."bySubcount1/{$src}/bySubcount1/{$dst}/bySubcount2/{$material}/$date/{$account}/crt/{$id}";
        $buf = [];
        objKill($path);
        
        $path = self::$path."bySubcount1/{$dst}/bySubcount1/{$src}/bySubcount2/{$material}/$date/{$account}/dbt/{$id}";
        $buf = [];
        objKill($path);
        
        $path = self::$path."byAccount/{$account}/$date/{$id}";
        $buf = [];
        objKill($path);
        $params["count"] = -$params["count"];
        \Reports::setBalance($id, $params);
    }
    
    
    /*--------------------------------------------------*/
    
    
    static public function getDailyBy2(
            $timeStamp,
            $subcount1,
            $subcount2,
            $type,
            $byType1,
            $byType2,
            $account = "1310"
    ){
        $date = date("Ymd",$timeStamp);
        $path = self::$path. "{$byType1}/{$subcount1}/{$byType2}/{$subcount2}/{$date}/{$account}/{$type}/";
        $br = array_keys(objLoadBranch($path, true, false));
        $result = 0;
        sort($br);
        foreach($br as $value){
            if ((int)explode(".", $value)[0] > (int)$timeStamp){
                break;
            }
            $count = objLoad($path. "{$value}", "raw")["count"];
            $result += (int)$count;
        }
        return $result;
    }
    
    /*--------------------------------------------------*/
    
    
    
    static public function getDailyBy3(
            $timeStamp,
            $subcount1,
            $subcount2,
            $subcount3,
            $type,
            $byType1,
            $byType2,
            $byType3,
            $account = "1310"
    ){
        $date = date("Ymd",$timeStamp);
        $path = self::$path. "{$byType1}/{$subcount1}/{$byType2}/{$subcount2}/{$byType3}/{$subcount3}/{$date}/{$account}/{$type}/";
        $br = array_keys(objLoadBranch($path, true, false));
        $result = 0;
        sort($br);
        foreach($br as $value){
            if ((int)explode(".", $value)[0] > (int)$timeStamp){
                break;
            }
            $count = objLoad($path. "{$value}", "raw")["count"];
            $result += (int)$count;
        }
        return $result;
    }
    
    
    /*--------------------------------------------------*/
    
    public function getParams(){
        return $this->params;
    }
    
    
    
    
    /*--------------------------------------------------*/
    
//    public function modify(
//            $params
//    ){
//        foreach ($this->params as $k => $v){
//            if (key_exists($k, $params)){
//                $this->params[$k] = $params[$k];
//            }
//        }
//        print_r($params);
//        print_r($this->params);
//        self::save($this->id, $this->params);
//    }
    
    
    
    
    /*--------------------------------------------------*/
}

































