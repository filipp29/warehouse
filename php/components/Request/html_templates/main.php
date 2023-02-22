<div class="wareMainBox">
    <div class="requestTableHeader">
        <div class="headerBlock" style="width: 250px;">
            <div class="label">
                Склад    
            </div>
            <input type="text" id="requestTable_filter_warehouse">
        </div>
        <div class="headerBlock" style="width: 250px;">
            <div class="label">
                Материал    
            </div>
            <input type="text" id="requestTable_filter_material">
        </div>

        <div class="buttonBlock" style="justify-content: flex-start">
            <button onclick="showCreateRequestForm()" style="margin-left: 15px;">
                Добавить
            </button>
        </div>
    </div>
    <table class="wareHouseTable">
        <thead>
            <tr>
                <th style="width: 150px">
                    Дата
                </th>
                <th>
                    Склад
                </th>
                <th>
                    Материал
                </th>
                <th style="width: 100px; text-align: right;">
                    Количество
                </th>
                <th style="width: 70px">
                    Действие
                </th>
            </tr>
        </thead>
        <tbody id="requestTable">
            <?=isset($tbody) ? $tbody : ""?>
        </tbody>
    </table>
</div>