<?php


$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //��������� �������� ����� (�����, ������ ���� �������� � ���������� ��������
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //���������� ���������� ��� ������ � ��
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/Subcount.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/View2.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/Entry.php';
error_reporting(E_ALL); //�������� ����� ������
set_time_limit(600); //������������� ������������ ����� ������ ������� � ��������
ini_set('display_errors', 1); //��� ���� ����� ������
ini_set('memory_limit', '512M'); //������������� ����������� ������ �� ������ (512��)



function showSelect(
        $id,
        $name,
        $ar,
        $view
){
    $data = [];
    $data["id"] = $id;
    $data["name"] = $name;
    $view->show("select.header", $data);
    foreach($ar as $v){
        $data = [
            "value" => $v["id"],
            "name" => $v["name"]
        ];
        $view->show("select.data",$data);
    }
    $view->show("select.footer");
}


if (!$org){
    $org = "default";
}
setOrgAll($org);

$view = new \View2("/_modules/warehouse/views/createEntryForm/");
$wareList = \Subcount::getSubcountList("warehouse", true);
$matList = \Subcount::getSubcountList("material", true);
$view->show("header", $data);
showSelect("src", "����� ��������", $wareList,$view);
showSelect("dst", "����� ����������", $wareList,$view);
showSelect("material", "��������", $matList,$view);

$view->show("footer", $data);

















