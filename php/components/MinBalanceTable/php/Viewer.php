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
    private $path = "/_modules/warehouse/php/components/MinBalanceTable/views/";
    private $headerBlockList = [];
    private $table = [];
    private $view = null;
    private $tableButtonList = [];
    /*--------------------------------------------------*/
    
    public function __construct(
            $path
    ){
        $this->view = new \View2($path);
        $this->path = $path;
    }
    
    /*--------------------------------------------------*/
      
    public function addRow(
            $row
    ){
        $keys = [
            "subcount1",
            "subcount2",
            "minCount",
            "curCount"
        ];
        $buf = [];
        foreach($keys as $k => $v){
            $value = $row[$v];
            $result = [];
            $result["text"] = $value["name"];
            if (isset($value["id"])){
                $params = [];
                $params["data_id"] = $value["id"];
                $params["onclick"] = "showSubcountForm(`{$value["id"]}`);";
                $result["params"] = $params;
            }
            
            
            $buf[$k] = $result;
        }
        if ((int)$row["curCount"]["name"] <= (int)$row["minCount"]["name"]){
            foreach($buf as $key => $value){
                $buf[$key]["params"]["style"] = "background-color: #FA8072";
                $buf[$key]["params"]["class"] = "red";
            }
            
        }
        $this->table[] = $buf;
    }
    
    /*--------------------------------------------------*/
    
    public function addHeaderBlock(
            $block
    ){
        $result = [];
        $result["params"] = [
            "style" => "width: 250px;"
        ];
        $result["label"] = [
            "text" => $block["label"]
        ];
        $result["input"] = [];
        $result["input"]["params"] = [
            "id" => "minBalanceFilter_". $block["id"],
        ];
        $result["type"] = $block["type"];
        $this->headerBlockList[] = $result;
    }
    
    /*--------------------------------------------------*/
    
    private function show_main(){
        $data = [
            "table" => $this->table,
            "headerBlockList" => $this->headerBlockList,
            "tableButtonList" => $this->tableButtonList
        ];
        $this->view->show("main", $data);
    }
    
    /*--------------------------------------------------*/
    
    private function show_addForm(){
        $this->view->show("addForm");
    }
    
    /*--------------------------------------------------*/
    
    public function show(
            $name = "main"
    ){
        call_user_func(array($this, "show_{$name}"));
    }
    
    /*--------------------------------------------------*/
    
    public function addTableButton(
            $button
    ){
        $result = [];
        $result["text"] = $button["name"];
        $result["params"] = [
            "onclick" => $button["onclick"],
            "style" => "margin-left: 15px;"
        ];
        $this->tableButtonList[] = $result;
    }
    
    /*--------------------------------------------------*/
    
}
