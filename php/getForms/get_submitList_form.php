<?php


$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //��������� �������� ����� (�����, ������ ���� �������� � ���������� ��������
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
error_reporting(E_ALL); //�������� ����� ������
set_time_limit(600); //������������� ������������ ����� ������ ������� � ��������
ini_set('display_errors', 1); //��� ���� ����� ������
ini_set('memory_limit', '512M'); //������������� ����������� ������ �� ������ (512��)


$id = $_GET["docId"];
$doc = new \Document($id);
$submitList = $doc->getSubmitList();

foreach($submitList as $key => $value){
    $str = "<h3 style='color: var(--modColor_darkest); width: 100%; text-align: center;'>{$value}</h3>";
    echo $str;
}


