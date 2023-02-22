<?php
$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //Подключаем библиотеку для работы с БД
error_reporting(E_ALL); //Включаем вывод ошибок
set_time_limit(600); //Устанавливаем максимальное время работы скрипта в секундах
ini_set('display_errors', 1); //Еще один вывод ошибок
ini_set('memory_limit', '512M'); //Устанавливаем ограничение памяти на скрипт (512Мб)



/*--------------------------------------------------*/
/*-
 * Класс предназначен для работы с объектом субконто
 * модуля склад. 
 * 
 * Свойства---------------------------------------
 * 
 * pr $type         - тип субконто
 * 
 * pr $params = []  - параметры субконто(зависят от типа)
 * 
 * pr $id           - уникальный id, присваивается при создании,
 * не изменяется
 * 
 * pr $name         - имя, может быть не уникально, можно изменить
 * 
 * st pr $path      - путь к ветке базы данных
 * 
 * st pr $typeList  - список типов субконто в виде [key => "Имя типа"]
 * 
 * st pr $paramList - список параметров в виде ["Тип" => [Список параметров]]
 *      [Список параметров] имеет вид ["Параметр" => [Описание параметра]]
 *      [Описание параметра] имеет обязательное поле "type" и от него зависят остальные поля
 *      type = "string" - значение параметра строка, доп.параметров нет
 *              --------------------------------------------------
 *             "list"   - список заранее предопределенных значений в виде строки,
 *              параметр может принимать только одно из этих значений
 *              доп.поля - "values" - массив со списком возможных значений
 *              --------------------------------------------------
 *             "select" - список объектов из бд, параметр может принимать только значение
 *              одного из существующих в базе объектов. Объект зависит от остальных полей
 *              доп.поля - "dir" - путь к ветке бд с объектами если объекты хранятся в виде веток
 *                         "file" - путь к ветке если объекты хранятся в виде файлов в виде [путьк ветке с объектами]_[расширение файла объекта]
 *                         "obj" - если есть поле "dir", хранит имя файла в каталоге
 *                         "show" - поле в файле для текстового представления параметра
 * 
 * 
 * 
 * --------------------------------------------------
 * Статические методы -------------------------------
 *
 * create(type, name, params) - создает в базе объект субконто с типом type,
 *      именем name и параметрами из params. Проверяет корректность данных
 * 
 * getParamValues(type,key) - возвращает массив возможных значений параметра key типа type
 * 
 * getParamList(type) - возвращает массив параметров типа type в виде массива ["Параметр" => "Описание параметра"] атрибута $paramList
 * 
 * getSubcountList(type,onlyNames) - взвращает массив возможных значение субконто в виде [id,name,..params],
 *      если есть флаг onlyNames то [id,name]
 * 
 * getTypeList() - возвращает массив типов субконто вида [key => "Имя типа"]
 * 
 * 
 * --------------------------------------------------
 * Публичные методы экземпляра---------------------------------
 * 
 * __construct(id) - конструктор принимает один параметр id и создает объект 
 *      параметрами $type, $id, $name, $params
 * 
 * getId() - возвращает id
 * 
 * getName() - возвращает name
 * 
 * getParams(key) - если key не задан возвращает весь массив params иначе params[key]
 * 
 * setParams(params) - изменяет параметры субконто и сохраняет их в базу. params массив
 *      с новыми параметрами вида ["ключ" => "значение"]. Может содержать не все параметры.
 *      Производится проверка на корректность.
 * 
 * 
 * 
 * 
 * -------------------------------------------------*/
/*--------------------------------------------------*/

