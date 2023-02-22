<?php

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //��������� �������� ����� (�����, ������ ���� �������� � ���������� ��������
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //���������� ���������� ��� ������ � ��
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';

error_reporting(E_ALL); //�������� ����� ������
set_time_limit(600); //������������� ������������ ����� ������ ������� � ��������
ini_set('display_errors', 1); //��� ���� ����� ������
ini_set('memory_limit', '512M'); //������������� ����������� ������ �� ������ (512��)


function showSelect(
        $id,
        $name,
        $ar,
        $view
){
    $data = [];
    $data["id"] = $id;
    $data["name"] = $name;
    $view->show("select.header", $data);
    foreach($ar as $v){
        $data = [
            "value" => $v["value"],
            "name" => $v["name"]
        ];
        $view->show("select.data",$data);
    }
    $view->show("select.footer");
}



/*--------------------------------------------------*/

if (!$org){
    $org = "default";
}
setOrgAll($org);


$view = new \View2("/_modules/warehouse/views/createSubcountForm/");

$type = $_GET["type"];
try{
    if (!$type){
        $typeList = \Subcount::getTypeList();
        $data = [
            "func" => "submitType()"
        ];
        $view->show("header",$data);
        $ar = [];
        foreach($typeList as $k => $v){
            $ar[] = [
                "value" => $k,
                "name" => $v
            ];
        }
        showSelect("type", "���", $ar, $view);
        $data = [
            "flag" => true
        ];
        $view->show("footer", $data);
    }
    else{
        
        $data = [
            "func" => "submitParams()"
        ];
        $view->show("header",$data);
        $paramList = \Subcount::getParamList($type);
        foreach($paramList as $key => $value){
            switch ($value["type"]):
                case "select" :
                    $buf = \Subcount::getParamValues($type, $key);
                    $ar = [];
                    
                    foreach($buf as $k => $v){
                        $ar[] = [
                            "value" => $k,
                            "name" => $v
                        ];
                        
                    }
                    showSelect($key, $value["name"] , $ar, $view);
                    break;
                case "list":
                    $buf = \Subcount::getParamValues($type, $key);
                    $ar = [];
                    foreach($buf as $v){
                        $ar[] = [
                            "value" => $v,
                            "name" => $v
                        ];
                    }
                    showSelect($key, $value["name"] , $ar, $view);
                    break;
            endswitch;
        }
        $data = [
            "type" => $type
        ];
        $view->show("footer",$data);
    }
}
catch(\Exception $e){
    echo $e->getMessage();
}


























