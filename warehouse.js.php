


//<script>
 
 
 
 
    function clickOn($tabname, $module){
//        if ((getCookie("login") != "filipp")  (getCookie("login") != "kodola")){
//            getById('workfield').innerHTML = "<h1>Ведутся работы</h1>";
//            return;
//        }
        var randID=Math.floor(Math.random() * Math.floor(100000));
        getById('workfield').innerHTML='<div id="wf_'+randID+'" style="width: 100%;"></div>';
        include_dom('/_ui/html2var.js.php?var=wf_'+randID+'&url=/_modules/'+$module+'/html/'+$tabname+'.html');
        var btnList=getById('sidebarButtons').getElementsByClassName('tabBtn_a');
        for ($i=0; $i<btnList.length; $i++){
            getById(btnList[$i].id).className="tabBtn";
        }
        getById('listBtn_'+$tabname).className="tabBtn_a";
    }
    
    
if (!getCookie("organization")){
    setCookie("organization","uplink");
}
console.log("!!!");

cls();
var wrapper = document.getElementById('wrapper');
var sidebar = document.createElement('div');
sidebar.className='sidebar';
sidebar.id='sidebar';
sidebar.style.float='left';
var workfield = document.createElement('div');
workfield.id='workfield';
workfield.className='workfield';
workfield.style.height='100%';
workfield.style.marginLeft='64px';
workfield.style.paddingLeft='10px';
workfield.style.paddingTop='48px';
workfield.style.boxSizing='border-box';
workfield.style.overflowY='auto';
wrapper.appendChild(sidebar);
wrapper.appendChild(workfield);
    
var sbhttp=new XMLHttpRequest();
sbhttp.onreadystatechange=function()
{
    if (sbhttp.readyState==4 && sbhttp.status==200){
        if (document.getElementById('sidebar')!=undefined){
            document.getElementById('sidebar').innerHTML=sbhttp.responseText;
        }
    }
}
sbhttp.open("POST","/_modules/warehouse/helpers/sidebarGen.php",true);
sbhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
sbhttp.send('');
//if ((getCookie("login") != "filipp") && (getCookie("login") != "kodola")){
//    getById('workfield').innerHTML = "<h1>Ведутся работы</h1>";
//}
//else{
<?php

//    require_once $_SERVER['DOCUMENT_ROOT'].'/_modules/warehouse/php/require_all.php';
//    $level = (int)getAccessLevel();
//    if ($level <= 2){
        echo "include_dom('/_ui/html2var.js.php?var=workfield&url=/_modules/warehouse/html/1stat.html');";
//    }

?>
    
//}




/*---------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------*/


function scaleElement(
        id,
        rate
){
    let element = document.getElementById(id);
    let scale = 'scale(' + rate + ')';
    element.style.webkitTransform =  scale;    
    element.style.msTransform =   scale;       
    element.style.transform = scale;     
}

var _result_ = {};
Object.defineProperty(_result_, "subcount", { 
    set: function (x) { 
        this._subcount = x;
        this.subcountSetter();
        fUnMsgBlock("subcountSelectForm");
        
    },
    get: function (){
        return this._subcount;
    }
    
});

Object.defineProperty(_result_, "listEl", { 
    set: function (x) { 
        this._listEl = x;
        this.listElSetter();
        fUnMsgBlock("listSelectForm");
        
    },
    get: function (){
        return this._listEl;
    }
    
});


function sidebarClick(
        $tabname
){
    let $xhrSidebar = new XMLHttpRequest();
    $xhrSidebar.onload = function(){
        if ($xhrSidebar.status === 200){
            getById("workfield").innerHTML = $xhrSidebar.responseText;
            include_dom("/_modules/warehouse/html/"+$tabname+".html.js");
        }
    }
    $xhrSidebar.open("GET", "/_modules/warehouse/php/example.php?page="+$tabname);
    $xhrSidebar.send("");

    var btnList=getById('sidebarButtons').getElementsByClassName('tabBtn_a');
    for ($i=0; $i<btnList.length; $i++){
        getById(btnList[$i].id).className="tabBtn";
    }
    getById('listBtn_'+$tabname).className="tabBtn_a";
}


/*---------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------*/
/*
 * fMsgBlock
 * 
 * ---------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------*/




function fUnMsgBlock(
        $blockId = 'msgbboxdiv',
        onclose = null
){
    $obj=document.getElementById($blockId);
    if ($obj!=undefined){
        document.body.removeChild($obj);
    }
    removeJsCss($blockId);
    if (onclose){
        onclose();
    }
}

