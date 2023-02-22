<!--<!DOCTYPE html>

Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/ClientSide/html.html to edit this template

<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="windows-1251">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <form action="action">-->
            <label for="docId">Номер документа</label>
            <br>
            <input type="number" min="0" name="docId" id="docId">
            <br>
            <label for="dst">Склад источник</label>
            <br>
            
            <select id="dst">
                <option value="first">text1</option>
                <option value="second">text2</option>
                <option value="third">text3</option>
            </select>
            <br>
            <br>
            <label for="src">Склад назначения</label>
            <br>
            <select id="src">
                <option value="first">text1</option>
                <option value="second">text2</option>
                <option value="third">text3</option>
            </select>
            <br>
            <table>
                <tr>
                    <td>
                        Материал
                    </td>
                    <td>
                        Цена
                    </td>
                    <td>
                        Количество
                    </td>
                </tr>
                <tr>
                    <td>
                        <select id="material">
                            <option value="first">text1</option>
                            <option value="second">text2</option>
                            <option value="third">text3</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" min="0" name="count" id="count">
                    </td>
                    <td>
                        <input type="number" min="0" name="price" id="price">
                    </td>
                </tr>
            </table>
            
            
            
            
            <input type="submit" name="submit" value="Отправить">
        </form>
    </body>
</html>
