<?php


$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //��������� �������� ����� (�����, ������ ���� �������� � ���������� ��������
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
error_reporting(E_ALL); //�������� ����� ������
set_time_limit(600); //������������� ������������ ����� ������ ������� � ��������
ini_set('display_errors', 1); //��� ���� ����� ������
ini_set('memory_limit', '512M'); //������������� ����������� ������ �� ������ (512��)


$timeStamp2 = $_GET["timeStamp"];
$subcount1 = $_GET["subcount1"];
$subcount2 = $_GET["material"];
$byType1 = "bySubcount1";
$byType2 = "bySubcount2";
$account = "1310";
$dateAfter = date("Ymd", $timeStamp2);

$crtAfter = (int)\Reports::getBalance("{$account}/{$byType1}/{$subcount1}/{$byType2}/{$subcount2}/", "crt", $dateAfter);
$dbtAfter = (int)\Reports::getBalance("{$account}/{$byType1}/{$subcount1}/{$byType2}/{$subcount2}/", "dbt", $dateAfter);
$crtAfter += (int)\Entry::getDailyBy2($timeStamp2, $subcount1, $subcount2, "crt",$byType1,$byType2,$account);
$dbtAfter += (int)\Entry::getDailyBy2($timeStamp2, $subcount1, $subcount2, "dbt",$byType1,$byType2,$account);
$count = $dbtAfter - $crtAfter;
echo "(� ������� - <span id='count'>{$count}</span>)";





