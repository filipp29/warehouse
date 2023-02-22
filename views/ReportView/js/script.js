
function getSubcountMaterialTable(){
    let timeStamp1 = Date.parse(document.getElementById("timeStamp1").value)/1000;
    let timeStamp2 = Date.parse(document.getElementById("timeStamp2").value)/1000;
    let subcount1 = document.getElementById("subcount1").getAttribute("value");
    let dec = new Decoder();
    let vars = dec.strToArray(document.getElementById("var").textContent);
    let subcount2 = document.getElementById("subcount2").getAttribute("value");
    let account = vars["account"];
    let listType = vars["listType"];
    let byType1 = vars["byType1"];
    let byType2 = vars["byType2"];
//    let xhr = new XMLHttpRequest();
//    xhr.onload = function(){
//        if (xhr.status == 200){
//            document.getElementById("reportTbody").innerHTML = xhr.responseText;
//        }
//    };
    let data = "timeStamp1="+timeStamp1+"&timeStamp2="+timeStamp2+"&subcount1="+subcount1+"&subcount2="+subcount2+"&listType="+listType+"&byType1="+byType1+"&byType2="+byType2+"&account="+account;
//    console.log(data);
//    xhr.open("GET","/_modules/warehouse/php/getForms/get_subcount_material_report_table.php?"+data);
//    xhr.send();
    
    getXhr({
        url : "/_modules/warehouse/php/getForms/get_subcount_material_report_table.php",
        method : "GET",
        body : data
    }).then((html) => {
        document.getElementById("reportTbody").innerHTML = html;
    });
}



/*---------------------------------------------------------------------------*/


function getSubcountListTable(){
    let timeStamp1 = Date.parse(document.getElementById("timeStamp1").value)/1000;
    let timeStamp2 = Date.parse(document.getElementById("timeStamp2").value)/1000;
    let subcount2 = document.getElementById("subcount2").getAttribute("value");
    let dec = new Decoder();
    let vars = dec.strToArray(document.getElementById("var").textContent);
    let account = vars["account"];
    let listType = vars["listType"];
//    let xhr = new XMLHttpRequest();
//    xhr.onload = function(){
//        if (xhr.status == 200){
//            document.getElementById("reportTbody").innerHTML = xhr.responseText;
//        }
//    };
    let data = "timeStamp1="+timeStamp1+"&timeStamp2="+timeStamp2+"&subcount2="+subcount2+"&listType="+listType+"&account="+account;
//    console.log(data);
//    xhr.open("GET","/_modules/warehouse/php/getForms/get_subcount_material_report_table.php?"+data);
//    xhr.send();
    
    getXhr({
        url : "/_modules/warehouse/php/getForms/get_subcountList_report_table.php",
        method : "GET",
        body : data
    }).then((html) => {
        document.getElementById("reportTbody").innerHTML = html;
    });
}


/*---------------------------------------------------------------------------*/


function getSubcountSubcountTable(){
    let timeStamp1 = Date.parse(document.getElementById("timeStamp1").value)/1000;
    let timeStamp2 = Date.parse(document.getElementById("timeStamp2").value)/1000;
    let subcount1 = document.getElementById("subcount1").getAttribute("value");
    let dec = new Decoder();
    let vars = dec.strToArray(document.getElementById("var").textContent);
    let subcount2 = document.getElementById("subcount2").getAttribute("value");
    let subcount3 = document.getElementById("subcount3").getAttribute("value");
    let listType = vars["listType"];
    let byType1 = vars["byType1"];
    let byType2 = vars["byType2"];
    let byType3 = vars["byType3"];
//    let xhr = new XMLHttpRequest();
//    xhr.onload = function(){
//        if (xhr.status == 200){
//            document.getElementById("reportTbody").innerHTML = xhr.responseText;
//        }
//    };
    let data = "timeStamp1="+timeStamp1+"&timeStamp2="+timeStamp2+"&subcount1="+subcount1+"&subcount2="+subcount2+"&subcount3="+subcount3+"&listType="+listType+"&byType1="+byType1+"&byType2="+byType2+"&byType3="+byType3;
//    console.log(data);
//    xhr.open("GET","/_modules/warehouse/php/getForms/get_subcount_subcount_report_table.php?"+data);
//    xhr.send();
    
    getXhr({
        url : "/_modules/warehouse/php/getForms/get_subcount_subcount_report_table.php",
        method : "GET",
        body : data
    }).then((html) => {
        document.getElementById("reportTbody").innerHTML = html;
    });
}


/*---------------------------------------------------------------------------*/

function getEntryTableBy2(
        subcount1,
        subcount2,
        timeStamp1,
        timeStamp2,
        byType1,
        byType2,
        account = "1310"
){
//    let xhr = new XMLHttpRequest();
//    xhr.onload = function(){
//        if (xhr.status == 200){
//            fMsgBlock("Проводки",xhr.responseText,650,1000,"entryTable");
//        }
//    }
    let data = {
        "subcount1" : subcount1,
        "subcount2" : subcount2,
        "timeStamp1" : timeStamp1,
        "timeStamp2" : timeStamp2,
        "byType1" : byType1,
        "byType2" : byType2,
        "account" : account
    };
    
    let dec = new Decoder();
    let result = dec.arrayToStr(data);
//    xhr.open("GET", "/_modules/warehouse/php/getForms/get_entry_table.php?data="+result);
//    xhr.send();
    
    getXhr({
        url : "/_modules/warehouse/php/getForms/get_entry_table.php",
        method : "GET",
        body : "data=" + result
    }).then((html) => {
        fMsgBlock("Проводки",html,650,1000,"entryTable");
    });
}




/*---------------------------------------------------------------------------*/



function getEntryTableBy3(
        subcount1,
        subcount2,
        subcount3,
        timeStamp1,
        timeStamp2,
        byType1,
        byType2,
        byType3
){
//    let xhr = new XMLHttpRequest();
//    xhr.onload = function(){
//        if (xhr.status == 200){
//            fMsgBlock("Проводки",xhr.responseText,650,1000,"entryTable");
//        }
//    }
    let data = {
        "subcount1" : subcount1,
        "subcount2" : subcount2,
        "subcount3" : subcount3,
        "timeStamp1" : timeStamp1,
        "timeStamp2" : timeStamp2,
        "byType1" : byType1,
        "byType2" : byType2,
        "byType3" : byType3
    };
    
    let dec = new Decoder();
    let result = dec.arrayToStr(data);
//    xhr.open("GET", "/_modules/warehouse/php/getForms/get_entry_table.php?data="+result);
//    xhr.send();
    
    getXhr({
        url : "/_modules/warehouse/php/getForms/get_entry_table.php",
        method : "GET",
        body : "data=" + result
    }).then((html) => {
        fMsgBlock("Проводки",html,650,1000,"entryTable");
    });
}



/*---------------------------------------------------------------------------*/

function getDocumentForm(
        id
){
//    let xhr = new XMLHttpRequest();
//    xhr.onload = function(){
//        if (xhr.status == 200){
//            fMsgBlock("Документ",xhr.responseText,600,1000,"documentForm");
//        }
//    }
//    console.log(id);
//    xhr.open("GET", "/_modules/warehouse/php/getForms/get_oldDoc_form.php?docId="+id);
//    xhr.send();
    
    getXhr({
        url : "/_modules/warehouse/php/getForms/get_oldDoc_form.php",
        method : "GET",
        body : "docId=" + id
    }).then((html) => {
        fMsgBlock("Документ",html,600,1000,"documentForm");
    });
}


































