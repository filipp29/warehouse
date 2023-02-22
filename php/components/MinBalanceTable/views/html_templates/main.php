<?php

function toStr(
        $ar
){
    $result = "";
    foreach($ar as $key => $value){
        $result .= "{$key}='{$value}'";
    }
    return $result;
}


/*--------------------------------------------------*/

function textInputBlock(
        $headerBlock
){
    $params = toStr(isset($headerBlock["params"]) ? $headerBlock["params"] : []);
    $labelParams = toStr(isset($headerBlock["label"]["params"]) ? $headerBlock["label"]["params"] : []);
    $labelText = isset($headerBlock["label"]["text"]) ? $headerBlock["label"]["text"] : "";
    $inputParams = toStr(isset($headerBlock["input"]["params"]) ? $headerBlock["input"]["params"] : []);
//*********TextInputBlock**********
?>
<div class="headerBlock" <?=isset($params) ? $params : ""?>>
    <div class="label" <?=isset($labelParams) ? $labelParams : ""?>>
        <?=isset($labelText) ? $labelText : ""?>
    </div>
    <input type="text" <?=isset($inputParams) ? $inputParams : ""?>>
</div>
<?php
//*********************************    
}

/*--------------------------------------------------*/


function checkboxInputBlock(
        $headerBlock
){
    
    $params = isset($headerBlock["params"]) ? $headerBlock["params"] : [];
    $labelParams = isset($headerBlock["label"]["params"]) ? $headerBlock["label"]["params"] : [];
    $labelText = isset($headerBlock["label"]["text"]) ? $headerBlock["label"]["text"] : "";
    $inputParams = isset($headerBlock["input"]["params"]) ? $headerBlock["input"]["params"] : [];
    $style = "flex-direction: row;";
    $params["style"] = isset($params["style"]) ? $params["style"]. $style : $style;
    extract(array_map("toStr",compact("params","labelParams","inputParams")));
    
//*********************************
?>
<div class="headerBlock" <?=isset($params) ? $params : ""?>>
    <input type="checkbox" <?=isset($inputParams) ? $inputParams : ""?>>
    <div class="label" <?=isset($labelParams) ? $labelParams : ""?>>
        <?=isset($labelText) ? $labelText : ""?>
    </div>
</div>
<?php
//*********************************    
}

/*--------------------------------------------------*/


function tableRow(
        $row
){
    $style = toStr(isset($row["style"]) ? $row["style"] : []);
//......HTML..........................?>
<tr <?=isset($style) ? $style : ""?>>
<!------PHP-----------------------><?php    
    unset($row["style"]);
    foreach($row as $value){
        $params = isset($value["params"]) ? $value["params"] : [];
        $text = isset($value["text"]) ? $value["text"] : "";
        $params = toStr($params);
//******HTML**************************?>
    <td <?=isset($params) ? $params : ""?>>
        <?=isset($text) ? $text : ""?>
    </td>
<!------PHP-----------------------><?php        
        
    }
    
//******HTML**************************?>

    <td>
        <button style="margin: 0; height: 100%" onclick="minBalanceTableDelete(this)">
            X
        </button>
    </td>
</tr>
<!------PHP-----------------------><?php
}


/*--------------------------------------------------*/


function showButton(
        $button
){
    
    $text = isset($button["text"]) ? $button["text"] : "";
    $params = toStr(isset($button["params"]) ? $button["params"] : []);
    
    
//******HTML**************************?>
<button <?=isset($params) ? $params : ""?>>
    <?=isset($text) ? $text : ""?>
</button>
<!------PHP-----------------------><?php    
}


/*--------------------------------------------------*/








?>
<!------------------------------------------------------------------------------------------------->

<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/ClientSide/html.html to edit this template
-->
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="windows-1251">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/_modules/warehouse/warehouse.css"/>
        <link rel="stylesheet" href="/_modules/warehouse/php/components/MinBalanceTable/views/css/style.css"/>
    </head>
    <body>
        <div class="wareMainBox" >
            <div class="minBalanceHeader">
                <?php
                    foreach($headerBlockList as $hb){
                        switch($hb["type"]):
                            case "text":
                                textInputBlock($hb);
                                break;
                            case "checkbox":
                                checkboxInputBlock($hb);
                                break;
                        endswitch;
                    }
                ?>
                <div class="buttonBlock">
                    <?php

                        foreach($tableButtonList as $button){
                            showButton($button);
                        }

                    ?>
                </div>
            </div>
            <table  class="wareHouseTable">
                <thead>
                    <tr>
                        <th style="width: 300px">
                            Склад
                        </th>
                        <th style="width: 300px">
                            Материал
                        </th>
                        <th>
                            Минимум
                        </th>
                        <th>
                            Текущее
                        </th>
                        <th style="width: 70px">
                            Удалить
                        </th>
                    </tr>
                </thead>
                <tbody id="minBalanceTbody">
                <?php
                
                    foreach($table as $key => $value){
                        tableRow($value);
                    }
                
                ?>
                </tbody>
            </table>
        </div>
        <div style="display: none">
            <div id="minBalanceTable_js">/_modules/warehouse/php/components/MinBalanceTable/views/js/script.js</div>
            <div id="minBalanceTable_css">/_modules/warehouse/php/components/MinBalanceTable/views/css/style.css</div>
        </div>
    </body>
</html>















