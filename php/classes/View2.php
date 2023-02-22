<?php

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net';


/*--------------------------------------------------*/
/*--------------------------------------------------*/
/*
 * 
 * Класс предназначен для создания пользовательского интерфейса из шаблонов.
 * Шаблон имеет древовидную структуру, в которой html страница разбита на логические элементы.
 * Папка с шаблоном должна иметь обязательную папку html_templates в которой и находятся под-шаблоны.
 * Каждый элемент может иметь дочерние элементы. Если элемент не имеет потомков, то он хранится в виде 
 * файла php с html шаблоном. Если у элемента есть потомки, то такой элемент является группой элементов 
 * и представляет собой директорию содержащую всех его потомков, сам элемент не имеет шаблона для отображения.
 * В объекте класса дерево хранится в виде ассоциативного массива ["Имя элемента" => "Значение"]
 * Обращение к элементу осуществляется по полному пути в дереве "parent1.parent2.child"
 * 
 * ---------------------------------------------------
 * Свойства ------------------------------------------
 * 
 * pr $path - путь к папке шаблона
 * 
 * pr $tree - массив с деревом шаблонов
 * 
 * pr $css - путь к файлу css
 * 
 * pr $script - путь к файлу js
 * 
 * ---------------------------------------------------
 * Статические методы---------------------------------
 * 
 * отсутствуют
 * 
 * ---------------------------------------------------
 * Публичные методы экземпляра
 * 
 * __construct(path) - создает экземпляр класса по шаблону из папки path. 
 *      Автоматически заполняет свойства $tree, $css, $script. Генерирует исключение
 *      если папки с шаблоном нет, либо он некорректно составлен.
 * 
 * getTree() - возвращает массив $tree
 * 
 * setName() - устанавливает имя
 * 
 * show(_fileName_, data) - выводит на экран шаблон с подставленными значениями.
 *      _fileName_ - путь в дереве к шаблону вида "parent1.parent2.child", 
 *      data - данные для вставки в шаблон в виде массива ["ключ" => "значение"].
 *      Массив data автоматически раскрывается через extract(). Поэтому ключи массива 
 *      должны совпадать с именами переменных в шаблоне. 
 * 
 * --------------------------------------------------*/
/*--------------------------------------------------*/

class View2 {
    
    private $path = "";
    private $tree = [];
    private $css = "";
    private $script = "";
    private $name = "";
    
    
    /*--------------------------------------------------*/
    
    
    public function __construct(
            $path
    ){
//        if (!file_exists($_SERVER['DOCUMENT_ROOT']. $path)){
//            throw new Exception("Dir not found ". $_SERVER['DOCUMENT_ROOT']. $path);
//        }
        $this->name = $path;
        $this->path .= $_SERVER['DOCUMENT_ROOT']. $path;
        if (!file_exists($this->path)){
            throw new Exception("No {$path} object");
        }
        $this->constructTree();
        if (count_u($this->tree) == 0){
            throw new Exception("Object {$path} is empty");
        }
        $this->script = $this->path. "/js/script.js";
        $this->css = $this->path. "/css/style.css";
    }
    
    
    /*--------------------------------------------------*/
    
    
    private function scan(
            $dir
    ){
        $br = scandir($dir);
        $result = [];
        foreach ($br as $value){
            $path = $dir. "/".$value;
            if (($value == ".") || ($value == "..")){
                continue;
            }
            if (is_dir($path)){
                $result[$value] = $this->scan($path);
            }
            else{
                $buf = explode(".", $value);
                $result[$buf[0]] = $path;
            }
            
        }
        return $result;
    }
    
    /*--------------------------------------------------*/
    
    
    private function constructTree(){
        $this->tree = $this->scan($this->path."/html_templates");
    }
    
    
    /*--------------------------------------------------*/
    
    
    public function getTree(){
        return $this->tree;
    }
    
    
    
    /*--------------------------------------------------*/
    
    
    private function getNode(
            $tree,
            $path
    ){
        $buf = explode(".", $path);
        if (count_u($buf) == 1){
            
            return $tree[$buf[0]];
        }
        $path = preg_replace("/^.*?\./", "", $path);
        return $this->getNode($tree[$buf[0]], $path);
    }
    
    
    /*--------------------------------------------------*/
    
    
    public function show(
            $_fileName_,
            $data = [],
            $return = false
    ){
        extract($data);
        $_file_ = $this->getNode($this->tree, $_fileName_);
        if (!file_exists($_file_)){
            throw new Exception("File not found ". $_fileName_);
        }
        if ($return){
            ob_start();
            require $_file_;
            return ob_get_clean();
        }
        else{
            require $_file_;
        }
    }
    
    
    
    
    /*--------------------------------------------------*/
    
    
    
    public function addScriptStyle(
            $name
    ){
        $str = ""
                . "<div id='{$name}_js' style='display: none'>"
                . "{$this->name}/js/script.js"
                . "</div>"
                . "<div id='{$name}_css' style='display: none'>"
                . "{$this->name}/css/style.css"
                . "</div>";
        echo $str;
    }
    
    
    
    /*--------------------------------------------------*/
    
    
    public function setName(
            $name
    ){
        $this->name = $name;
    }
    
    
    /*--------------------------------------------------*/
    
    
    
    
    
    
    
    
    
}
//try{
//    $dir = readline("DIR: ");
//    $obj = readline("Obj: ");
//    $view = new \View($dir);
//    $view->show($obj);
//}
//catch(\Exception $e){
//    echo $e->getMessage(). "\n";
//}









