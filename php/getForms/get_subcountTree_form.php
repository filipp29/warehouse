<?php

error_reporting(E_ALL); //�������� ����� ������
set_time_limit(600); //������������� ������������ ����� ������ ������� � ��������
ini_set('display_errors', 1); //��� ���� ����� ������
ini_set('memory_limit', '512M'); //������������� ����������� ������ �� ������ (512��)

$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //��������� �������� ����� (�����, ������ ���� �������� � ���������� ��������
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/View2.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/classes/views/TreeExplorerView.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';


\TreeExplorerView::showMenu(0);










