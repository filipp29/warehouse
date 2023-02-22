<?php
$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //Подключаем библиотеку для работы с БД
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
require_once $_SERVER['DOCUMENT_ROOT']."/_modules/warehouse/php/components/TreeExplorer/php/Viewer.php";
require_once $_SERVER['DOCUMENT_ROOT']."/_modules/warehouse/php/classes/TreeExplorer.php";

error_reporting(E_ALL); //Включаем вывод ошибок
set_time_limit(600); //Устанавливаем максимальное время работы скрипта в секундах
ini_set('display_errors', 1); //Еще один вывод ошибок
ini_set('memory_limit', '512M'); //Устанавливаем ограничение памяти на скрипт (512Мб)

/*--------------------------------------------------*/


function utf(
    $str
){
    if (is_array($str)){
        $result = [];
        foreach ($str as $key => $value){
            $result[$key] = utf($value);
        }
        return $result;
    }
    else{
        return iconv("windows-1251", "utf-8", $str);
    }
}

/*--------------------------------------------------*/



function win(
        $str
){
    if (is_array($str)){
        $result = [];
        foreach ($str as $key => $value){
            $result[$key] = win($value);
        }

        return $result;
    }
    else{
        return iconv("utf-8", "windows-1251", $str);
    }

}



/*--------------------------------------------------*/




/*--------------------------------------------------*/

function getTree(){
    global $model;
    global $path;
    global $view;
    $dirList = $model->getDirList();
    $fileList = $model->getFileList();
    $elementList = [];
    foreach($dirList as $key => $value){
        $elementList[] = [
            "name" => $value,
            "id" => $key,
            "imgPath" => "/_img/icoFolder32.png",
            "rowOnclick" => "openFolder(`{$key}`)",
            "type" => "folder"
        ];
    }
    foreach($fileList as $key => $value){
        $elementList[] = [
            "name" => $value,
            "id" => $key,
            "imgPath" => "/_img/icoBill32g.png",
            "rowOnclick" => "openFile(`{$key}`)",
            "type" => "file"
        ];
    }

    $buttonList = [
        [
            "name" => "Назад",
            "onclick" => "back()"
        ],
        [
            "name" => "Создать папку",
            "onclick" => "createFolderForm()"
        ],
        [
            "name" => "Создать файл",
            "onclick" => "createFileForm()"
        ],
        [
            "name" => "Удалить",
            "onclick" => "deleteTreeElement()"
        ]
    ];
    /*--------------------------------------------------*/
    $menu = $view->show("inc.mainMenu", compact("buttonList"), true);
    $content = $view->show("inc.list", compact("elementList"), true);
    //echo $model->getPathName()."<br>";
    $data = [
        "path" => [
            "params" => toStr([
                "data_path" => $path,
                "class" => "explorerPath",
                "id" => "explorerPath"
            ]),
            "text" => $model->getPathName()
        ],
        "mainMenu" => [
            "text" => $menu
        ],
        "contentBox" => [
            "text" => $content
        ]
    ];
    $view->show("main", $data);
}

/*--------------------------------------------------*/

function createFolder(){
    global $model;
    global $path;
    global $view;
    global $name;
    
    $model->makeDir($name);
    getTree();
    
}

/*--------------------------------------------------*/

function createFile(){
    global $model;
    global $params;
    global $name;
    $data = json_decode($params, true);
    $model->createFile($name, $data);
    
    getTree();
}

/*--------------------------------------------------*/

function delete(){
    global $model;
    global $id;
    global $type;
    if ($type == "file"){
        $model->deleteFile($id);
    }
    if ($type == "folder"){
        $model->deleteDir($id);
    }
    getTree();
}

/*--------------------------------------------------*/

function getCreateFolderForm(){
    global $path;
    global $view;
    $data = [
        "path" => $path
    ];
    $view->show("createFolderForm",$data);
}

/*--------------------------------------------------*/

function getCreateFileForm(){
    global $path;
    global $view;
    $data = [
        "path" => $path
    ];
    $view->show("createFileForm",$data);
}

/*--------------------------------------------------*/

function getFile(){
    global $id;
    global $model;
    $data = utf($model->getFile($id));
    $result = json_encode($data, 256);
    echo iconv("utf-8", "windows-1251", $result);
}

/*--------------------------------------------------*/


$path = isset($_GET["path"]) ? $_GET["path"] : "";
$action = isset($_GET["action"]) ? $_GET["action"] : "";
$model = new \TreeExplorer($path);
$view = new \View2("/_modules/warehouse/php/components/TreeExplorer/");

switch ($action):
    case "get":
        getTree();
        break;
    case "createFolder":
        $name = isset($_GET["name"]) ? $_GET["name"] : "";
        createFolder();
        break;
    case "createFile":
        $params = isset($_GET["params"]) ? $_GET["params"] : "";
        $name = isset($_GET["name"]) ? $_GET["name"] : "";
        createFile();
        break;
    case "delete":
        $type = isset($_GET["type"]) ? $_GET["type"] : "";
        $id = isset($_GET["id"]) ? $_GET["id"] : "";
        delete();
        break;
    case "getCreateFolderForm":
        getCreateFolderForm();
        break;
    case "getCreateFileForm":
        getCreateFileForm();
        break;
    case "getFile":
        $id = $_GET["id"];
        getFile();
        break;
endswitch;









