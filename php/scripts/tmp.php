<?php

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //Подключаем библиотеку для работы с БД
$executed = $_GET["login"];

$br = array_keys(objLoadBranch("/support/archive/20220430/", true, false));
$count = 0;
echo "<pre>";
foreach($br as $value){
    $obj = objLoad("/support/archive/20220430/{$value}");
    if ($obj["executed"] == $executed){
        $count++;
        echo "-----------------------------------------------------------------\n\n";
        print_r($obj);
        echo "-----------------------------------------------------------------\n\n";
    }
}
echo "</pre>";

echo $count. "\n";











