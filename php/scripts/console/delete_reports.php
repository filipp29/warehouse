<?php
$_COOKIE["login"] = "filipp";
$_COOKIE["organization"] = "uplink";
$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //Подключаем библиотеку для работы с БД
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';



$path = "/ware/uplink/reports/1310/bySubcount2/";

objUnlinkBranch($path);

echo "OK\n";





