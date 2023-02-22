<?php


$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //”казываем корневую папку (нужно, только если работаем с консольным скриптом
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_lib/libProfiles.php';
error_reporting(E_ALL); //¬ключаем вывод ошибок
set_time_limit(600); //”станавливаем максимальное врем€ работы скрипта в секундах
ini_set('display_errors', 1); //≈ще один вывод ошибок
ini_set('memory_limit', '512M'); //”станавливаем ограничение пам€ти на скрипт (512ћб)


/*--------------------------------------------------*/


function srt(
        $a,
        $b
){
    return ((int)$b["timeStamp"] - (int)$a["timeStamp"]);
}

setOrgAll("");
/*--------------------------------------------------*/
$timeStamp1 = $_GET["timeStamp1"];
$timeStamp2 = $_GET["timeStamp2"];
$type = $_GET["type"];
$view = new \View2("/_modules/warehouse/views/JournalView/");
$docList = \Document::getDocList($type, $timeStamp1, $timeStamp2);
usort($docList, "srt");
foreach($docList as $doc){
    
    $data = [
        "onclick" => "getDocumentForm('{$doc['id']}')"
    ];
    $profile = $_COOKIE["login"];
    $src = new \Subcount($doc["src"]);
    $dst = new \Subcount($doc["dst"]);
    $buf = new \Document($doc["id"]);
    $show = false;
    if (($src->getType() == "warehouse") && ($src->getParams("inCharge") == $profile) ||
            ($dst->getType() == "warehouse") && ($dst->getParams("inCharge") == $profile) ||
            ($dst->getType() == "profile") && ($dst->getParams("login") == $profile) ||
            ((in_array($profile, $buf->getSubmitList())))
        ){
        $show = true;
        
    }
    $level = (int)getAccessLevel();
    if ($level == 1){
        $show = true;
    }
    $subordinateList = getSubordinateList($profile);
    $subordinateList[] = $_COOKIE["login"];
    
    if (in_array($doc["author"], $subordinateList)){
        $show = true;
    }
    if (!$show){
        continue;
    }
    $confirm = (count_u($buf->getSubmitList()) > 0);
    $colorEx = !$confirm ? "" : "color:blue;";
    $colorEx = $buf->isExecuted() ? $colorEx : "color:red;";
    $view->show("table.row.header",$data);
    {
        $data = [
            "text" => date("d.m.Y H:i:s",$doc['timeStamp']),
            "style" => "" . $colorEx
        ];
        
        $view->show("table.cell.data",$data);
        
    }
    {
        $data = [
            "text" => $src->getName(),
            "style" => "". $colorEx
        ];
        $view->show("table.cell.data",$data);
        
    }
    {
        $data = [
            "text" => $dst->getName(),
            "style" => "". $colorEx
        ];
        $view->show("table.cell.data",$data);
        
    }
    {
        $data = [
            "text" => profileGetUsername($doc["author"]),
            "style" => "". $colorEx
        ];
        $view->show("table.cell.data",$data);
        
    }
    $view->show("table.row.footer");
}
























