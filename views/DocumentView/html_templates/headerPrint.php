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
        
        <link rel="stylesheet" href="/_modules/warehouse/warehouse.css"/>
        <link rel="stylesheet" href="/_modules/warehouse/views/DocumentView/css/style.css"/>
        <style>
            *{
                color: black !important;
                background-color: white !important;;
            }
            .docHeader input{
                border: 1px solid black !important;
                cursor: inherit !important;
            }
        </style>
    </head>
    <body>
        <div class="wareMainBox" style="width: 1050px; padding: 25px;">
            <div class="docTitle">
                <?= isset($title) ? $title : ""?>
            </div>