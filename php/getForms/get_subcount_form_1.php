<?php

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/views/subcountForm/php/base.php';

error_reporting(E_ALL); //Включаем вывод ошибок
set_time_limit(600); //Устанавливаем максимальное время работы скрипта в секундах
ini_set('display_errors', 1); //Еще один вывод ошибок
ini_set('memory_limit', '512M'); //Устанавливаем ограничение памяти на скрипт (512Мб)



$id = $_GET["id"];
$subcount = new \Subcount($id);
$view = new \View2("/_modules/warehouse/views/subcountForm/");
$view->show("header");
$data = [
    "title" => \Subcount::getTypeList()[$subcount->getType()]
];
$view->show("baseHeader.header",$data);
$view->show("baseHeader.footer");
$view->show("table.header");
$params= [
    [
        "name" => "Имя",
         "value" => $subcount->getName()
    ],
    [
        "name" => "Тип",
        "value" => \Subcount::getTypeList()[$subcount->getType()]
    ],
    [
        "name" => "Номер",
        "value" => $subcount->getId()
    ]
];
foreach($subcount->getParams() as $k => $v){
    $params[] = [
        "name" => $subcount->getParamName($k),
        "value" => $v,
        "key" => $k
    ];
}
$paramList = \Subcount::getParamList($subcount->getType());
foreach($params as $k => $v){
    $view->show("table.row.header");
    {
        $data = [
            "text" => $v["name"]
        ];
        $view->show("table.cell.data",$data);
    }
    {   
        if ((isset($v["key"])) && (isset($paramList[$v["key"]]))){
            $buf = $paramList[$v["key"]];
        }
        if ((isset($buf)) && ($buf["type"] == "select")){
            if (isset($buf["dir"])){
                $value = objLoad("{$buf['dir']}{$v["value"]}/{$buf['obj']}","raw")[$buf['show']];
            }
        }
        else{
            $value = $v["value"];
        }
        $data = [
            "text" => $value
        ];
        $view->show("table.cell.data",$data);
    }
    $view->show("table.row.footer");
}
$view->show("table.footer");
$view->show("footer");


















