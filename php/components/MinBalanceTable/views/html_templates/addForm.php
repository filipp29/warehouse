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
    </head>
    <body>
        <div>
            <div class="wareMainBox">
            <div class="minBalanceHeader">
                <div class="headerBlock" style="width: 45%">
                    <div class="label">
                        Склад                    </div>
                    <div class="input">
                        <div class="data" id="minBalanceAdd_warehouse" value="">
                            ...
                        </div>
                        <button style="margin: 0;height: 100%; width: 30px" onclick="showSubcountSelectSetter('warehouse','minBalanceAdd_warehouse')">

                        </button>                    
                    </div>
                </div>
                <div class="headerBlock" style="width: 45%">
                    <div class="label">
                        Материал                   </div>
                    <div class="input">
                        <div class="data" id="minBalanceAdd_material" value="">
                            ...
                        </div>
                        <button style="margin: 0;height: 100%; width: 30px" onclick="showSubcountSelectSetter('material','minBalanceAdd_material')">

                        </button>                    
                    </div>
                </div>
                <div class="headerBlock" style="width: 60%;">
                    <div class="label">
                        Минимальное количество   
                    </div>
                    <input type="text" id="minBalanceAdd_count">
                </div>
                <div class="tableButtonBlock" style="width: 100%;">
                    <button onclick="addNewMinBalance()" style="margin-left: 15px;">
                        Добавить
                    </button>
                </div>
            </div>
            
        </div>
        </div>
    </body>
</html>
