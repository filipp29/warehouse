<?php



$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //Подключаем библиотеку для работы с БД
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';

error_reporting(E_ALL); //Включаем вывод ошибок
set_time_limit(600); //Устанавливаем максимальное время работы скрипта в секундах
ini_set('display_errors', 1); //Еще один вывод ошибок
ini_set('memory_limit', '512M'); //Устанавливаем ограничение памяти на скрипт (512Мб)

class Viewer {
    private $path = "";
    private $view = null;
    private $menuButtonList = [];
    private $element = [];
    private $content = "";
    
    /*--------------------------------------------------*/
    
    public function __construct(
            $path
    ){
        $this->path = $path;
        $this->view = new \View2($path);
    }
    
    /*--------------------------------------------------*/
    
    public function addMenuButton(
            $button
    ){
        $result = [
            "text" => $button["name"],
            "params" => [
                "onclick" => $button["onclick"],
                "style" => $this->toStr(isset($button["style"]) ? $button["style"] : []),
            ]
        ];
        
        $this->menuButtonList[] = $result;
        
    }
    
    /*--------------------------------------------------*/
    
    public function addPath(
            $path,
            $name
    ){
        $result = [
            "text" => $name,
            "params" => [
                "data_path" => $path
            ]
        ];
        $this->path = $result;
    }
    
    /*--------------------------------------------------*/
    
    public function addContent(
            $content
    ){
        $this->content = $content;
    }
    
    /*--------------------------------------------------*/
    
    private function toStr(
            $ar
    ){
        $result = "";
        foreach($ar as $k => $v){
            $result = " {$k}='{$v}'";
        }
        
    }
    
    /*--------------------------------------------------*/
    
    public function addElement(
            $element,
            $type
    ){
        $img = "";
        switch($type):
            case "folder":
                $img = "/_modules/warehouse/php/components/TreeExplorer/icons/folder.ico";
                $class = "folder";
                $onclick = "";
                break;
            case "file":
                $img = "/_modules/warehouse/php/components/TreeExplorer/icons/file.ico";
                $class = "file";
                break;
        endswitch;
        $result = [
            "element" => [
                "text" => $element["name"],
                "params" => [
                    "data_id" => $element["id"],
                    "class" => $class
                ]
            ],
            "img" => [
                "params" => [
                    "src" => $img,
                    "onclick" => $onclick
                ]
            ] 
        ];
    }
    
    /*--------------------------------------------------*/
}




















