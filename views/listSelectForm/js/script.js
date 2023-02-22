
function selectListRow(
        dataId
){
    let rows = Array.from(document.getElementById("listSelectTbody").rows);
    for (let i in rows){
        rows[i].classList.remove("selectedList");
        if (rows[i].cells[0].getAttribute("dataId") == dataId){
            rows[i].classList.add("selectedList");
        }
    }
}




/*---------------------------------------------------------------------------*/

function submitListSelect(){
    
    
    if (Array.from(document.getElementsByClassName("selectedList")).length > 0){
        let listEl = document.getElementsByClassName("selectedList")[0].cells[0];
        var buf = {
            "name" : listEl.textContent.trim(),
            "id" : listEl.getAttribute("dataId")
        };
    }
    else{
        var buf = {
            "name" : "...",
            "id" : ""
        };
    }
    
    _result_["listEl"] = buf;
    fUnMsgBlock("listSelectForm");
    
}

function srt(
        a,
        b
){
    if (a.textContent < b.textContent){
        return -1;
    }
    else {
        return 1;
    }
}

function filterParamList(){
    let _paramName = document.getElementById("_paramName").value;
    console.log("!!");
    let rows = Array.from(document.getElementById("listSelectTbody").rows);
    for(let k in rows){
        rows[k].classList.remove("hidden");
        rows[k].classList.remove("selectedList");
        let correct = true;
        let reg = new RegExp(_paramName,"i");
        if (!reg.test(rows[k].cells[0].textContent.trim())){
            rows[k].classList.add("hidden");
        }
        
    }
    rows.sort(srt);
    let visible = [];
    let hidden = [];
    rows.forEach( el => {
        if (el.classList.contains("hidden")){
            hidden.push(el);
        }
        else{
            visible.push(el);
        }
    });
    rows = [];
    visible.forEach(el => {
        rows.push(el);
    });
    hidden.forEach(el => {
        rows.push(el);
    });
    document.getElementById("listSelectTbody").innerHTML = "";
    rows.forEach(function(el){
        document.getElementById("listSelectTbody").appendChild(el);
    });
}



{
    let buf = document.getElementById("_paramName").cloneNode();
    let el = document.getElementById("_paramName");
    el = buf.cloneNode();
    document.getElementById("_paramName").addEventListener("keyup",filterParamList);
}


filterParamList();












