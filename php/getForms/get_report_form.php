<?php
error_reporting(E_ALL); //�������� ����� ������
set_time_limit(600); //������������� ������������ ����� ������ ������� � ��������
ini_set('display_errors', 1); //��� ���� ����� ������
ini_set('memory_limit', '512M'); //������������� ����������� ������ �� ������ (512��)
date_default_timezone_set("Asia/Almaty");
$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //��������� �������� ����� (�����, ������ ���� �������� � ���������� ��������
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //���������� ���������� ��� ������ � ��
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';





setOrgAll("default");

$type = $_GET["type"];
checkAccessLevel(\ReportView::getAccessList()[$type]);
$horizontal = isset($_GET["horizontal"]) ? $_GET["horizontal"] : null;
try{
    if ($horizontal){
        \ReportView::showHorizontal($type);
    }
    else {
        \ReportView::show($type);
    }
}
catch(\Exception $e){
    $e->getMessage();
}
