<div style="<?= isset($style) ? $style : ""?>" type="text"  class="data subcountParam" id="<?= isset($id) ? $id : ""?>" value="<?= isset($value) ? $value : ""?>" <?= isset($params) ? $params : ""?>>
<?= isset($curValue) ? $curValue : ""?>
</div>
<button style="margin: 0;height: 100%; width: 30px; <?= isset($style) ? $style : ""?>" onclick="showListSelectSetter('<?=$id?>')">
    
</button>