class Subcount {
    private $type = null;
    private $params = [];
    private $id = null;
    private $name = null;
    static private $path = "/ware/default/subcount/";
    static private $typeList = [
        "warehouse" => "Склад",
        "profile" => "Сотрудник",
        "material" => "Материал",
        "contractor" => "Контрагент",
        "object" => "Объект",
        "asset" => "ОС"
    ];
    static private $groupList = [
        "warehouse" => "city",
        "profile" => "function",
        "material" => "matType",
        "contractor" => "group",
        "object" => "objType",
        "asset" => "asset_type"
    ];
    static private $searchParams = [
        "warehouse" => [
            "city",
            "inCharge"
        ],
        "object" => [
            "city",
            "street",
            "building"
        ],
        "contractor" => [
            "group"
        ],
        "profile" => [
            "login",
            "supervisor"
        ],
        "material" => [
            "matType"
        ],
        "asset" => [
            "asset_type",
            "location"
        ]
    ];
    static private $addParams = [
        "warehouse" => [
            "city",
            "inCharge"
        ],
        "object" => [
            "city",
            "street",
            "building"
        ],
        "contractor" => [
            "city"
        ],
        "profile" => [
            "login"
        ],
        "material" => [
            "units"
        ],
        "asset" => [
            "type",
        ]
    ];
    static private $periodic = [
        "warehouse" => [],
        "object" => [],
        "contractor" => [],
        "profile" => [],
        "material" => [],
        "asset" => [
            "location"
        ]
    ];
    static private $paramList = [
        "warehouse" => [
            "city" => [
                "name" => "Город",
                "type" => "list",
                "values" => [
                    "Лисаковск",
                    "Костанай",
                    "Качар"
                ]
            ],
            "inCharge" => [
                "name" => "Ответственный",
                "type" => "select",
                "dir" => "/profiles/",
                "obj" => "profile.pro",
                "show" => "uname",
            ]
        ],
        "object" => [
            "city" => [
                "name" => "Город",
                "type" => "select",
                "dir" => "/geobase/",
                "depend_dir" => "street"
            ],
            "street" => [
                "name" => "Улица",
                "type" => "select",
                "dir" => "",
                "depend_dir" => "building"
            ],
            "building" => [
                "name" => "Дом",
                "type" => "select",
                "dir" => ""
            ]
        ],
        "contractor" => [
            "city" => [
                "name" => "Город",
                "type" => "list",
                "values" => [
                    "Лисаковск",
                    "Костанай",
                    "Качар"
                ]
            ],
            "address" => [
                "name" => "Адрес",
                "type" => "string"
            ],
            "group" => [
                "name" => "Группа",
                "type" => "list",
                "values" => [
                    "Поставщики",
                    "Системные счета",
                    "Абоненты"
                ]
            ]
        ],
        "profile" => [
            "login" => [
                "name" => "Профиль",
                "type" => "select",
                "dir" => "/profiles/",
                "obj" => "profile.pro",
                "show" => "uname"
            ],
            "supervisor" => [
                "name" => "Руководитель",
                "type" => "select",
                "dir" => "/profiles/",
                "obj" => "profile.pro",
                "show" => "uname"
            ],
        ],
        "material" => [
            "units" => [
                "name" => "Еденицы измерения",
                "type" => "list",
                "values" => [
                    "м",
                    "шт",
                    "упк"
                ]
            ],
            "article" => [
                "name" => "Артикул",
                "type" => "string"
            ],
            "matType" => [
                "name" => "Тип",
                "type" => "list",
                "values" => [
                    "Кабель",
                    "Крепеж",
                    "Оптическ. компоненты",
                    "Расходники",
                    "Инженерн. инфраструктура",
                    "Оборудование",
                    "Инструмент",
                    "НЕ УЧИТЫВАТЬ"
                ]
            ]
        ],
        "asset" => [
            "asset_type" => [
                "name" => "Тип",
                "type" => "list",
                "values" => [
                    "Коммутатор",
                    "Инструмент",
                    "Интвертор",
                    "Аккумулятор"
                ]
            ],
            "model" => [
                "name" => "Модель",
                "type" => "string"
            ],
            "number" => [
                "name" => "Серийный номер",
                "type" => "string"
            ],
            "comment" => [
                "name" => "Комментарий",
                "type" => "string"
            ],
            "location" => [
                "name" => "Место нахождения",
                "type" => "subcount"
            ],
            "price" => [
                "name" => "Цена",
                "type" => "number"
            ],
        ]
    ];
    
    
    /*--------------------------------------------------*/
    
    
    public function __construct(
            $id
    ) {
        $flag = false;
        foreach(self::$typeList as $type => $name){
            $path = self::$path. "{$type}/{$id}/info";
            if (objCheckExist($path, "raw")){
                $obj = objLoad($path);
                $this->type = $obj["type"];
                $this->id = $id;
                $this->name = $obj["name"];
                unset($obj["type"], $obj["name"], $obj["#e"]);
                foreach ($obj as $key => $value){
                    $this->params[$key] = $value; 
                }
                $flag = true;
            }
        }
        
        if (!$flag){
            throw new Exception("Wrong id {$id}");
        }
    }
    
    
    /*--------------------------------------------------*/
    
    static public function setOrg(
            $org
    ){
        self::$path = "/ware/{$org}/subcount/";
    }
    
    
    /*--------------------------------------------------*/
    
    
    static public function generateId(){
        $rand1 = (rand() % 8900)+1000;
        $rand2 = (rand() % 8900)+1000;
        $rand3 = (rand() % 8900)+1000;
        return  $rand1. $rand2. $rand3;
    }
    
    
    
