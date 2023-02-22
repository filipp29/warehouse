<?php

/*--------------------------------------------------*/
function showMenuButton(
        $button
){
    $params = toStr(isset($button["params"]) ? $button["params"] : []);
    $text = isset($button["text"]) ? $button["text"] : "";
    
//******HTML**************************?>
<button <?=isset($params) ? $params : ""?>>
    <?=isset($text) ? $text : ""?>
</button>
<!------PHP-----------------------><?php    
}
/*--------------------------------------------------*/



function toStr(
        $ar
){
    $result = "";
    foreach($ar as $k => $v){
        $result .= " {$k}='{$v}'";
    }
    return $result;
}
/*--------------------------------------------------*/


foreach($buttonList as $button){
    $data = [
        "params" => [
            "onclick" => $button["onclick"]
        ],
        "text" => $button["name"]
    ];
    showMenuButton($data);
}











?>