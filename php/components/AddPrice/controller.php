<?php
$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //��������� �������� ����� (�����, ������ ���� �������� � ���������� ��������
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //���������� ���������� ��� ������ � ��
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';

error_reporting(E_ALL); //�������� ����� ������
set_time_limit(600); //������������� ������������ ����� ������ ������� � ��������
ini_set('display_errors', 1); //��� ���� ����� ������
ini_set('memory_limit', '512M'); //������������� ����������� ������ �� ������ (512��)


function getForm(){
    $id = $_GET["id"];
    $view = new \View2("/_modules/warehouse/php/components/AddPrice/");
    $data = [
        "id" => $id,
        "date" => date("Y-m-d\TH:i",time())
    ];
    $view->show("main", $data);
}

function addPrice(){
    $id = $_GET["id"];
    $timeStamp = $_GET["timeStamp"];
    $price = $_GET["price"];

    $subcount = new \Subcount($id);
    $subcount->addPrice($price, $timeStamp);
    echo "1 - {$price}; 2 - {$timeStamp}";
}





$action = $_GET["action"];

switch ($action):
    case "getForm":
        getForm();
        break;
    case "addPrice":
        addPrice();
        break;
endswitch;







