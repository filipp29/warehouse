<div style="
     display: flex;
     flex-direction: column;
     align-items: center;">
    <h3>
        Дата
    </h3>
    <input type="datetime-local" name="time" id="materialPriceTimeStamp" value="<?=isset($date) ? $date : ""?>">
    <h3>
        Цена
    </h3>
    <input type="number" name="price" id="materialPrice">
    <button onclick="materialPriceSend()">
        Отправить
    </button>
    <div style="display: none" id="materialPriceId">
        <?=isset($id) ? $id : ""?>
    </div>
    <div style="display: none">
        <div id="addPrice_js">/_modules/warehouse/php/components/AddPrice/js/script.js</div>
        <div id="addPrice_css">/_modules/warehouse/php/components/AddPrice/css/style.css</div>
    </div>
</div>

