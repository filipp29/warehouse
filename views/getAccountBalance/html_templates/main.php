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
        <form onsubmit="event.preventDefault(); onFormSubmit();" action="#">
            <label>Дата и время</label>
            <br>
            <input type="datetime-local" name="timeStamp" id="timeStamp">
            <br>
            
            
            <label>Субконто 1</label>
            <input type="checkbox" name="sub1Check" id="subCheck1">
            <br>
            <select id="subcount1">
                <option value="first">text1</option>
                <option value="second">text2</option>
                <option value="third">text3</option>
            </select>
            <br>
            
            
            <label>Субконто 2</label>
            <input type="checkbox" name="sub1Check" id="subCheck2">
            <br>
            <select id="subcount2">
                <option value="first">text1</option>
                <option value="second">text2</option>
                <option value="third">text3</option>
            </select>
            <br>
            <input type="submit" name="submit" value="Отправить">
        </form>
        <div id="count" style="display: none">
            <?=$count?>
        </div>
        <div id="message">
            
        </div>
       
    </body>
</html>