function fMsgBlock(
        title, 
        content, 
        height,
        width,
        blockId = 'fmsgbboxdiv',
        onclose = null
){
    
    
    let msgBack = document.createElement("div");
    msgBack.style = `
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            background-color: rgba(255, 255, 255, 0.7);
            z-index: 4000;
    `;
    msgBack.setAttribute("id",blockId);
    let msgBox = document.createElement("div");
    msgBox.style = `
            position: absolute;
            box-sizing: border-box;
            z-index: 4050;
            top: 50%;
            left: 50%;
            display: flex;
            justify-content: flex-start;
            flex-direction: column;
            background-color: var(--modBGColor);
            border: 2px solid var(--modColor_dark);
            
    `;
    msgBox.style.width = width+"px";
    msgBox.style.height = height+"px";
    msgBox.style["margin-left"] = Math.floor(-width/2)+"px";
    msgBox.style["margin-top"] = Math.floor(-height/2)+"px";
//    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent)) {
//
//        msgBox.classList.add("mobileMsgBox");
//        alert("Вы используете Смартфон.")
//
//    } else{ 
//        alert(navigator.userAgent)
//    }
    
    let msgBoxHeader = document.createElement("div");
    msgBoxHeader.style = `
            display: flex;
            height: 35px;
            justify-content: space-between;
            background-color: var(--modColor);
            color: var(--modBGColor);
            vertical-align: middle;
    `;
    let msgHeaderText = document.createElement("div");
    msgHeaderText.style = `
            display: flex;
            justify-content: center;
            padding: 0px 20px;
            align-items: center;
            font-size: 22px;
    `;
    msgHeaderText.textContent = title;
    let msgCloseButton = document.createElement("div");
    msgCloseButton.style = `
            width: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-sizing: border-box;
            font-size: 20px;
            font-family: "Lato";
            text-align: center;
            height: 33px;
            cursor: pointer;
    `;
    msgCloseButton.setAttribute("onclick","fUnMsgBlock("+'"'+blockId+'"'+","+onclose+")");
    msgCloseButton.textContent = "X";
    msgCloseButton.setAttribute("id",blockId+"_closeButton");
    let msgData = document.createElement("div");
    msgData.style = `
            width: 100%;
            height: calc(100% - 35px);
    `;
    msgData.innerHTML = content;
    msgBoxHeader.appendChild(msgHeaderText);
    msgBoxHeader.appendChild(msgCloseButton);
    msgBox.appendChild(msgBoxHeader);
    msgBox.appendChild(msgData);
    msgBack.appendChild(msgBox);
    document.body.appendChild(msgBack);
    document.getElementById(blockId+"_closeButton").addEventListener("mouseover", (event) =>{
        event.target.style["background-color"] = "red";
    });
    document.getElementById(blockId+"_closeButton").addEventListener("mouseout", (event) =>{
        event.target.style["background-color"] = "inherit";
    });

}


/*---------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------*/


/*---------------------------------------------------------------------------*/
/* ##########################################################################
 * ##########################################################################
 * ##########################################################################
 * ##########################################################################
 * ##########################################################################
 * 
 * 
 * ##########################################################################
 * ##########################################################################
 * ##########################################################################
 * ---------------------------------------------------------------------------*/



    function rtrScreenLock(){
        rtrScreenUnlock();
        var $lockDiv=document.createElement("div");
        $lockDiv.id='uplLockScreenDiv';
        $lockDiv.style.display='table';
        $lockDiv.style.backgroundColor='rgba(0, 0, 0, 0.7)';
        $lockDiv.style.position='absolute';
        $lockDiv.style.top='0px';
        $lockDiv.style.left='0px';
        $lockDiv.style.width='100%';
        $lockDiv.style.height='100%';
        $lockDiv.style.zIndex='9999';
        var $topRowDiv=document.createElement("div");
        $topRowDiv.style.display='table-row';
        $topRowDiv.style.height='33%';

        var $cell1=document.createElement("div");
        $cell1.style.display='table-cell';
        var $cell2=document.createElement("div");
        $cell2.style.display='table-cell';
        var $cell3=document.createElement("div");
        $cell3.style.display='table-cell';
        $topRowDiv.appendChild($cell1);
        $topRowDiv.appendChild($cell2);
        $topRowDiv.appendChild($cell3);

        var $middleRowDiv=document.createElement("div");
        $middleRowDiv.style.display='table-row';
        $middleRowDiv.style.height='33%';
        var $cell4=document.createElement("div");
        $cell4.style.display='table-cell';
        $cell4.style.width='33%';
        var $cell5=document.createElement("div");
        $cell5.style.display='table-cell';
        $cell5.style.width='33%';
        $cell5.style.color='#fff';
        $cell5.style.fontSize='21px';
        $cell5.style.textAlign='center';
        $cell5.style.verticalAlign='middle';
        $cell5.innerHTML='<img src="/_modules/uplink/img/pulse.gif"/><br/>Выполняется операция...';
        var $cell6=document.createElement("div");
        $cell6.style.display='table-cell';
        $cell6.style.width='33%';
        $middleRowDiv.appendChild($cell4);
        $middleRowDiv.appendChild($cell5);
        $middleRowDiv.appendChild($cell6);

        var $bottomRowDiv=document.createElement("div");
        $bottomRowDiv.style.display='table-row';
        $bottomRowDiv.style.height='33%';
        var $cell7=document.createElement("div");
        $cell7.style.display='table-cell';
        var $cell8=document.createElement("div");
        $cell8.style.display='table-cell';
        var $cell9=document.createElement("div");
        $cell9.style.display='table-cell';
        $bottomRowDiv.appendChild($cell7);
        $bottomRowDiv.appendChild($cell8);
        $bottomRowDiv.appendChild($cell9);

        $lockDiv.appendChild($topRowDiv);
        $lockDiv.appendChild($middleRowDiv);
        $lockDiv.appendChild($bottomRowDiv);

        document.body.appendChild($lockDiv);
    }
    
    function rtrScreenUnlock(){
        var $ls=getById('uplLockScreenDiv');
        if ($ls!=undefined){
            document.body.removeChild($ls);
        }
    }










