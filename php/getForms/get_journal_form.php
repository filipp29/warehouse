<?php

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //��������� �������� ����� (�����, ������ ���� �������� � ���������� ��������
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';

error_reporting(E_ALL); //�������� ����� ������
set_time_limit(600); //������������� ������������ ����� ������ ������� � ��������
ini_set('display_errors', 1); //��� ���� ����� ������
ini_set('memory_limit', '512M'); //������������� ����������� ������ �� ������ (512��)

setOrgAll("default");
$type = $_GET["type"];
$horizontal = isset($_GET["horizontal"]) ? true : false;
try{
    if ($horizontal){
        \JournalView::showHorizontal($type);
    }
    else{
        \JournalView::show($type);
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}











