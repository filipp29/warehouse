
function getJournalTable(){
    let timeStamp1 = Date.parse(document.getElementById("timeStamp1").value)/1000;
    let timeStamp2 = Date.parse(document.getElementById("timeStamp2").value)/1000;
    let type = document.getElementById("type").textContent;
//    let xhr = new XMLHttpRequest();
//    xhr.onload = function(){
//        if (xhr.status == 200){
//            document.getElementById("journalTbody").innerHTML = xhr.responseText;
//        }
//    };
    let data = "timeStamp1="+timeStamp1+"&timeStamp2="+timeStamp2+"&type="+type;
//    console.log(data);
//    xhr.open("GET","/_modules/warehouse/php/getForms/get_journal_table.php?"+data);
//    xhr.send();
    
    getXhr({
        url : "/_modules/warehouse/php/getForms/get_journal_table.php",
        method : "GET",
        body : data
    }).then((html) => {
        document.getElementById("journalTbody").innerHTML = html;
    });
}

/*---------------------------------------------------------------------------*/



function getDocumentForm(
        id
){
    let js = "/_modules/warehouse/views/DocumentView/js/script.js";
    let css = "/_modules/warehouse/views/DocumentView/css/style.css";
//    let xhr = new XMLHttpRequest();
//    xhr.onload = function(){
//        if (xhr.status == 200){
//            fMsgBlock("Документ",xhr.responseText,600,1000,"documentForm");
//        }
//    }
//    console.log(id);
//    xhr.open("GET", "/_modules/warehouse/php/getForms/get_oldDoc_form.php?docId="+id);
////    cleanText("/_modules/warehouse/php/getForms/get_oldDoc_form.php?docId="+id);
//    xhr.send();
    
    getXhr({
        url : "/_modules/warehouse/php/getForms/get_oldDoc_form.php",
        method : "GET",
        body : "docId=" + id
    }).then((html) => {
        addJsCss(js,css,"documentForm");
        fMsgBlock("Документ",html,600,1000,"documentForm");
    });
}


































