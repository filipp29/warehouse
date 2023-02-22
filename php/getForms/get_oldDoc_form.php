<?php

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //��������� �������� ����� (�����, ������ ���� �������� � ���������� ��������
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //���������� ���������� ��� ������ � ��
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libProfiles.php');
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';


error_reporting(E_ALL); //�������� ����� ������
set_time_limit(600); //������������� ������������ ����� ������ ������� � ��������
ini_set('display_errors', 1); //��� ���� ����� ������
ini_set('memory_limit', '512M'); //������������� ����������� ������ �� ������ (512��)
date_default_timezone_set("Asia/Almaty");



setOrgAll("default");

$id = $_GET["docId"];
$docParams = \Document::getDocParams($id);

$type = $docParams["header"]["type"];
$print = isset($_GET["print"]) ? true : false;
try{
    $docView = new \DocumentView($type);
    $result = \Document::getDocParams($id);
    $header = $result["header"];
    $comment = $result["comment"];
    $subcount = new \Subcount($header["src"]);
    $header["srcName"] = $subcount->getName();
    $subcount = new \Subcount($header["dst"]);
    $header["dstName"] = $subcount->getName();
    
    $header["authorName"] = profileGetUsername($header["author"]);
    $buf = $result["table"];
    $table = [];
    $i = 0;
    foreach($buf as $k => $v){
        $subcount = new \Subcount($v["id"]);
        $table[$i][0] = $v["id"];
        $table[$i][1] = $v["price"];
        $table[$i][2] = $v["count"];
        $table[$i][3] = $subcount->getParams("units");
        $i++;
    }
    $docView->setParams($id, $header, $table,$comment);
    $docView->setPrint($print);
    $docView->show();
}
catch(\Exception $e){
    $e->getMessage();
}




















