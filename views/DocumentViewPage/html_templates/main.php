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
                        ����
                    </div>
                    <div class="input">
                        <input type="datetime-local" name="name"  id="timeStamp" value="">
                    </div>
                </div>
                <div class="headerBlock"style="width: 15%;">
                    <div class="label">
                        �����
                    </div>
                    <div class="input">
                        <select id="id">
                            <option value="first">����� 1</option>
                            <option value="second">����� 2</option>
                        </select>

                    </div>
                </div>
                <div class="headerBlock"style="width: 15%;">
                    <div class="label">
                        ����������
                    </div>
                    <div class="input">
                        <select id="id" disabled="disabled">
                            <option value="first">���������� 1</option>
                            <option value="second">���������� 2</option>
                        </select>
                    </div>
                </div>
                <div class="buttonBlock"style="width: 100%;">
                    <button style="margin-right: 15px;" onclick="console.log(document.getElementById('timeStamp'))">
                        �������� ������
                    </button>
                    <button>
                        �������� �������
                    </button>
                </div>
            </div>
            <table class="docTable">
                <thead>
                    <tr>
                        <th>
                            ������������
                        </th>
                        <th>
                            ����
                        </th>
                        <th>
                            ����������
                        </th>
                        <th>
                            ��. ���.
                        </th>
                        <th>
                            �������
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            ����� ���� 8�
                        </td>
                        <td>
                            80
                        </td>
                        <td>
                            2500
                        </td>
                        <td>
                            �
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