/*---------------------------------------------------------------------------*/



function getXhr(
        params
){  
    return new Promise(function(callback){
        let xhr = new XMLHttpRequest();
        xhr.onload = function(){
            if (xhr.status == 200){
                rtrScreenUnlock();
                callback(xhr.responseText);
            }
        };
        if (params["method"] == "GET"){
            xhr.open(params["method"],params["url"] + "?" + params["body"]);
            xhr.send();
            rtrScreenLock();
        }
        else if (params["method"] == "POST"){
            xhr.open(params["method"],params["url"]);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send(params["body"]);
            rtrScreenLock();
        }
    });
}



/*---------------------------------------------------------------------------*/


function addJsCss(
        js,
        css,
        id

){
    let link = document.createElement("link");
    let rnd = Math.random();
    link.setAttribute("rel","stylesheet");
    link.setAttribute("id",id+"_link");
    link.setAttribute("href",css+"?rnd="+rnd);
    document.getElementsByTagName("head")[0].appendChild(link);
    let script = document.createElement("script");
    script.setAttribute("type","text/javascript");
    script.setAttribute("src",js+"?rnd="+rnd);
    script.setAttribute("id",id+"_script");
    document.getElementsByTagName("head")[0].appendChild(script);
}

/*---------------------------------------------------------------------------*/

function removeJsCss(
        id

){
    let elem = document.getElementById(id+"_script");
    if (elem){
        document.getElementsByTagName("head")[0].removeChild(elem);
    }
    elem = document.getElementById(id+"_link");
    if (elem){
        document.getElementsByTagName("head")[0].removeChild(elem);
    }
}



/*---------------------------------------------------------------------------*/

var xhr = new XMLHttpRequest();


function showRouterForm(
        mac
){
    let js = "/philtest/main/RouterForm/js/script.js";
    let css = "/philtest/main/RouterForm/css/style.css";
    xhr.onload = () => {
        if (xhr.status == 200){
            
            fMsgBlock("Информация о роутере",xhr.responseText, 700,1000, "routerForm");
            addJsCss(js,css,"routerForm");
            document.getElementById("routerForm_closeButton").addEventListener("mouseover", (event) =>{
                event.target.style["background-color"] = "red";
            });
            document.getElementById("routerForm_closeButton").addEventListener("mouseout", (event) =>{
                event.target.style["background-color"] = "inherit";
            });
        }
    };
    xhr.open("GET","/philtest/main/RouterForm/get_RouterForm.php?mac="+mac);
    xhr.send();
}

/*---------------------------------------------------------------------------*/


function showNewSubcountForm(
        type
){
    let js = "/_modules/warehouse/views/createSubcountForm/js/script.js";
    let css = "/_modules/warehouse/views/createSubcountForm/css/style.css";
//    let xhr = new XMLHttpRequest();
//    xhr.onload = () => {
//        if (xhr.status == 200){
//            
//            fMsgBlock("Создать субконто",xhr.responseText, 400,1000, "subcountCreate");
//            addJsCss(js,css,"subcountCreate");
//            document.getElementById("subcountCreate_closeButton").addEventListener("mouseover", (event) =>{
//                event.target.style["background-color"] = "red";
//            });
//            document.getElementById("subcountCreate_closeButton").addEventListener("mouseout", (event) =>{
//                event.target.style["background-color"] = "inherit";
//            });
//        }
//    };
//    xhr.open("GET", "/_modules/warehouse/php/getForms/create_subcount_form.php?type="+type);
//    xhr.send();
    
    getXhr({
        url : "/_modules/warehouse/php/getForms/create_subcount_form.php",
        method : "GET",
        body : "type=" + type
    }).then((html) => {
        fMsgBlock("Создать субконто",html, 400,1000, "subcountCreate");
        addJsCss(js,css,"subcountCreate");
        document.getElementById("subcountCreate_closeButton").addEventListener("mouseover", (event) =>{
            event.target.style["background-color"] = "red";
        });
        document.getElementById("subcountCreate_closeButton").addEventListener("mouseout", (event) =>{
            event.target.style["background-color"] = "inherit";
        });
    });
}


/*---------------------------------------------------------------------------*/


function showChangeSubcountForm(
        id
){
    let js = "/_modules/warehouse/views/createSubcountForm/js/script.js";
    let css = "/_modules/warehouse/views/createSubcountForm/css/style.css";
//    let xhr = new XMLHttpRequest();
//    xhr.onload = () => {
//        if (xhr.status == 200){
//            
//            fMsgBlock("Изменить субконто",xhr.responseText, 400,1000, "subcountChange");
//            addJsCss(js,css,"subcountChange");
//            document.getElementById("subcountChange_closeButton").addEventListener("mouseover", (event) =>{
//                event.target.style["background-color"] = "red";
//            });
//            document.getElementById("subcountChange_closeButton").addEventListener("mouseout", (event) =>{
//                event.target.style["background-color"] = "inherit";
//            });
//        }
//    };
    xhr.open("GET", "/_modules/warehouse/php/getForms/change_subcount_form.php?id="+id);
    xhr.send();
    
    getXhr({
        url : "/_modules/warehouse/php/getForms/change_subcount_form.php",
        method : "GET",
        body : "id=" + id
    }).then((html) => {
        fMsgBlock("Изменить субконто",html, 400,1000, "subcountChange");
        addJsCss(js,css,"subcountChange");
        document.getElementById("subcountChange_closeButton").addEventListener("mouseover", (event) =>{
            event.target.style["background-color"] = "red";
        });
        document.getElementById("subcountChange_closeButton").addEventListener("mouseout", (event) =>{
            event.target.style["background-color"] = "inherit";
        });
    });
}


