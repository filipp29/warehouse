<?php

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //��������� �������� ����� (�����, ������ ���� �������� � ���������� ��������
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //���������� ���������� ��� ������ � ��
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';


error_reporting(E_ALL); //�������� ����� ������
set_time_limit(600); //������������� ������������ ����� ������ ������� � ��������
ini_set('display_errors', 1); //��� ���� ����� ������
ini_set('memory_limit', '512M'); //������������� ����������� ������ �� ������ (512��)
date_default_timezone_set("Asia/Almaty");





/*--------------------------------------------------*/

function getTableBy2(
        $data
){
    $typeName = [
        "crt" => "�����",
        "dbt" => "������"
    ];
    extract($data);
    
    $result = \Entry::getManyBy2($subcount1, $subcount2, $timeStamp1, $timeStamp2,$byType1,$byType2,$account);
    $sub1 = new \Subcount($subcount1);
    $sub2 = new \Subcount($subcount2);
    $name1 = $sub1->getName();
    $name2 = $sub2->getName();
    $data = [
        "title" => "�������� �� {$name1} - {$name2}"
    ];
    $view->show("reportHeader.header", $data);
    $view->show("reportHeader.footer", $data);
    $view->show("table.header_entry");
    foreach($result as $subcount => $typeList){
        $sub = new \Subcount($subcount);

        $data = [
            "style" => "background-color: #25CCF7; text-align: center;",
            "class" => "groupRow"
        ];
        $view->show("table.row.header",$data);

        $data = [
            "text" => $sub->getName(),
            "colspan" => 3
        ];
        $view->show("table.cell.data", $data);
        $view->show("table.row.footer");
        foreach($typeList as $type => $entryList){
//            $data = [
//            "style" => "background-color: #c9dbc8"
//            ];
//            $view->show("table.row.header",$data);
//            $data = [
//                "text" => $typeName[$type],
//                "colspan" => 3
//            ];
//            $view->show("table.cell.data", $data);
//            $view->show("table.row.footer");
            foreach($entryList as $entry){
                $data = [
                    "style" => ($type == "crt") ? "background-color: #FA8072" : "background-color: #00FF7F",
                    "onclick" => "getDocumentForm('{$entry["docId"]}')"
                ];
                $view->show("table.row.header",$data);
                $data = [
                    "text" => ($type == "crt") ? "������" : "������"
                ];
                $view->show("table.cell.data",$data);
                $data = [
                    "text" => date("d.m.Y H:i:s", explode(".",$entry["id"])[0])
                ];
                $view->show("table.cell.data",$data);
                $data = [
                    "text" => $entry["count"]
                ];
                $view->show("table.cell.data",$data);
                $view->show("table.row.footer");
            }
        }
    }
}



/*--------------------------------------------------*/



function getTableBy3(
        $data
){
    $typeName = [
        "dbt" => "�����",
        "crt" => "������"
    ];
    extract($data);
    $result = \Entry::getManyBy3($subcount1, $subcount2, $subcount3, $timeStamp1, $timeStamp2,$byType1,$byType2, $byType3);
    $sub1 = new \Subcount($subcount1);
    $sub2 = new \Subcount($subcount2);
    $sub3 = new \Subcount($subcount3);
    $name1 = $sub1->getName();
    $name2 = $sub2->getName();
    $name3 = $sub3->getName();
    $data = [
        "title" => "�������� ��  [{$name1} - {$name2} - {$name3}]"
    ];
    $view->show("reportHeader.header", $data);
    $view->show("reportHeader.footer", $data);
    $view->show("table.header_entry");
    
    
    foreach($result as $type => $typeList){
//        $data = [
//        "style" => "background-color: #c9dbc8"
//        ];
//        $view->show("table.row.header",$data);
//        $data = [
//            "text" => $typeName[$type],
//            "colspan" => 3
//        ];
//        $view->show("table.cell.data", $data);
//        $view->show("table.row.footer");
        foreach($typeList as $entry){
//            $data = [
//                "style" => "background-color: #c8cedb",
//                "onclick" => "getDocumentForm('{$entry["docId"]}')"
//            ];
//            $view->show("table.row.header",$data);
//            $view->show("table.cell.data");
//            $data = [
//                "text" => date("d.m.Y H:i:s", explode(".",$entry["id"])[0])
//            ];
//            $view->show("table.cell.data",$data);
//            $data = [
//                "text" => $entry["count"]
//            ];
//            $view->show("table.cell.data",$data);
//            $view->show("table.row.footer");
            $data = [
                "style" => ($type == "crt") ? "background-color: #FA8072" : "background-color: #00FF7F",
                "onclick" => "getDocumentForm('{$entry["docId"]}')"
            ];
            $view->show("table.row.header",$data);
            $data = [
                "text" => ($type == "crt") ? "������" : "������"
            ];
            $view->show("table.cell.data",$data);
            $data = [
                "text" => date("d.m.Y H:i:s", explode(".",$entry["id"])[0])
            ];
            $view->show("table.cell.data",$data);
            $data = [
                "text" => $entry["count"]
            ];
            $view->show("table.cell.data",$data);
            $view->show("table.row.footer");
        }
    }
    $view->show("table.footer");
    
    
    
}



/*--------------------------------------------------*/


$str = $_GET["data"];
$dec = new \Decoder();

$data = $dec->strToArray($str);


$view = new \View2("/_modules/warehouse/views/ReportView/");

$view->show("header");

$data["view"] = $view;

if (!isset($data["subcount3"])){
    getTableBy2($data);
}
else{
    getTableBy3($data);
}

$view->show("table.footer");
$view->show("footer");



















