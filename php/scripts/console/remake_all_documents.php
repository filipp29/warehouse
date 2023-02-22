<?php
$_COOKIE["login"] = "filipp";
$_COOKIE["organization"] = "ksk";
$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //Подключаем библиотеку для работы с БД
require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';



//objUnlinkBranch("/ware/ksk/reports/1310/");
//
//echo "OK\n";

$path = "/ware/ksk/docList/all/";

$br = array_keys(objLoadBranch($path, false, true));

$docList = objLoad("/tmp/docListKsk.list");
//$docList = [];
unset($docList["#e"]);

//$count = 0;
//foreach($br as $date){
//    $numList = array_keys(objLoadBranch($path.$date."/", false, true));
//    foreach($numList as $docNum){
//        $doc = new \Document($docNum);
//        if ($doc->isExecuted()){
//            $docList[] = $docNum;
//        }
//        else {
//            $count++;
//        }
//    }
//}
echo count_u($docList);
//objSave("/tmp/docListKsk.list", "raw", $docList);
//
//
//echo "{$count} - ". count_u($docList) ."\n";
$i = 0;
foreach($docList as $docNum){
    $i++;
    echo "{$docNum} - {$i}\n";
    $doc = new \Document($docNum);
    $doc->save(false);
}


//objUnlinkBranch("/ware/ksk/entry/");


$i = 0;
foreach($docList as $key => $docNum){
    $i++;
    echo $docNum.$i."\n";  
    $doc = new \Document($docNum);
    $doc->save(true);
    
}


echo "OK\n";