/*---------------------------------------------------------------------------*/


function showNewDocumentForm(
        type
){
    let js = "/_modules/warehouse/views/DocumentView/js/script.js";
    let css = "/_modules/warehouse/views/DocumentView/css/style.css";
//    let xhr = new XMLHttpRequest();
//    xhr.onload = () => {
//        if (xhr.status == 200){
//            
//            fMsgBlock("Создать документ",xhr.responseText, 700,1000, "documentCreate");
//            addJsCss(js,css,"documentCreate");
//            document.getElementById("documentCreate_closeButton").addEventListener("mouseover", (event) =>{
//                event.target.style["background-color"] = "red";
//            });
//            document.getElementById("documentCreate_closeButton").addEventListener("mouseout", (event) =>{
//                event.target.style["background-color"] = "inherit";
//            });
//        }
//    };
//    xhr.open("GET", "/_modules/warehouse/php/getForms/get_newDoc_form.php?type="+type);
//    xhr.send();
    
    getXhr({
        url : "/_modules/warehouse/php/getForms/get_newDoc_form.php",
        method : "GET",
        body : "type=" + type
    }).then((html) => {
        fMsgBlock("Создать документ",html, 700,1000, "documentCreate");
        addJsCss(js,css,"documentCreate");
        document.getElementById("documentCreate_closeButton").addEventListener("mouseover", (event) =>{
            event.target.style["background-color"] = "red";
        });
        document.getElementById("documentCreate_closeButton").addEventListener("mouseout", (event) =>{
            event.target.style["background-color"] = "inherit";
        });
    });
}


/*---------------------------------------------------------------------------*/

function showReportForm(
        type
){
    let js = "/_modules/warehouse/views/ReportView/js/script.js";
    let css = "/_modules/warehouse/views/ReportView/css/style.css";
//    let xhr = new XMLHttpRequest();
//    xhr.onload = () => {
//        if (xhr.status == 200){
//            
//            fMsgBlock("Отчет",xhr.responseText, 700,1000, "reportForm");
//            addJsCss(js,css,"reportForm");
//            document.getElementById("reportForm_closeButton").addEventListener("mouseover", (event) =>{
//                event.target.style["background-color"] = "red";
//            });
//            document.getElementById("reportForm_closeButton").addEventListener("mouseout", (event) =>{
//                event.target.style["background-color"] = "inherit";
//            });
//        }
//    };
//    console.log("/_modules/warehouse/php/getForms/get_report_form.php?type="+type);
//    xhr.open("GET", "/_modules/warehouse/php/getForms/get_report_form.php?type="+type);
//    xhr.send();
    
    getXhr({
        url : "/_modules/warehouse/php/getForms/get_report_form.php",
        method : "GET",
        body : "type=" + type
    }).then((html) => {
        fMsgBlock("Отчет",html, 700,1000, "reportForm");
        addJsCss(js,css,"reportForm");
        document.getElementById("reportForm_closeButton").addEventListener("mouseover", (event) =>{
            event.target.style["background-color"] = "red";
        });
        document.getElementById("reportForm_closeButton").addEventListener("mouseout", (event) =>{
            event.target.style["background-color"] = "inherit";
        });
    });
}


/*---------------------------------------------------------------------------*/

function showAssetTransferTable(
        id
){
    let js = "/_modules/warehouse/views/ReportView/js/script.js";
    let css = "/_modules/warehouse/views/ReportView/css/style.css";
//    let xhr = new XMLHttpRequest();
//    xhr.onload = () => {
//        if (xhr.status == 200){
//            
//            fMsgBlock("История перемещений ОС",xhr.responseText, 650,1000, "transferTable");
//            addJsCss(js,css,"transferTable");
//            document.getElementById("transferTable_closeButton").addEventListener("mouseover", (event) =>{
//                event.target.style["background-color"] = "red";
//            });
//            document.getElementById("transferTable_closeButton").addEventListener("mouseout", (event) =>{
//                event.target.style["background-color"] = "inherit";
//            });
//        }
//    };
//    xhr.open("GET", "/_modules/warehouse/php/getForms/get_asset_transfer_table.php?id="+id);
//    xhr.send();
    console.log("/_modules/warehouse/php/getForms/get_asset_transfer_table.php?id="+id);
    getXhr({
        url : "/_modules/warehouse/php/getForms/get_asset_transfer_table.php",
        method : "GET",
        body : "id=" + id 
    }).then((html) => {
        fMsgBlock("История перемещений ОС",html, 650,1000, "transferTable");
        addJsCss(js,css,"transferTable");
        document.getElementById("transferTable_closeButton").addEventListener("mouseover", (event) =>{
            event.target.style["background-color"] = "red";
        });
        document.getElementById("transferTable_closeButton").addEventListener("mouseout", (event) =>{
            event.target.style["background-color"] = "inherit";
        });
    });
}

/*---------------------------------------------------------------------------*/


