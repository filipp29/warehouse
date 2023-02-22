
        <div class="createRequestHeader" style="">
            <div class="headerBlock" style="width: auto">
                <div class="label">
                    Склад                    
                </div>
                <div class="input">
                    <div class="data" id="requestWarehouse" value="" style="overflow: hidden;">
                    ...
                    </div>
                    <button style="margin: 0;height: 100%; width: 30px" onclick="showSubcountSelectSetter('warehouse','requestWarehouse','inCharge')">

                    </button>                    
                </div>
            </div>
            <div class="headerBlock" style="width: auto">
                <div class="label">
                    Материал                    
                </div>
                <div class="input">
                    <div class="data" id="requestMaterial" value="" style="overflow: hidden;">
                    ...
                    </div>
                    <button style="margin: 0;height: 100%; width: 30px" onclick="showSubcountSelectSetter('material','requestMaterial')">

                    </button>                    
                </div>
            </div>
            
            <div class="headerBlock" style="width: auto">
                <div class="label">
                    Количество                    
                </div>
                <div class="input">
                    <input class="data" type="number" name="count" id="requestCount">
                </div>
            </div>
            
            <div class="buttonBlock" style="width: 100%">
                <button style="margin-right: 15px" onclick="saveRequest()">
                    Сохранить                    
                </button>
            </div>
        </div>

