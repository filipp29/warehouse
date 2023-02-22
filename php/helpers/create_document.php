<?php

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //��������� �������� ����� (�����, ������ ���� �������� � ���������� ��������
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //���������� ���������� ��� ������ � ��
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libProfiles.php');
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';

error_reporting(E_ALL); //�������� ����� ������
set_time_limit(600); //������������� ������������ ����� ������ ������� � ��������
ini_set('display_errors', 1); //��� ���� ����� ������
ini_set('memory_limit', '512M'); //������������� ����������� ������ �� ������ (512��)

/*--------------------------------------------------*/

function extra_income(
        $doc
){
    $result = [];
    $table = $doc->getTable();
    
    $timeStamp = $doc->getHeader()["timeStamp"];
    
    foreach($table as $key => $value){
        $subcount = new \Subcount($value["id"]);
        $subcount->addPrice($value["price"], $timeStamp);
    }
}

/*--------------------------------------------------*/

function extra_transfer(
        $doc
){
    $dst = $doc->getHeader()["dst"];
    $subcount = new \subCount($dst);
    $profile = $subcount->getParams("inCharge");
    $data = [
        $profile => profileGetUsername($profile)
    ];
    $doc->setSubmitList($data);
}

/*--------------------------------------------------*/

function extra_toWorker(
        $doc
){
    $dst = $doc->getHeader()["dst"];
    $subcount = new \subCount($dst);
    $profile = $subcount->getParams("login");
    $data = [
        $profile => profileGetUsername($profile)
    ];
    $doc->setSubmitList($data);
}

/*--------------------------------------------------*/

function extraActions(
        $doc
){
    $header = $doc->getHeader();
    switch ($header["type"]){
        case "income":
            extra_income($doc);
            break;
        case "transfer":
            extra_transfer($doc);
            break;
        case "toWorker":
            extra_toWorker($doc);
            break;
    }
    
}

/*--------------------------------------------------*/

$headerKeys = [
    "src",
    "dst",
    "timeStamp",
    "account",
    "author",
    "type"
];
try{
    $str = $_GET["data"];
    $dec = new \Decoder();
    $data = $dec->strToArray($str);
    $header = $data["header"];
    $table = $data["table"];
    $comment = $data["comment"];
    key_exists("org", $_GET) ? $org = $_GET["org"] : $org = null;
    if (!$org){
        $org = "default";
    }
    setOrgAll($org);
    if (!isset($header["timeStamp"])){
        $header["timeStamp"] = time();
    }
    if (!$header["account"]){
        $header["account"] = "1310";
    }
    if (!$header["author"]){
        $header["author"] = "_system";
    }
    $docId = \Document::create($header);

    $doc = new \Document($docId);
    
    foreach($table as $row){
        $doc->addRow($row["id"], $row["price"], $row["count"]);
    }
    
    foreach($comment as $key => $value){
        $doc->addComment($key, $value);
    }
    
    
//    if ((($_COOKIE["login"] == "filipp") || ($_COOKIE["login"] == "filipp"))&&($header["type"] == "transfer")){
//        $doc->save(false);
//    }
//    else{
//        $doc->save();
//    }
    if ($header["type"] == "expenseWorker"){
        $doc->save(false);
    }
    else{
        $doc->save();
    }
    if(isset($header["account"]) &&($header["account"] == "2410")){
        $doc->saveAssets();
    }
    extraActions($doc);
}
catch(\Exception $e){
    echo $e->getMessage();
}

print_r($docId);