function showJournalForm(
        type
){
    let js = "/_modules/warehouse/views/JournalView/js/script.js";
    let css = "/_modules/warehouse/views/JournalView/css/style.css";
//    let xhr = new XMLHttpRequest();
//    xhr.onload = () => {
//        if (xhr.status == 200){
//            
//            fMsgBlock("Журнал",xhr.responseText, 700,1000, "journalForm");
//            addJsCss(js,css,"journalForm");
//            document.getElementById("journalForm_closeButton").addEventListener("mouseover", (event) =>{
//                event.target.style["background-color"] = "red";
//            });
//            document.getElementById("journalForm_closeButton").addEventListener("mouseout", (event) =>{
//                event.target.style["background-color"] = "inherit";
//            });
//        }
//    };
//    xhr.open("GET", "/_modules/warehouse/php/getForms/get_journal_form.php?type="+type);
//    xhr.send();
    
    getXhr({
        url : "/_modules/warehouse/php/getForms/get_journal_form.php",
        method : "GET",
        body : "type=" + type
    }).then((html) => {
        fMsgBlock("Журнал",html, 700,1000, "journalForm");
        addJsCss(js,css,"journalForm");
        document.getElementById("journalForm_closeButton").addEventListener("mouseover", (event) =>{
            event.target.style["background-color"] = "red";
        });
        document.getElementById("journalForm_closeButton").addEventListener("mouseout", (event) =>{
            event.target.style["background-color"] = "inherit";
        });
    });
}


/*---------------------------------------------------------------------------*/


function showSubcountListForm(
        type
){
    let js = "/_modules/warehouse/views/subcountListForm/js/script.js";
    let css = "/_modules/warehouse/views/subcountListForm/css/style.css";
//    let xhr = new XMLHttpRequest();
//    xhr.onload = () => {
//        if (xhr.status == 200){
//            
//            fMsgBlock("Журнал",xhr.responseText, 700,1000, "subcountListForm");
//            addJsCss(js,css,"subcountListForm");
//            document.getElementById("subcountListForm_closeButton").addEventListener("mouseover", (event) =>{
//                event.target.style["background-color"] = "red";
//            });
//            document.getElementById("subcountListForm_closeButton").addEventListener("mouseout", (event) =>{
//                event.target.style["background-color"] = "inherit";
//            });
//        }
//    };
//    xhr.open("GET", "/_modules/warehouse/php/getForms/get_subcountList_form.php?type="+type);
//    xhr.send();
    
    getXhr({
        url : "/_modules/warehouse/php/getForms/get_subcountList_form.php",
        method : "GET",
        body : "type=" + type
    }).then((html) => {
        fMsgBlock("Журнал",html, 700,1000, "subcountListForm");
        addJsCss(js,css,"subcountListForm");
        document.getElementById("subcountListForm_closeButton").addEventListener("mouseover", (event) =>{
            event.target.style["background-color"] = "red";
        });
        document.getElementById("subcountListForm_closeButton").addEventListener("mouseout", (event) =>{
            event.target.style["background-color"] = "inherit";
        });
    });
}




/*---------------------------------------------------------------------------*/

function showSubcountSelectForm(
        type,
        params = {},
        subcount1 = ""
){
    let js = "/_modules/warehouse/views/subcountSelectForm/js/script.js";
    let css = "/_modules/warehouse/views/subcountSelectForm/css/style.css";
//    let xhr = new XMLHttpRequest();
//    xhr.onload = () => {
//        if (xhr.status == 200){
//            
//            fMsgBlock("Выбрать",xhr.responseText, 650,750, "subcountSelectForm");
//            addJsCss(js,css,"subcountSelectForm");
//            document.getElementById("subcountSelectForm_closeButton").addEventListener("mouseover", (event) =>{
//                event.target.style["background-color"] = "red";
//            });
//            document.getElementById("subcountSelectForm_closeButton").addEventListener("mouseout", (event) =>{
//                event.target.style["background-color"] = "inherit";
//            });
//        }
//    };
    let result = {};
    result["type"] = type;
    result["searchParams"] = params;
    result["subcount1"] = subcount1;
    console.log(params);
    let dec = new Decoder();
    let str = dec.arrayToStr(result);
    console.log(str);
//    xhr.open("GET", "/_modules/warehouse/php/getForms/get_subcountSelect_form.php?data="+str);
//    xhr.send();
    getXhr({
        url : "/_modules/warehouse/php/getForms/get_subcountSelect_form.php",
        method : "GET",
        body : "data=" + str
    }).then((html)=>{
        fMsgBlock("Выбрать",html, 650,750, "subcountSelectForm");
        addJsCss(js,css,"subcountSelectForm");
        document.getElementById("subcountSelectForm_closeButton").addEventListener("mouseover", (event) =>{
            event.target.style["background-color"] = "red";
        });
        document.getElementById("subcountSelectForm_closeButton").addEventListener("mouseout", (event) =>{
            event.target.style["background-color"] = "inherit";
        });
    });
}





/*---------------------------------------------------------------------------*/



