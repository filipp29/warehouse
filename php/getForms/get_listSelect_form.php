<?php


$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //��������� �������� ����� (�����, ������ ���� �������� � ���������� ��������
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/views/listSelectForm/php/base.php';

error_reporting(E_ALL); //�������� ����� ������
set_time_limit(600); //������������� ������������ ����� ������ ������� � ��������
ini_set('display_errors', 1); //��� ���� ����� ������
ini_set('memory_limit', '512M'); //������������� ����������� ������ �� ������ (512��)












/*--------------------------------------------------*/



$tableButtonParams = [
    "filterParamList" => [
        "name" => "������",
        "onclick" => "filterParamList()",
        
    ]
];

$str = iconv("UTF-8", "cp1251", $_POST['data']); 
//$str = $_GET["data"];
$dec = new Decoder();
$params = $dec->strToArray($str);
$view = new \View2("/_modules/warehouse/views/listSelectForm/");
$view->show("header");
$data = [
    "title" => ""
];
$view->show("listSelectHeader.header",$data);

$buttonParams = [
    "submitSelect" => [
        "name" => "OK",
        "onclick" => "submitListSelect()",
        "style" => "margin-right: 15px"
    ]
];
$data = [
    "id" => "_paramName",
    "label" => "������������",
    "type" => "text"
];
showInputBlock($view, $data);
$list = [];
$buttonList = [
    "filterParamList"
];
showTableButtonBlock($view, $buttonList, $tableButtonParams);
$view->show("listSelectHeader.footer");
if (key_exists("searchParams", $data)){
    $searchParams = $data["searchParams"];
}
else $searchParams = [];
if (key_exists("dir", $params)){
    $br = array_keys(objLoadBranch($params["dir"], false, true));
    foreach($br as $value){
        if ((key_exists("obj", $params)) && ($params["obj"])){
            $obj = objLoad($params["dir"]. "{$value}/{$params['obj']}");
            $correct = true;
            if ($searchParams){
                foreach($searchParams as $k => $v){
                    if ((key_exists($k, $searchParams)) && (!preg_match("/{$v}/i", $obj[$k]))){
                        $correct = false;
                        break;
                    }
                }
            }
            if ($correct){
                $list[] = [
                    "name" => $obj[$params["show"]],
                    "value" => $value
                ];
            }
        }
        else{
            $list[] = [
                "name" => $value,
                "value" => $value
            ];
        }
    }
}

if (key_exists("subcountType", $params)){
    if (key_exists("paramType", $params)){
        $paramValues = \Subcount::getParamValues($params["subcountType"], $params["paramType"]);
        foreach($paramValues as $value){
            $list[] = [
                "name" => $value,
                "value" => $value
            ];
        }
    }
    else{
        
    }
    
}

$view->show("table.header");
$i = 0;
foreach($list as $el){
    $data = [
        "class" => "",
        "onclick" => "",
        "style" => "",
    ];
    $view->show("table.row.header",$data);
    {
        $data = [
            "text" => $el['name'],
            "class" => "name",
            "onclick" => "selectListRow('{$el["value"]}')",
            "id" => $el["value"],
            "cosplan" => "",
            "style" => ""        
        ];
        $i++;
        $view->show("table.cell.data", $data);
    }
    $view->show("table.row.footer");
}




$view->show("table.footer");

$buttonList = [
    "submitSelect"
];
showButtonBlock($view, $buttonList, $buttonParams);
$view->show("footer");




