    /*--------------------------------------------------*/
    
    
    static private function checkValue(
            $value,
            $ar
    ){
        switch ($ar["type"]) {
            case "string":
                if ($value){
                    return true;
                }
                else{
                    return false;
                }
                break; 
                
               
                
            case "number":
                return !is_nan($value);
                break; 
            
            
            case "select":
                if (key_exists("dir", $ar)){
                    if ($ar["dir"] == ""){
                        return true;
                    }
                    $br = array_keys(objLoadBranch($ar["dir"], false, true));
                }
                return in_array($value, $br);
                break;
            
            case "list":
                return in_array($value, $ar["values"]);
                break;
            
            case "subcount":
                $flag = false;
                foreach(self::$typeList as $type => $name){
                    $path = self::$path. "{$type}/{$value}/info";
                    if (objCheckExist($path, "raw")){
                        
                        $flag = true;
                    }
                }
                return $flag;
                break;
            
            default:
                break;
        }
    }
    
    
    /*--------------------------------------------------*/
    
    
    static public function create(
            $type,
            $name,
            $params
    ){
        if (!key_exists($type, self::$paramList)){
            throw new Exception("Wrong type {$type}");
        }
        $id = self::generateId();
        $paramList = self::$paramList[$type];
        $result = [];
        foreach ($paramList as $key => $value){
            if (!key_exists($key, $params)){
                throw new Exception("Key {$key} is empty");
            }
            if (!self::checkValue($params[$key],$paramList[$key])){
                throw new Exception("Key {$key} has wrong value {$params[$key]}");
            }
            $result[$key] = $params[$key];
        }
        $result["name"] = $name;
        $result["type"] = $type;
        objSave(self::$path. $type. "/". $id. "/info", "raw", $result);
        objSave(self::$path. $type. "/". $id. "/history/". time(). ".info", "raw", $result);
        return $id;
    }
    
    
    /*--------------------------------------------------*/
    
    
    static public function getTypeList(){
        return self::$typeList;
    }
    
    /*--------------------------------------------------*/
    
    static public function getGroupList(){
        return self::$groupList;
    }
    
    /*--------------------------------------------------*/
    
    static public function getSearchList(
            $type
    ){
        return self::$searchParams[$type];
    }
    
    /*--------------------------------------------------*/
    
    
    static public function getParamValues(
            $type,
            $key 
    ){  
        $property = self::$paramList[$type][$key];
        switch ($property["type"]) {
            case "list":
                 return $property["values"];
                break;
            case "select":
                $select = [];
                if (isset($property["dir"])){
                    $br = array_keys(objLoadBranch($property["dir"], false, true));
                    foreach($br as $value){
                        $obj = objLoad($property["dir"]. $value. "/". $property["obj"]);
                        $select[$value] = $obj[$property["show"]];
                    }
                }
                return $select;
                break;
            default:
                return  null;
                break;
        }
        return $result;
        
    }
    
    
    static public function getParamList(
            $type
    ){
        return self::$paramList[$type];
    }
    
    
    
    /*--------------------------------------------------*/
    
    
    
    static public function getSubcountList(
            $type,
            $onlyNames = false
    ){
        
        $path = self::$path. $type. "/";
        
        $br = array_keys(objLoadBranch($path, false, true));
        $result = [];
        foreach($br as $value){
            $obj = objLoad($path. $value. "/info", "raw");
            $buf = [];
            $buf["id"] = $value;
            if($onlyNames){
                $buf["name"] = $obj["name"];
            }
            else{
                foreach($obj as $k => $v){
                    $buf[$k] = $v;
                }
            }
            $result[] = $buf;
        }
        
        return $result;
    }
    
    
    
    /*--------------------------------------------------*/
    
    
    
    /*--------------------------------------------------*/
    
    
    public function getName(){
        return $this->name;
    }
    
    
    /*--------------------------------------------------*/
    
    public function getId(){
        return $this->id;
    }
    
    /*--------------------------------------------------*/
    
    public function getType(){
        return $this->type;
    }
    
    /*--------------------------------------------------*/
    
    public function getParams(
            $key = null
    ){
        if ($key){
            return isset($this->params[$key]) ? $this->params[$key] : "";
        }
        else{
            return $this->params;
        }
    }
    
