<?php

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //��������� �������� ����� (�����, ������ ���� �������� � ���������� ��������
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //���������� ���������� ��� ������ � ��
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
require_once $_SERVER['DOCUMENT_ROOT']."/_modules/warehouse/php/components/MinBalanceTable/php/Viewer.php";

error_reporting(E_ALL); //�������� ����� ������
set_time_limit(600); //������������� ������������ ����� ������ ������� � ��������
ini_set('display_errors', 1); //��� ���� ����� ������
ini_set('memory_limit', '512M'); //������������� ����������� ������ �� ������ (512��)

$model = new \MinBalanceTable();
$view = new \Viewer("/_modules/warehouse/php/components/MinBalanceTable/views");

$action = $_GET["action"];

if ($action == "add"){
    $subcount1 = $_GET["subcount1"];
    $subcount2 = $_GET["subcount2"];
    $count = $_GET["count"];
    $result = $model->add($subcount1, $subcount2, $count);
    if ($result == 1){
        echo "<h2>������ ���������<h2>";
    }
    if ($result == 2){
        echo "<h2>������ ��������<h2>";
    }
    
}
/*--------------------------------------------------*/
if ($action == "getTable"){
    $subcount1 = isset($_GET["subcount1"]) ? $_GET["subcount1"] : "";
    $subcount2 = isset($_GET["subcount2"]) ? $_GET["subcount2"] : "";
    
    $table = $model->getTable($subcount1, $subcount2);
    $headerBlockList = [
        [
            "label" => "�����",
            "id" => "filter_subcount1",
            "type" => "text"
        ],
        [
            "label" => "��������",
            "id" => "filter_subcount2",
            "type" => "text"
        ],
        [
            "label" => "�������� ������ ��������",
            "id" => "filter_notFull",
            "type" => "checkbox"
        ]
    ];
    $tableButtonList = [
        [
            "name" => "��������",
            "onclick" => "showAddMinBalanceForm(`{$subcount1}`)"
        ]
    ];
    foreach($headerBlockList as $block){
        $view->addHeaderBlock($block);
    }
    
    foreach($table as $row){
        $result = [];
        foreach($row as $key => $value){
            switch ($key):
                case "subcount1":
                case "subcount2":
                    $subcount = new \Subcount($value);
                    $result[$key] = [
                        "name" => $subcount->getName(),
                        "id" => $value
                    ];
                    break;
                case "curCount":
                case "minCount":
                    $result[$key] = [
                        "name" => $value
                    ];
            endswitch;
        }
        $view->addRow($result);
    }
    foreach($tableButtonList as $button){
        $view->addTableButton($button);
    }
    $view->show();
}
/*--------------------------------------------------*/
if ($action == "getAddForm"){
    $view->show("addForm");
}

if ($action == "delete"){
    $subcount1 = $_GET["subcount1"];
    $subcount2 = $_GET["subcount2"];
    $result = $model->delete($subcount1, $subcount2);
    echo $result;
}









