function showSubcountForm(
        id
){
    let js = "/_modules/warehouse/views/subcountForm/js/script.js";
    let css = "/_modules/warehouse/views/subcountForm/css/style.css";
//    let xhr = new XMLHttpRequest();
//    xhr.onload = () => {
//        if (xhr.status == 200){
//            
//            fMsgBlock("Субконто",xhr.responseText, 600,1000, "subcountForm");
//            addJsCss(js,css,"subcountForm");
//            document.getElementById("subcountForm_closeButton").addEventListener("mouseover", (event) =>{
//                event.target.style["background-color"] = "red";
//            });
//            document.getElementById("subcountForm_closeButton").addEventListener("mouseout", (event) =>{
//                event.target.style["background-color"] = "inherit";
//            });
//        }
//    };
//    xhr.open("GET", "/_modules/warehouse/php/getForms/get_subcount_form.php?id="+id);
//    xhr.send();
    
    
    getXhr({
        url : "/_modules/warehouse/php/getForms/get_subcount_form.php",
        method : "GET",
        body : "id=" + id
    }).then((html) => {
        fMsgBlock("Субконто",html, 600,1000, "subcountForm");
        addJsCss(js,css,"subcountForm");
        document.getElementById("subcountForm_closeButton").addEventListener("mouseover", (event) =>{
            event.target.style["background-color"] = "red";
        });
        document.getElementById("subcountForm_closeButton").addEventListener("mouseout", (event) =>{
            event.target.style["background-color"] = "inherit";
        });
    });
    
}


/*---------------------------------------------------------------------------*/

function showListSelectForm(
        id,
        prefix = ""
){
    let js = "/_modules/warehouse/views/listSelectForm/js/script.js";
    let css = "/_modules/warehouse/views/listSelectForm/css/style.css";
    let xhr = new XMLHttpRequest();
//    xhr.onload = () => {
//        if (xhr.status == 200){
//            
//            fMsgBlock("Выбрать",xhr.responseText, 650,400, "listSelectForm");
//            addJsCss(js,css,"listSelectForm");
//            document.getElementById("listSelectForm_closeButton").addEventListener("mouseover", (event) =>{
//                event.target.style["background-color"] = "red";
//            });
//            document.getElementById("listSelectForm_closeButton").addEventListener("mouseout", (event) =>{
//                event.target.style["background-color"] = "inherit";
//            });
//        }
//    };
    let dec = new Decoder();
    if (prefix != ""){
        prefix = prefix + "_";
    }
    let data = document.getElementById(prefix + id);
    
    let result = {};
    let type = data.getAttribute("data_type");
    if (type == "select"){
        result["dir"] = data.getAttribute("data_dir");
        result["obj"] = data.getAttribute("data_obj");
        result["show"] = data.getAttribute("data_show");
    }
    if (type == "list"){
        result["subcountType"] = data.getAttribute("data_subcountType");
        result["paramType"] = id;
    }
    if (type = "subcount"){
        result["subcountType"] = data.getAttribute("data_subcountType");
        result[""] = data.id;
    }
    
    let str = "data=" + dec.arrayToStr(result);
    
//    xhr.open("POST", "/_modules/warehouse/php/getForms/get_listSelect_form.php");
//    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
//    xhr.send(str);
    getXhr({
        url : "/_modules/warehouse/php/getForms/get_listSelect_form.php",
        method : "POST",
        body : str
    }).then(function(html){
        fMsgBlock("Выбрать",html, 650,400, "listSelectForm");
        addJsCss(js,css,"listSelectForm");
        document.getElementById("listSelectForm_closeButton").addEventListener("mouseover", (event) =>{
            event.target.style["background-color"] = "red";
        });
        document.getElementById("listSelectForm_closeButton").addEventListener("mouseout", (event) =>{
            event.target.style["background-color"] = "inherit";
        });
    });
//    let result = dec.arrayToStr(data[type]);
//    console.log(result);
//    
//    xhr.open("GET", "/_modules/ware/php/getForms/get_listSelect_form.php?data="+result);
//    xhr.send();
}


/*---------------------------------------------------------------------------*/


function showNewAssetForm(){
    let js = "/_modules/warehouse/views/createAssetForm/js/script.js";
    let css = "/_modules/warehouse/views/createAssetForm/css/style.css";
//    let xhr = new XMLHttpRequest();
//    xhr.onload = () => {
//        if (xhr.status == 200){
//            
//            fMsgBlock("Создать субконто",xhr.responseText, 400,1000, "subcountCreate");
//            addJsCss(js,css,"subcountCreate");
//            document.getElementById("subcountCreate_closeButton").addEventListener("mouseover", (event) =>{
//                event.target.style["background-color"] = "red";
//            });
//            document.getElementById("subcountCreate_closeButton").addEventListener("mouseout", (event) =>{
//                event.target.style["background-color"] = "inherit";
//            });
//        }
//    };
//    xhr.open("GET", "/_modules/warehouse/php/getForms/create_asset_form.php");
//    xhr.send();
    getXhr({
        url : "/_modules/warehouse/php/getForms/create_asset_form.php",
        method : "GET",
        body : ""
    }).then(function(html){
        fMsgBlock("Создать субконто",html, 400,1000, "subcountCreate");
        addJsCss(js,css,"subcountCreate");
        document.getElementById("subcountCreate_closeButton").addEventListener("mouseover", (event) =>{
            event.target.style["background-color"] = "red";
        });
        document.getElementById("subcountCreate_closeButton").addEventListener("mouseout", (event) =>{
            event.target.style["background-color"] = "inherit";
        });
    });
}

/*---------------------------------------------------------------------------*/



/*---------------------------------------------------------------------------*/