    /*--------------------------------------------------*/
    
    
    public function getHistory(){
        $path = self::$path. "{$this->type}/{$this->id}/history/";
        $br = array_keys(objLoadBranch($path, true, false));
        rsort($br);
        $result = [];
        foreach($br as $value){
            $obj = objLoad($path.$value);
            $obj["timeStamp"] = explode(".", $value)[0];
            unset($obj["#e"]);
            $result[] = $obj;
        }
        return $result;
    }
    
    
    /*--------------------------------------------------*/
    
    
    public function change(
            $name,
            $params
    ){
        $type = $this->type;
        if (!key_exists($type, self::$paramList)){
            throw new Exception("Wrong type {$type}");
        }
        $id = $this->id;
        
        $paramList = self::$paramList[$type];
        $result = [];
        foreach ($paramList as $key => $value){
            if (!key_exists($key, $params)){
                throw new Exception("Key {$key} is empty");
            }
            if (!self::checkValue($params[$key],$paramList[$key])){
                throw new Exception("Key {$key} has wrong value {$params[$key]}");
            }
            $result[$key] = $params[$key];
        }
        $result["name"] = $name;
        $result["type"] = $type;
        objSave(self::$path. $type. "/". $id. "/info", "raw", $result);
        isset($_COOKIE["login"]) ? $result["author"] = $_COOKIE["login"] : $result["author"] = "UNKNOWN";
        objSave(self::$path. $type. "/". $id. "/history/". time(). ".info", "raw", $result);
        return $id;
    }
    
    
    /*--------------------------------------------------*/
    
    
    public function getParamName(
            $key
    ){
        
        return self::$paramList[$this->type][$key]["name"];
        
    }
    
    
    /*--------------------------------------------------*/
    
    
   public function getShow(
           $key
   ){
       $params = self::$paramList[$this->type][$key];
       if ($params["type"] == "select"){
            if (isset($params["show"])){
                $obj = objLoad($params["dir"]. "{$this->params[$key]}/{$params['obj']}");
                return $obj[$params["show"]];
            }
            else{
                return $this->params[$key];
            }
        }
        else{
            return $this->params[$key];
        }
   }
    
    
    /*--------------------------------------------------*/
    
    
    public function setParams(
            $params
    ){
        $paramList = self::$paramList[$type];
        $result = $this->params;
        foreach ($paramList as $key => $value){
            if (!self::checkValue($params[$key],$paramList[$key])){
                throw new Exception("Key {$key} has wrong value {$params[$key]}");
            }
            echo $key;
            $result[$key] = $params[$key];
        }
        $result["name"] = $this->name;
        $result["type"] = $this->type;
        objSave(self::$path. $this->type. "/". $this->id. "/info", "raw", $result);
    }
    
    /*--------------------------------------------------*/
    
    public function getPrice(
            $timeStamp = null
    ){
        if (!$timeStamp){
            $timeStamp = time();
        }
        
        $path = self::$path. "{$this->type}/{$this->id}/price/";
        $br = array_keys(objLoadBranch($path, true, false));
        rsort($br);
        foreach($br as $v){
            if ((int)$v < (int)$timeStamp){
                $obj = objLoad($path. $v);
                return $obj["price"];
            }
        }
        return "";
    }
    
    /*--------------------------------------------------*/
    
    
    public function delete(){
        objUnlinkBranch(self::path. $this->id);
    }
    
    /*--------------------------------------------------*/
    
    public function addPrice(
            $price,
            $timeStamp = null
    ){
        if (!$timeStamp){
            $timeStamp = time();
        }
        $curPrice = $this->getPrice($timeStamp);
        if ($price != $curPrice){
            $path = $path = self::$path. "{$this->type}/{$this->id}/price/";
            $obj = [
                "price" => $price
            ];
            objSave("{$path}{$timeStamp}", "raw", $obj);
        }
    }
    
    /*--------------------------------------------------*/
    
    static public function getMaterialCount(
            $subcount1,
            $subcount2
    ){
        $timeStamp2 = time();
        $byType1 = "bySubcount1";
        $byType2 = "bySubcount2";
        $account = "1310";
        $dateAfter = date("Ymd", $timeStamp2);

        $crtAfter = (int)\Reports::getBalance("{$account}/{$byType1}/{$subcount1}/{$byType2}/{$subcount2}/", "crt", $dateAfter);
        $dbtAfter = (int)\Reports::getBalance("{$account}/{$byType1}/{$subcount1}/{$byType2}/{$subcount2}/", "dbt", $dateAfter);
        $crtAfter += (int)\Entry::getDailyBy2($timeStamp2, $subcount1, $subcount2, "crt",$byType1,$byType2,$account);
        $dbtAfter += (int)\Entry::getDailyBy2($timeStamp2, $subcount1, $subcount2, "dbt",$byType1,$byType2,$account);
        $count = $dbtAfter - $crtAfter;
        return $count;
    }
    
    /*--------------------------------------------------*/
    
    
        
    
    
    
    
    
}




?>