<?php

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //��������� �������� ����� (�����, ������ ���� �������� � ���������� ��������
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //���������� ���������� ��� ������ � ��
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';

error_reporting(E_ALL); //�������� ����� ������
set_time_limit(600); //������������� ������������ ����� ������ ������� � ��������
ini_set('display_errors', 1); //��� ���� ����� ������
ini_set('memory_limit', '512M'); //������������� ����������� ������ �� ������ (512��)



$subcount1 = $_GET["subcount1"];
$subcount2 = $_GET["subcount2"];
$timeStamp = $_GET["timeStamp"];
$date = date("Ymd", $timeStamp);
$path = "/1310/";
if ($subcount1){
    $path .= "bySubcount1/".$subcount1. "/";
}
if ($subcount2){
    if (!$subcount1){
        $path .= "bySubcount2/";
    }
    $path .= $subcount2. "/";
}

$dbt = \Reports::getBalance($path, "dbt", $date);
$crt = \Reports::getBalance($path, "crt", $date);

echo "������: {$crt}; �����: {$dbt}";












