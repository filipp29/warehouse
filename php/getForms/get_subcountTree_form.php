<?php

error_reporting(E_ALL); //¬ключаем вывод ошибок
set_time_limit(600); //”станавливаем максимальное врем€ работы скрипта в секундах
ini_set('display_errors', 1); //≈ще один вывод ошибок
ini_set('memory_limit', '512M'); //”станавливаем ограничение пам€ти на скрипт (512ћб)

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //”казываем корневую папку (нужно, только если работаем с консольным скриптом
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/views/TreeExplorerView.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';


\TreeExplorerView::showMenu(0);










