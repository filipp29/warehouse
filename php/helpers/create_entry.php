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




$params["src"] = $_GET["src"];
$params["dst"] = $_GET["dst"];
$params["count"] = $_GET["count"];
$params["material"] = $_GET["material"];
$params["timeStamp"] = $_GET["timeStamp"];
$params["docId"] = $_GET["docId"];
$params["price"] = $_GET["price"];
$params["account"] = "1310";
$org = $_GET["org"];
if (!$org){
    $org = "default";
}
setOrgAll($org);
if (!$params["timeStamp"]){
    $params["timeStamp"] = time();
   
}
try{
//    $result = \Entry::create($account, $src, $dst, $material, $docId, $timeStamp);
    $result = \Entry::create($params);
    echo "�������� {$result} ���������";
}
catch(\Exception $e){
    echo $e->getMessage();
}















