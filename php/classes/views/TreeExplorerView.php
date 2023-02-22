<?php


error_reporting(E_ALL); //Включаем вывод ошибок
set_time_limit(600); //Устанавливаем максимальное время работы скрипта в секундах
ini_set('display_errors', 1); //Еще один вывод ошибок
ini_set('memory_limit', '512M'); //Устанавливаем ограничение памяти на скрипт (512Мб)

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';

class TreeExplorerView {
    static private $path = "/_modules/warehouse/views/TreeExplorerView/";
    
    static private function makeString(
            $ar
    ){
        $result = "";
        foreach($ar as $key => $value){
            $result .= " {$key}='{$value}'";
        }
        return $result;
    }
    
    /*--------------------------------------------------*/
    
    static public function showMenu(
            $level
    ){
        $view = new \View2(self::$path);
        $buttonList = [
            [
                "back" => [
                    "name" => "Назад",
                    "onclick" => "treeBack()"
                ],
                "makeDir" => [
                    "name" => "Создать папку",
                    "onclick" => "treeMakeDir()"
                ],
                "createFile" => [
                    "name" => "Создать файл",
                    "onclick" => "treeCreateFile()"
                ],
                "delete" => [
                    "name" => "Удалить",
                    "onclick" => "treeDeleteElement()"
                ]
            ],
            [
                "back" => [
                    "name" => "Назад",
                    "onclick" => "treeBack()"
                ]
            ]
        ];
        $data = [
            "class" => "treeMenu"
        ];
        $res = [
            "params" => self::makeString($data)
        ];
        $view->show("menu.header",$res);
        foreach($buttonList[$level] as $key => $value){
            $data = [
                "class" => "treeMenuButton",
                "onclick" => $value["onclick"]
            ];
            $res = [
                "params" => self::makeString($data),
                "text" => $value["name"]
            ];
            $view->show("button",$res);
        }
        $view->show("menu.footer");
    }
    
    /*--------------------------------------------------*/
}