function subcountSetter(
        extra = ""
){
    let id = _result_["subcountId"];
    document.getElementById(id).textContent = _result_["subcount"]["name"];
    document.getElementById(id).setAttribute("value",_result_["subcount"]["id"]);
    if (extra != ""){
        eval(extra)();
    }
}

/*---------------------------------------------------------------------------*/



function showSubcountSelectSetter(
        type,
        id,
        filter = null,
        extra = ""
){
    _result_["subcountId"] = id;
    _result_["subcountSetter"] = function(){
        subcountSetter(extra);
    };
    if (filter){
        var result = {};
        result[filter] = getCookie("login");
    }
    console.log(result);
    showSubcountSelectForm(type,result);
}

/*---------------------------------------------------------------------------*/




function listSetter(){
    let id = _result_["listElId"];
    console.log(_result_["listEl"]);
    document.getElementById(id).textContent = _result_["listEl"]["name"];
    document.getElementById(id).setAttribute("value",_result_["listEl"]["id"]);
    
}


/*---------------------------------------------------------------------------*/


function showListSelectSetter(
        id
){
    console.log(id);
    _result_["listElId"] = id;
    _result_["listElSetter"] = listSetter;
    
    showListSelectForm(id);
}

function showListSelectSetterPrefix(
        id
){
    console.log(id);
    _result_["listElId"] = id;
    _result_["listElSetter"] = listSetter;
    
    showListSelectForm(id.split("_")[1],id.split("_")[0]);
}

/*---------------------------------------------------------------------------*/


function showPageForm(){
    let getAt = function(n,m){
        return n.getAttribute(m);
    }
    let col = Array.from(document.getElementsByClassName("selectedMenBlock"));
    let result = "";
//    result["params"] = {};
    col.forEach((el) => {
        if (el.closest(".wareMenu")){
           result += getAt(el,"dataValue"); 
        }
        if (el.closest("#submenuOne")){
           result +="/" + getAt(el,"dataValue"); 
        }
        if (el.closest(".wareSubmenuBox")){
//            result["params"][el.getAttribute("dataNumber")] = (getAt(el,"dataValue"));
           result +="/" + getAt(el,"dataValue");
        }
    });
//    let json = JSON.stringify(result);
//    let xhr = new XMLHttpRequest();
//    
//    xhr.onload = function(){
//        if (xhr.status == 200){
//            removeJsCss("pageForm");
//            document.getElementById("container").innerHTML = xhr.responseText;
//            let js = document.getElementById("scriptFile").textContent;
//            let css = document.getElementById("cssFile").textContent;
//            addJsCss(js,css,"pageForm");
//        }
//    };
//    console.log("/_modules/warehouse/php/getForms/get_pageForm.php?data=" + result);
//    xhr.open("POST","/_modules/warehouse/php/getForms/get_pageForm.php");
//    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//    xhr.send("data="+result);
    let params = {
        url : "/_modules/warehouse/php/getForms/get_pageForm.php",
        method : "POST",
        body : "data="+result
    };
    getXhr(params).then(function(text){
        removeJsCss("pageForm");
        document.getElementById("container").innerHTML = text;
        let js = document.getElementById("scriptFile").textContent;
        let css = document.getElementById("cssFile").textContent;
        addJsCss(js,css,"pageForm");
    });
}



/*---------------------------------------------------------------------------*/

function submenuSelect(){
    let getAt = function(n,m){
        return n.getAttribute(m);
    }
    let col = Array.from(document.getElementsByClassName("selectedMenBlock"));
    let result = "";
//    result["params"] = {};
    col.forEach((el) => {
        if (el.closest(".wareMenu")){
           result += getAt(el,"dataValue"); 
        }
        if (el.closest("#submenuOne")){
           result +="/" + getAt(el,"dataValue"); 
        }
    });
//    let xhr = new XMLHttpRequest();
//    xhr.onload = function(){
//        if (xhr.status == 200){
//            document.getElementById("wareSubmenuBox").innerHTML = xhr.responseText;
//            initSubMenu();
//        }
//    };
//    xhr.open("POST","/_modules/warehouse/php/getForms/get_pageSubmenuBox.php");
//    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//    xhr.send("data="+result);
//    let params = {};
//    params["method"] = "POST";
//    params["url"] = "/_modules/warehouse/php/getForms/get_pageSubmenuBox.php";
//    params["body"] = "data="+result;
    let params = {
        url : "/_modules/warehouse/php/getForms/get_pageSubmenuBox.php",
        method : "POST",
        body : "data="+result
    };
    let xhr = getXhr(params);
    xhr.then(function(html){
        document.getElementById("wareSubmenuBox").innerHTML = html;
        initSubMenu();
    });
}

/*---------------------------------------------------------------------------*/


function initSubMenu(){
    Array.from(document.getElementsByClassName("menuBlock")).forEach((el) => {
        if (el.closest(".wareSubmenuBox")){
            el.addEventListener("click",() => clickMenu(el));
        }
    });
    
    showPageForm();
}


/*---------------------------------------------------------------------------*/

function initSubMenuOne(){
    Array.from(document.getElementsByClassName("menuBlock")).forEach((el) => {
        if (el.closest("#subMenuOne")){
            el.addEventListener("click",() => clickMenu(el));
        }
    });
    
    submenuSelect();
}

/*---------------------------------------------------------------------------*/

function initMenu(){
    Array.from(document.getElementsByClassName("menuBlock")).forEach((el) => {
        if (el.closest("#wareMenu")){
            el.addEventListener("click",() => clickMenu(el));
        }
    });
    
    menuSelect();
}
    

