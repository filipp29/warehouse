<?php

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //��������� �������� ����� (�����, ������ ���� �������� � ���������� ��������
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //���������� ���������� ��� ������ � ��
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';

error_reporting(E_ALL); //�������� ����� ������
set_time_limit(600); //������������� ������������ ����� ������ ������� � ��������
ini_set('display_errors', 1); //��� ���� ����� ������
ini_set('memory_limit', '512M'); //������������� ����������� ������ �� ������ (512��)


$str = $_GET["data"];
$dec = new \Decoder();

$data = $dec->strToArray($str);

$type = $data["type"];
$name = $data["name"];
$params = $data["params"];
(key_exists("org", $_GET)) ? $org = $_GET["org"]: $org = "";
if (!$org){
    $org = "default";
}
setOrgAll($org);



echo \Subcount::create($type, $name, $params);
























