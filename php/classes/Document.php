<?php

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //Подключаем библиотеку для работы с БД

require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';

date_default_timezone_set("Asia/Almaty");

/*--------------------------------------------------*/
/*
 * 
 * Класс предназначен для работы с документами. Позволяет создавать,
 * удалять и редактировать документы.
 * 
 * ---------------------------------------------------
 * Атрибуты-------------------------------------------
 * 
 * pr $id
 * 
 * pr $header[]
 * 
 * pr $table[]
 * 
 * pr $entry[]
 * 
 * ---------------------------------------------------
 * Статические методы---------------------------------
 * 
 * create(params) - создает новый документ с заданными паараметрами шапки.
 *      Документ создается пустой. Метод возвращает id документа по которому можно
 *      заполнить табличную часть и провести.
 * 
 * delete(id) - удаляет документ из всех директорий. Так же удаляет все проводки,
 *      созданные документом
 * 
 * getDocParams(id) - 
 * 
 * ---------------------------------------------------
 * Публичные методы экземпляра------------------------
 * 
 * __construct(id) - создает экземпляр класса с заданным id. Автоматически заполняет
 *      все атрибуты. При отсутствии документ генерирует исключение
 * 
 * getTable() - возвращает табличную часть документа в виде массива
 * 
 * addRow(id,price,count) - вставляет строку в табличную часть документа
 * 
 * save() - сохраняет документ и создает (обновляет) все проводки
 * 
 * saveAssets() - сохраняет документ и  обновляет карточки основных средств
 * 
 * --------------------------------------------------*/





class Document {
    private $id = null;
    private $header = [];
    private $table = [];
    private $entry = [];
    private $comment = [];
    static private $path = "/ware/default/docList/";
    static private $headerKeys = [
        "src",
        "dst",
        "timeStamp",
        "account",
        "author",
        "type" 
    ];
    
    
    /*--------------------------------------------------*/
    
    public function __construct(
            $id
    ){
        $timeStamp = explode(".", $id)[0];
        $date = date("Ymd", $timeStamp);
        if (!objCheckExist(self::$path. "all/{$date}/{$id}/", "raw")){
            throw new Exception("Document {$id} not exists");
        }
        $this->id = $id;
        $this->header = objLoad(self::$path. "all/{$date}/{$id}/header", "raw");
        unset($this->header["#e"]);
        $obj = objLoad(self::$path. "all/{$date}/{$id}/table", "raw");
        unset($obj["#e"]);
        foreach($obj as $k => $v){
            $buf = explode("_", $k);
            $this->table[(int)$buf[0]][$buf[1]] = $v;
        }
        $obj = objLoad(self::$path. "all/{$date}/{$id}/entry", "raw");
        unset($obj["#e"]);
        foreach($obj as $k => $v){
            $this->entry[(int)$k] = $v;
        }
        
    }
    
    
    /*--------------------------------------------------*/
    