/*---------------------------------------------------------------------------*/


function menuSelect(){
    let getAt = function(n,m){
        return n.getAttribute(m);
    }
    let col = Array.from(document.getElementsByClassName("selectedMenBlock"));
    let result = "";
//    result["params"] = {};
    col.forEach((el) => {
        if (el.closest(".wareMenu")){
           result += getAt(el,"dataValue"); 
        }
    });
//    let xhr = new XMLHttpRequest();
//    xhr.onload = function(){
//        if (xhr.status == 200){
//            document.getElementById("wareSubmenuBox").innerHTML = xhr.responseText;
//            initSubMenu();
//        }
//    };
//    xhr.open("POST","/_modules/warehouse/php/getForms/get_pageSubmenuBox.php");
//    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//    xhr.send("data="+result);
//    let params = {};
//    params["method"] = "POST";
//    params["url"] = "/_modules/warehouse/php/getForms/get_pageSubmenuBox.php";
//    params["body"] = "data="+result;
    let params = {
        url : "/_modules/warehouse/php/getForms/get_pageSubmenuOne.php",
        method : "POST",
        body : "data="+result
    };
    let xhr = getXhr(params);
    xhr.then(function(html){
        document.getElementById("submenuOne").innerHTML = html;
        initSubMenuOne();
    });
}


/*---------------------------------------------------------------------------*/

function clickMenu(
        id
){
    let menu = Array.from(id.parentNode.childNodes);
    for(let el of menu){
        el.classList.remove("selectedMenBlock");
    }
    id.classList.add("selectedMenBlock");
    if (id.closest(".wareSubmenuBox")){
        showPageForm();
    }
    else if (id.closest("#submenuOne")){
        submenuSelect();
    }
    else if (id.closest("#wareMenu")){
        menuSelect();
    }
}



/*---------------------------------------------------------------------------*/

function showOrgSelectForm(){
    getXhr({
        url : "/_modules/warehouse/php/getForms/get_orgSelect_form.php",
        method : "GET",
        body : ""
    }).then(function(html){
        fMsgBlock("Выбор организации",html,160,300,"orgSelect");
    });
}

function setOrg(){
    let org = document.getElementById("org");
    document.cookie = "organization=" + org.options[org.selectedIndex].value;
    fUnMsgBlock("orgSelect");
    clickOn("1stat","warehouse");
}

var orgName = {
    ksk : "Кабельные сети",
    uplink : "Uplink",
    test : "ТЕСТОВАЯ",
    test2 : "ТЕСТОВАЯ2"
};

setInterval(function(){
    let org = document.getElementById("organization");
    if (!org){
        return;
    }
    if (org.textContent != orgName[getCookie("organization")]){
        org.textContent = orgName[getCookie("organization")];
        
    }
},500);

/*---------------------------------------------------------------------------*/


function showMinBalanceTableForm(){
    let name = "minBalanceTable";
    let body = "action=getTable";
    getXhr({
        url : "/_modules/warehouse/php/components/MinBalanceTable/constructor.php",
        method : "GET",
        body : body
    }).then(function(html){
        document.getElementById("container").innerHTML = "";
        fMsgBlock("Неснижаемые запасы",html, 700,1000, name,showPageForm);
        let js = document.getElementById(name + "_js").textContent;
        let css = document.getElementById(name + "_css").textContent;
        addJsCss(js,css,name);
    });
}


/*---------------------------------------------------------------------------*/

function showTreeExplorer(
        path = ""
){
    let name = "treeExplorer";
    let body = "action=get&path=" + path;
    getXhr({
        url : "/_modules/warehouse/php/components/TreeExplorer/controller.php",
        method : "GET",
        body : body
    }).then(function(html){
        fMsgBlock("Обозреватель",html, 700,1000, name);
        let js = document.getElementById(name + "_js").textContent;
        let css = document.getElementById(name + "_css").textContent;
        addJsCss(js,css,name);
    });
}

/*---------------------------------------------------------------------------*/

function showAddPriceForm(
        id
){
    let name = "addPrice";
    let body = "action=getForm" + 
            "&id=" + id;
    getXhr({
        url : "/_modules/warehouse/php/components/AddPrice/controller.php",
        method : "GET",
        body : body
    }).then(function(html){
        fMsgBlock("Установить цену",html, 280,300, name);
        let js = document.getElementById(name + "_js").textContent;
        let css = document.getElementById(name + "_css").textContent;
        addJsCss(js,css,name);
    });
}




/*---------------------------------------------------------------------------*/

function showRequestTableForm(){
    let name = "requestTableForm";
    let body = "action=getTable";
    getXhr({
        url : "/_modules/warehouse/php/components/Request/controller.php",
        method : "GET",
        body : body
    }).then(function(html){
        fMsgBlock("Запросы материала",html, 500,1000, name);
        let js = document.getElementById(name + "_js").textContent;
        let css = document.getElementById(name + "_css").textContent;
        addJsCss(js,css,name);
        
    });
}



/*---------------------------------------------------------------------------*/


function showWidth(){
    const Width = window.innerWidth;
    const Height = window.innerHeight;
    fMsgBlock("","!!!",200,200);
}


/*---------------------------------------------------------------------------*/

var gl_workfield_listeners = [];


























