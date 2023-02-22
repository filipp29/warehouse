<!DOCTYPE html>
<html>
    <head>
        <title>Title</title>
        <meta charset="windows-1251">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/_modules/warehouse/php/components/TreeExplorer/css/style.css"/>
    </head>
    <body>
        <div class="explorerMainBox">
            <div <?=isset($mainMenu["params"]) ? $mainMenu["params"] : "class='explorerMainMenu'"?>>
                <?=isset($mainMenu["text"]) ? $mainMenu["text"] : ""?>
            </div>
            <div <?=isset($path["params"]) ? $path["params"] : "class='explorerPath'"?>>
                <?=isset($path["text"]) ? $path["text"] : ""?>
            </div>
            <div <?=isset($contentBox["params"]) ? $contentBox["params"] : "class='explorerContentBox'; id='explorerContentBox'"?>>
                <?=isset($contentBox["text"]) ? $contentBox["text"] : ""?>
            </div>
        </div>
        <script src="/_modules/warehouse/php/components/TreeExplorer/js/script.js"></script>
        <div style="display: none">
            <div id="treeExplorer_js">/_modules/warehouse/php/components/TreeExplorer/js/script.js</div>
            <div id="treeExplorer_css">/_modules/warehouse/php/components/TreeExplorer/css/style.css</div>
        </div>
    </body>
</html>