    static public function setOrg(
            $org
    ){
        self::$path = "/ware/{$org}/docList/";
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
    
    static private function saveFile(
            $id,
            $file,
            $params,
            $header = []
    ){
        $timeStamp = explode(".", $id)[0];
        $date = date("Ymd", $timeStamp);
        extract($header);
        $path = self::$path. "all/{$date}/{$id}/{$file}";
        objSave($path, "raw", $params);
        if ((isset($type)) && (isset($src)) && (isset($dst))){
            $path = self::$path. "byType/{$type}/{$date}/{$id}/{$file}";
            objSave($path, "raw", $params);

            $path = self::$path. "bySubcount1/{$src}/{$dst}/{$date}/{$id}/{$file}";
            objSave($path, "raw", $params);

            $path = self::$path. "bySubcount1/{$dst}/{$src}/{$date}/{$id}/{$file}";
            objSave($path, "raw", $params);
        }
    }
    
    
    
    /*--------------------------------------------------*/
    
//    static private function deleteFile(
//            $id,
//            $file,
//            $header
//    ){
//        $timeStamp = explode(".", $id)[0];
//        $date = date("Ymd", $timeStamp);
//        extract($header);
//        $path = self::$path. "all/{$date}/{$id}/{$file}";
//        objKill($path);
//        
//        $path = self::$path. "byType/{$type}/{$date}/{$id}/{$file}";
//        objKill($path);
//        
//        $path = self::$path. "bySubcount1/{$src}/{$date}/{$id}/{$file}";
//        objKill($path);
//        
//        $path = self::$path. "bySubcount1/{$dst}/{$date}/{$id}/{$file}";
//        objKill($path);
//    }
    
    /*--------------------------------------------------*/
    
    
    static public function create(
            $params
    ){
        foreach(self::$headerKeys as $key){
            if (!key_exists($key, $params)){
                throw new Exception("Param {$key} not exists");
            }
        }
        $timeStamp = $params["timeStamp"];
        $id = self::getId($timeStamp);
        self::saveFile($id, "header", $params);
        return $id;
        
    }
    
    /*--------------------------------------------------*/
    
    public function getSubmitList(){
        $id = $this->id;
        $timeStamp = explode(".", $id)[0];
        $date = date("Ymd", $timeStamp);
        $path = self::$path. "all/{$date}/{$id}/submit";
        $obj = objLoad($path);
        unset($obj["#e"]);
        return $obj;
    }
    
    /*--------------------------------------------------*/
    
    public function setSubmitList(
            $list
    ){
        $id = $this->id;
        $timeStamp = explode(".", $id)[0];
        $date = date("Ymd", $timeStamp);
        $path = self::$path. "all/{$date}/{$id}/submit";
        if (count_u($list) > 0){
            objSave($path, "raw", $list);
        }
        else{
            objKill($path);
        }
    }
    
    /*--------------------------------------------------*/
    
    
    public function delete(){
        $id = $this->id;
        $timeStamp = explode(".", $id)[0];
        $date = date("Ymd", $timeStamp);
        $entry = $this->entry;
        unset($entry["#e"]);
        $header = $this->header;
        foreach($entry as $v){
            if ($v == "none"){
                break;
            }
            \Entry::delete($v);
        }
        extract($header);
        
        $path = self::$path. "all/{$date}/{$id}/";
//        echo $path."\n";
        objUnlinkBranch($path);
        
        $path = self::$path. "byType/{$type}/{$date}/{$id}/";
//        echo $path."\n";
        objUnlinkBranch($path);
        
        $path = self::$path. "bySubcount1/{$src}/{$date}/{$id}/";
//        echo $path."\n";
        objUnlinkBranch($path);
        
        $path = self::$path. "bySubcount1/{$dst}/{$date}/{$id}/";
//        echo $path."\n";
        objUnlinkBranch($path);
    }
    
    
    /*--------------------------------------------------*/
    
    static public function getDocParams(
            $id
    ){
        
        $timeStamp = explode(".", $id)[0];
        $header = [];
        $table = [];
        $date = date("Ymd", $timeStamp);
        if (!objCheckExist(self::$path. "all/{$date}/{$id}/", "raw")){
            throw new Exception("Document {$id} not exists");
        }
        $header = objLoad(self::$path. "all/{$date}/{$id}/header", "raw");
        unset($header["#e"]);
        $comment = objLoad(self::$path. "all/{$date}/{$id}/comment", "raw");
        unset($header["#e"]);
        $obj = objLoad(self::$path. "all/{$date}/{$id}/table", "raw");
        unset($obj["#e"]);
        
        foreach($obj as $k => $v){
            $buf = explode("_", $k);
            $table[(int)$buf[0]][$buf[1]] = $v;
        }
        
        $result = [
            "header" => $header,
            "table" => $table,
            "comment" => $comment
        ];
        return $result;
    }
    
    /*--------------------------------------------------*/
    
    
    static public function getDocList(
            $type,
            $timeStamp1,
            $timeStamp2
    ){
        $result = [];
        $path = self::$path. "byType/{$type}/";
        $start = new DateTime(date("Y-m-d", $timeStamp1));
        $end = new DateTime(date("Y-m-d", $timeStamp2)."+ 1 days");
        $interval = new DateInterval("P1D");
        $period = new DatePeriod($start, $interval, $end);
        foreach($period as $time){
            $date = $time->format("Ymd");
            $br = array_keys(objLoadBranch($path. "{$date}/", false, true));
            foreach($br as $docId){
                $timeStamp = (int)explode(".", $docId)[0];
                if (($timeStamp >= (int)$timeStamp1)&&($timeStamp <= (int)$timeStamp2)){
                    $obj = objLoad("{$path}{$date}/{$docId}/header","raw");
                    $buf = [
                        "timeStamp" => $obj["timeStamp"],
                        "src" => $obj["src"],
                        "dst" => $obj["dst"],
                        "author" => $obj["author"],
                        "id" => $docId
                    ];
                    $result[] = $buf;
                }
            }
        }
        return $result;
        
        
    }
    
    
    /*--------------------------------------------------*/
    
    
    public function getTable(){
        return $this->table;
    }
    
    /*--------------------------------------------------*/
    
    public function getHeader(){
        return $this->header;
    }
    
    /*--------------------------------------------------*/
    
    public function removeRow(
            $index
    ){
        unset($this->table[$index]);
    }
    
    /*--------------------------------------------------*/
    
    public function isExecuted(){
        return !($this->entry[0] == "none");
    }
    
    /*--------------------------------------------------*/
    
    
    public function addRow(
            $id,
            $price,
            $count
    ){
        $buf = [
            "id" => $id,
            "price" => $price,
            "count" => $count
        ];
        $this->table[] = $buf;
    }
    
    public function addComment(
            $key,
            $text
    ){
        $this->comment[$key] = $text;
    }
    
    /*--------------------------------------------------*/
    
    public function save(
            $run = true
    ){
        foreach($this->entry as $v){
            if ($v == "none"){
                break;
            }
            \Entry::delete($v);
        }
        $entries = [];
        $i = 0;
        $table = [];
        foreach($this->table as $row){
            if ($run){
                $result = [];
                foreach($this->header as $k => $v){
                    $result[$k] = $v;
                }
                $result["material"] = $row["id"];
                $result["count"] = $row["count"];
                $result["price"] = $row["price"];
                $result["docId"] = $this->id;
                $entries[] = \Entry::create($result);
                
            }
            else{
                $entries[] = "none";
            }
            foreach($row as $k => $v){
                $table["{$i}_{$k}"] = $v;
            } 
            $i++;
        }
        $header = $this->header;
        self::saveFile($this->id, "header", $this->header, $header);
        self::saveFile($this->id, "comment",$this->comment, $header);
        self::saveFile($this->id, "table", $table, $header);
        self::saveFile($this->id, "entry", $entries, $header);
    }
    
    
    
    /*--------------------------------------------------*/
    
    public function saveAssets(){
        foreach($this->table as $row){
            $subcount = new \Subcount($row["id"]);
            $params = $subcount->getParams();
            $params["location"] = $this->header["dst"];
            $subcount->change($subcount->getName(), $params);
        }
    }
    
    /*--------------------------------------------------*/
    
    
    
    
    
    
    
    
    
}
