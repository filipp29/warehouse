<?php
function toStrList(
        $ar
){
    $result = "";
    foreach($ar as $k => $v){
        $result .= " {$k}='{$v}'";
    }
    return $result;
}
/*--------------------------------------------------*/

function showElement(
        $dir
){
    $blockParams = toStrList(isset($dir["block"]["params"]) ? $dir["block"]["params"] : []);
    $elementParams = toStrList(isset($dir["element"]["params"]) ? $dir["element"]["params"] : []);
    $elementText = isset($dir["element"]["text"]) ? $dir["element"]["text"] : "";
    $img = isset($dir["img"]["path"]) ? $dir["img"]["path"] : "";
    $iconParams = toStr(isset($dir["icon"]["params"]) ? $dir["icon"]["params"] : []);
    
//******HTML**************************?>
<div <?=($blockParams) ? $blockParams : "class='contentBlock'"?>>
    <div <?=isset($iconParams) ? $iconParams : ""?> class="iconBlock">
        <img src="<?=isset($img) ? $img : ""?>" alt="alt"/>
    </div>
    <div <?=isset($elementParams) ? $elementParams : ""?>>
        <?=isset($elementText) ? $elementText : ""?>
    </div>
</div>
<!------PHP-----------------------><?php    


}

/*--------------------------------------------------*/

?>
<div <?=isset($content["params"]) ? $content["params"] : "class='content'"?>>
    <?php
        foreach($elementList as $element){
            $data = [
                "element" => [
                    "params" => [
                        "data_id" => $element["id"],
                        "onclick" => "selectTreeElement(this)",
                        "class" => "treeElementBlock"
                    ],
                    "text" => $element["name"]
                ],
                "icon" => [
                    "params" => [
                        "ondblclick" => $element["rowOnclick"]
                    ]
                ],
                "img" => [
                    "path" => $element["imgPath"]
                ],
                "block" => [
                    "params" => [
                        "data_type" => $element["type"],
                        "class" => "contentBlock"
                    ]
                ]
            ];
            showElement($data);
        }
    ?>
</div>
<?php?>


