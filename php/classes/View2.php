<?php

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net';


/*--------------------------------------------------*/
/*--------------------------------------------------*/
/*
 * 
 * ����� ������������ ��� �������� ����������������� ���������� �� ��������.
 * ������ ����� ����������� ���������, � ������� html �������� ������� �� ���������� ��������.
 * ����� � �������� ������ ����� ������������ ����� html_templates � ������� � ��������� ���-�������.
 * ������ ������� ����� ����� �������� ��������. ���� ������� �� ����� ��������, �� �� �������� � ���� 
 * ����� php � html ��������. ���� � �������� ���� �������, �� ����� ������� �������� ������� ��������� 
 * � ������������ ����� ���������� ���������� ���� ��� ��������, ��� ������� �� ����� ������� ��� �����������.
 * � ������� ������ ������ �������� � ���� �������������� ������� ["��� ��������" => "��������"]
 * ��������� � �������� �������������� �� ������� ���� � ������ "parent1.parent2.child"
 * 
 * ---------------------------------------------------
 * �������� ------------------------------------------
 * 
 * pr $path - ���� � ����� �������
 * 
 * pr $tree - ������ � ������� ��������
 * 
 * pr $css - ���� � ����� css
 * 
 * pr $script - ���� � ����� js
 * 
 * ---------------------------------------------------
 * ����������� ������---------------------------------
 * 
 * �����������
 * 
 * ---------------------------------------------------
 * ��������� ������ ����������
 * 
 * __construct(path) - ������� ��������� ������ �� ������� �� ����� path. 
 *      ������������� ��������� �������� $tree, $css, $script. ���������� ����������
 *      ���� ����� � �������� ���, ���� �� ����������� ���������.
 * 
 * getTree() - ���������� ������ $tree
 * 
 * setName() - ������������� ���
 * 
 * show(_fileName_, data) - ������� �� ����� ������ � �������������� ����������.
 *      _fileName_ - ���� � ������ � ������� ���� "parent1.parent2.child", 
 *      data - ������ ��� ������� � ������ � ���� ������� ["����" => "��������"].
 *      ������ data ������������� ������������ ����� extract(). ������� ����� ������� 
 *      ������ ��������� � ������� ���������� � �������. 
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









