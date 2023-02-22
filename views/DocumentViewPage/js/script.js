

function clearDocTable(
        win_id
){
    let tbody = document.getElementById("docTbody_"+win_id);
    while(tbody.firstChild){
        tbody.removeChild(tbody.firstChild);
    }
}


/*---------------------------------------------------------------------------*/

function saveRunDoc(
        win_id,
        account = "1310"
){
    let dec = new Decoder();
    let str = document.getElementById("var_"+win_id).textContent;
    let type = dec.strToArray(str)["type"];
    let header = {};
    let table = [];
    let timeStamp = document.getElementById("timeStamp_"+win_id).value;
    let src = document.getElementById("src_"+win_id);
    let dst = document.getElementById("dst_"+win_id);
    header["timeStamp"] = Date.parse(timeStamp)/1000;
    header["type"] = type;
    header["src"] = src.getAttribute("value");
    header["dst"] = dst.getAttribute("value");
    header["account"] = account;
    header["author"] = getCookie("login");
    let correct = true;
    for(let key in header){
        if (!header[key]){
            correct = false;
        }
    }
    let tbody = document.getElementById("docTbody_"+win_id);
    let rows = Array.from(tbody.rows);
    if (rows.length == 0){
        correct = false;
    }
    for(let k in rows){
        
        let row = rows[k];
        let buf = {};
        let id = row.cells[0].firstChild.lastChild;
        buf["id"] = id.getAttribute("value");
        buf["price"] = row.cells[1].firstChild.value;
        buf["count"] = row.cells[2].firstChild.value;
        if ((!buf["id"])||(Number(buf["count"]) == 0)){
            correct = false;
        }
        table.push(buf);
    }
    let data ={
        "header" : header,
        "table" : table
    };
    
    if (!correct){
        fMsgBlock("Ошибка","<h2 style='width: 100%; text-align: center'>Заполните все данные</h3>",150,500,"errorMsg");
        return;
    }
    
    str = dec.arrayToStr(data);
    let xhr = new XMLHttpRequest();
    xhr.onload = function(){
        if (xhr.status == 200){
            let xhr1 = new XMLHttpRequest();
            xhr1.onload = function(){
                if (xhr1.status == 200){
                    fUnMsgBlock("documentCreate");
                    fMsgBlock("Документ Создан",xhr1.responseText,700,1000,"documentCreate");
                }
            };
            xhr1.open("GET","/_modules/warehouse/php/getForms/get_oldDoc_form.php?docId="+xhr.responseText);
            xhr1.send();
        }
    };
    xhr.open("GET", "/_modules/warehouse/php/helpers/create_document.php?data="+str);
    xhr.send();
}

/*---------------------------------------------------------------------------*/

function addDocTableRow(
        win_id,
        price = -1,
        count = -1,
){
    let dec = new Decoder();
    let str = document.getElementById("var_"+win_id).textContent;
    let data = dec.strToArray(str);
    let tableType = data["tableType"];
    let tableDepend = data["tableDepend"];
    let units = data["units"];
    let row = document.createElement("tr");
    let cell = document.createElement("td");
    let select = document.createElement("div");
    let timeStamp = document.getElementById("timeStamp_"+win_id).value;
    timeStamp = Date.parse(timeStamp)/1000;
    select.classList.add("input");
    
    data = document.createElement("div");
    data.classList.add("data");
    let selectButton = document.createElement("button");
    selectButton.setAttribute("style", "margin: 0px;width: 25px; height: 22px");
    selectButton.addEventListener("click",function(){
        let row = event.target.closest("tr");
        _result_["subcountSetter"] = function(){
            row.cells[0].firstChild.lastChild.textContent = _result_["subcount"]["name"];
            row.cells[0].firstChild.lastChild.setAttribute("value",_result_["subcount"]["id"]);
            row.cells[3].textContent = units[_result_["subcount"]["id"]];
            console.log(row.cells[1]);
            
            if (!(row.cells[1].firstChild.getAttribute("readonly") == "readonly")){
                let body = "id=" + _result_["subcount"]["id"] +
                        "&timeStamp=" + timeStamp;
                getXhr({
                    url : "/_modules/warehouse/php/helpers/get_materialPrice.php",
                    method : "GET",
                    body : body
                }).then((price) => {
                    row.cells[0].firstChild.value = price;
                });
            }   
        };
        if (tableDepend){
            let src = document.getElementById("src_"+win_id).getAttribute("value");
            let params = {};
            params[tableDepend] = (src) ? src : "??????";
            showSubcountSelectForm(tableType,params);
        }
        else{
            showSubcountSelectForm(tableType);
        }
    });
    select.appendChild(selectButton);
    select.appendChild(data);
    
    cell.appendChild(select);
    row.appendChild(cell);
    
    cell = document.createElement("td");
    cell.setAttribute("style","padding: 0px;");
    let input = document.createElement("input");
    input.setAttribute("style","width: 100%;text-align: right;");
    input.setAttribute("type","number");
    input.setAttribute("min","0");
    if (price >= 0){
        input.setAttribute("readonly","readonly");
        input.value = price;
        input.setAttribute("type","text");
    }
    cell.appendChild(input);
    row.appendChild(cell);
    
    cell = document.createElement("td");
    input = document.createElement("input");
    input.setAttribute("style","width: 100%;text-align: right");
    input.setAttribute("type","number");
    input.setAttribute("min","0");
    if (count >= 0){
        input.setAttribute("readonly","readonly");
        input.value = count;
        input.setAttribute("type","text");
    }
    cell.appendChild(input);
    row.appendChild(cell);
    
    cell = document.createElement("td");
    cell.setAttribute("style","text-align: right; padding-right: 5px;");
    row.appendChild(cell);
    
    cell = document.createElement("td");
    let button = document.createElement("button");
    button.setAttribute("style", "margin: 0px;width: 100%; height: 22px");
    button.addEventListener("click", function(event){
        let row = event.target.closest("tr");
        document.getElementById("docTbody_"+win_id).removeChild(row);
    });
    cell.appendChild(button);
    row.appendChild(cell);
//    {
//        let sel = row.cells[0].firstChild;
//        row.cells[3].textContent = units[sel.options[sel.selectedIndex].value];
//    }
    document.getElementById("docTbody_"+win_id).appendChild(row);
}






































