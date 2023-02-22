 
<div class="createFileForm">
    <label>—сылка на материал</label>
    <div class="input">
        <div class="data" id="createFileLink" value="" style="overflow: hidden;">
           ...
        </div>
        <button style="margin: 0;height: 100%; width: 30px" onclick="showSubcountSelectSetter('material','createFileLink')">

        </button>                    
    </div>
    <label for="newFileName" >»м€ файла</label>
    <input data_path="<?=isset($path) ? $path : ""?>" type="text" name="newFileName" id="newFileName">
    <button onclick="createFile(this)">OK</button>
    <div style="display: none">
        <div id="createFile_js">/_modules/warehouse/php/components/TreeExplorer/js/createFileForm.js</div>
    </div>
</div>





