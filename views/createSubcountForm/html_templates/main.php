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
        <link rel="stylesheet" href="../css/style.css"/>
    </head>
    <body>
        <div class="wareMainBox">
            <div class="docHeader">
                <div class="headerBlock" style="width: 100%;">
                    <div class="label">
                        Дата
                    </div>
                    <div class="input">
                        <input type="datetime-local" name="name"  id="timeStamp" value="">
                    </div>
                </div>
                <div class="headerBlock"style="width: 15%;">
                    <div class="label">
                        Склад
                    </div>
                    <div class="input">
                        <select id="id">
                            <option value="first">Склад 1</option>
                            <option value="second">Склад 2</option>
                        </select>

                    </div>
                </div>
                <div class="headerBlock"style="width: 15%;">
                    <div class="label">
                        Контрагент
                    </div>
                    <div class="input">
                        <select id="id" disabled="disabled">
                            <option value="first">Контрагент 1</option>
                            <option value="second">Контрагент 2</option>
                        </select>
                    </div>
                </div>
                <div class="buttonBlock"style="width: 100%;">
                    <button style="margin-right: 15px;" onclick="console.log(document.getElementById('timeStamp'))">
                        Добавить строку
                    </button>
                    <button>
                        Очистить таблицу
                    </button>
                </div>
            </div>
            <table class="docTable">
                <thead>
                    <tr>
                        <th>
                            Наименование
                        </th>
                        <th>
                            Цена
                        </th>
                        <th>
                            Количество
                        </th>
                        <th>
                            Ед. изм.
                        </th>
                        <th>
                            Удалить
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            Витая пара 8ж
                        </td>
                        <td>
                            80
                        </td>
                        <td>
                            2500
                        </td>
                        <td>
                            м
                        </td>
                        <td>
                            x
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>    
    </body>
</html>
