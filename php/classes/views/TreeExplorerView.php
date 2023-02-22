<?php


error_reporting(E_ALL); //�������� ����� ������
set_time_limit(600); //������������� ������������ ����� ������ ������� � ��������
ini_set('display_errors', 1); //��� ���� ����� ������
ini_set('memory_limit', '512M'); //������������� ����������� ������ �� ������ (512��)

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //��������� �������� ����� (�����, ������ ���� �������� � ���������� ��������
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
                    "name" => "�����",
                    "onclick" => "treeBack()"
                ],
                "makeDir" => [
                    "name" => "������� �����",
                    "onclick" => "treeMakeDir()"
                ],
                "createFile" => [
                    "name" => "������� ����",
                    "onclick" => "treeCreateFile()"
                ],
                "delete" => [
                    "name" => "�������",
                    "onclick" => "treeDeleteElement()"
                ]
            ],
            [
                "back" => [
                    "name" => "�����",
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
