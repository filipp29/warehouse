<?php

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //Подключаем библиотеку для работы с БД



class subCount {
    private $type = null;
    private $params = [];
    private $id = null;
    private $name = null;
    static private $typeList = [
        "wareHouse" => "Склад",
        "profile" => "Сотрудник",
        "material" => "Материал"
    ];
    static private $paramList = [
        "wareHouse" => [
            "city" => [
                "type" => "list",
                "values" => [
                    "Лисаковск",
                    "Костанай",
                    "Качар"
                ]
            ],
            "inCharge" => [
                "type" => "select",
                "dir" => "/profiles/",
                "showType" => "value",
                "show" => "profile.pro/uname"
            ]
        ],
        "profile" => [
            "login" => [
                "type" => "select",
                "dir" => "/profiles/",
                "showType" => "value",
                "show" => "profile.pro/uname"
            ]
        ],
        "material" => [
            "units" => [
                "type" => "list",
                "values" => [
                    "м",
                    "шт",
                ]
            ]
        ]
    ];
    
    
    /*--------------------------------------------------*/
    
    
    public function __construct(
            $id
    ) {
        
    }
    
    
    /*--------------------------------------------------*/
    
    
    static public function generateId(){
        $rand1 = (rand() % 8900)+1000;
        $rand2 = (rand() % 8900)+1000;
        $rand3 = (rand() % 8900)+1000;
        return  $rand1. $rand2. $rand3;
    }
    
    
    
    /*--------------------------------------------------*/
    
    
    private function checkValue(
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
                return is_nan($value);
                break; 
            
            
            case "select":
                if (key_exists("dir", $ar)){
                    $br = array_keys(objLoadBranch($ar["dir"], false, true));
                }
                return in_array($value, $br);
                break;
            
            case "list":
                return in_array($value, $ar["values"]);
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
        $id = self::generateId();
        $paramList = self::$paramList[$type];
        $result = [];
        foreach ($paramList as $key => $value){
            if (!key_exists($key, $params)){
                throw new Exception("Key {$key} is empty");
            }
            if (!$this->checkValue($params[$key],$paramList[$key])){
                throw new Exception("Key {$key} has wrong value {$params[$key]}");
            }
            $result[$key] = $params[$key];
        }
        $result["name"] = $name;
        $result["type"] = $type;
        objSave("/ware/subcount/". $type. "/". $id. "/info", "raw", $result);
    }
    
    
    /*--------------------------------------------------*/
    
    
    
    
    
    
    
    
}
