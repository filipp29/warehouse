<?php
$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //��������� �������� ����� (�����, ������ ���� �������� � ���������� ��������
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //���������� ���������� ��� ������ � ��
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';

error_reporting(E_ALL); //�������� ����� ������
set_time_limit(600); //������������� ������������ ����� ������ ������� � ��������
ini_set('display_errors', 1); //��� ���� ����� ������
ini_set('memory_limit', '512M'); //������������� ����������� ������ �� ������ (512��)

/*--------------------------------------------------*/

function getCreateForm(){
    global $view;
    $view->show("createForm");
    
}

/*--------------------------------------------------*/

function createRequest(){
    global $view;
    global $material;
    global $warehouse;
    global $count;
    $result = \Request::create($warehouse, $material, $count);
    switch ($result):
        case 0:
            $data = [
                "text" => "������ �������"
            ];
            break;
        case 1:
            $data = [
                "text" => "������ ��� �������"
            ];
            break;
        default :
            $data = [
                "text" => "������"
            ];
            break;
    endswitch;
    $view->show("message", $data);
}

/*--------------------------------------------------*/

function getTable(){
    global $view;
    
    $table = \Request::getTable();
    
    $tbody = "";
    foreach($table as $v){
        $trow = "";
        $profile = $_COOKIE["login"];
        if (($profile != "kodola") && ($profile != $v["author"])){
            continue;
        }
        if ($v["submit"] == "0"){
            $color = "#FA8072";
        }
        else{
            $color = "#00FF7F";
        }
        $data = [
            "params" => [
                "dataId" => $v["timeStamp"],
                "style" => "background-color: {$color}"
            ],
            "text" => date("H:i - d.m.Y")
        ];
        $trow .= $view->show("table.cell", $data, true);
        $data = [
            "params" => [
                "dataId" => $v["warehouseId"],
                "style" => "background-color: {$color}"
            ],
            "text" => $v["warehouseName"]
        ];
        $trow .= $view->show("table.cell", $data, true);
        $data = [
            "params" => [
                "dataId" => $v["materialId"],
                "style" => "background-color: {$color}"
            ],
            "text" => $v["materialName"]
        ];
        $trow .= $view->show("table.cell", $data, true);
        $data = [
            "params" => [
                "style" => "background-color: {$color}"
            ],
            "text" => $v["count"]
        ];
        $trow .= $view->show("table.cell", $data, true);
        if (($_COOKIE["login"] == "kodola")){
            $text = "<button style='margin: 0px; width: 100%; height: 100%' onclick='submitRequest(this)'>�����������</button>";
        }
        else{
            $text = "<button style='margin: 0px; width: 100%; height: 100%' onclick='deleteRequest(this)'>�������</button>";
        }
        $data = [
            "params" => [
                "style" => "background-color: {$color}"
            ],
            "text" => $text
        ];
        
        $trow .= $view->show("table.cell", $data, true);
        $data = [
            "content" => $trow
        ];
       
        $tbody .= $view->show("table.row", $data, true);
    }
    
    $data = [
        "tbody" => $tbody
    ];
    
    $view->show("main",$data);
    $view->addScriptStyle("requestTableForm");
}


/*--------------------------------------------------*/

function delete(){
    global $view;
    global $material;
    global $warehouse;
    return \Request::delete($warehouse, $material);
}

/*--------------------------------------------------*/

function submit(){
    global $view;
    global $material;
    global $warehouse;
    
    return \Request::submit($warehouse, $material);
}

/*--------------------------------------------------*/

$path = "/_modules/warehouse/php/components/Request";
$view = new \View2($path);
$material = isset($_GET["material"]) ? $_GET["material"] : "";
$warehouse = isset($_GET["warehouse"]) ? $_GET["warehouse"] : "";
$count = isset($_GET["count"]) ? $_GET["count"] : "";
$action = $_GET["action"];

switch ($action):
    case "createForm":
        getCreateForm();
        break;
    case "create":
        createRequest();
        break;
    case "getTable":
        getTable();
        break;
    case "delete":
        delete();
        break;
    case "submit":
        submit();
        break;
        
        
endswitch;













