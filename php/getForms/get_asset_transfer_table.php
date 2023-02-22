<?php


$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //��������� �������� ����� (�����, ������ ���� �������� � ���������� ��������
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_lib/libProfiles.php';
error_reporting(E_ALL); //�������� ����� ������
set_time_limit(600); //������������� ������������ ����� ������ ������� � ��������
ini_set('display_errors', 1); //��� ���� ����� ������
ini_set('memory_limit', '512M'); //������������� ����������� ������ �� ������ (512��)


$id = $_GET["id"];
$view = new \View2("/_modules/warehouse/views/ReportView/");


$subcount = new \Subcount($id);
$history = $subcount->getHistory();
$view->show("header");
$view->show("table.header_asset_transfer");
foreach($history as $key => $value){
    $view->show("table.row.header");
    $data = [
      "text" => date("H:i:s d.m.Y",$value["timeStamp"])  
    ];
    $view->show("table.cell.data", $data);
    $location = new \Subcount($value["location"]);
    $data = [
        "text" => $location->getName()
    ];
    $view->show("table.cell.data", $data);
    if (isset($value["author"])){
        $data = [
            "text" => profileGetUsername($value["author"])
        ];
    }
    else{
        $data = [
            "text" => ""
        ];
    }
    $view->show("table.cell.data",$data);
    $view->show("table.row.footer");
}
$view->show("table.footer");
$view->show("footer");










