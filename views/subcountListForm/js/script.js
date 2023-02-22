
function selectRow(
        id
){
    let rows = Array.from(document.getElementById("subcountSelectTbody").rows);
    for (let i in rows){
        rows[i].classList.remove("selected");
    }
    row = document.getElementById(id)
    row.classList.add("selected");
}





/*---------------------------------------------------------------------------*/


function submitSelect(){
    if (Array.from(document.getElementsByClassName("selected")).length > 0){
        let subcount = document.getElementsByClassName("selected")[0].cells[0];
        var buf = {
            "name" : subcount.textContent.trim(),
            "id" : subcount.getAttribute("data_id")
        };
    }
    else{
        var buf = {
            "name" : "...",
            "id" : ""
        };
    }
    _result_["subcount"] = buf;
    
}


function subcountFilter(){
    let paramList = Array.from(document.getElementsByClassName("subcountParam"));
    let params = {};
    let groupParam = document.getElementById("groupParam").textContent.trim();
    for(let i in paramList){
        if (paramList[i].id == "_name"){
            continue;
        }
        let key = paramList[i].id;
        let value = (paramList[i].tagName == "INPUT") ? paramList[i].value : paramList[i].getAttribute("value");
        params[key] = value;
    }
    let result = {};
    let rows = Array.from(document.getElementById("subcountSelectTbody").rows);
    for(let k in rows){
        rows[k].classList.remove("hidden");
        rows[k].classList.remove("selected");
        let correct = true;
        let value = document.getElementById("_name").value;
        let reg = new RegExp(value,"i"); 
//            if ((rows[k].cells[0].getAttribute("data_"+key) != value) && (value)){
        if ((value) && (rows[k].cells.length > 1) && (!reg.test(rows[k].cells[1].textContent.trim()))){
            correct = false;
        }
//        console.log(reg.test(rows[k].cells[1].textContent.trim()));
        for(let key in params){
            let value = params[key]; 
            let reg = new RegExp(value,"i"); 
//            if ((rows[k].cells[0].getAttribute("data_"+key) != value) && (value)){
            if ((value) && (rows[k].cells.length > 1) && (!reg.test(rows[k].cells[1].getAttribute("data_"+key)))){
                correct = false;
            }
        }
        if (rows[k].cells.length < 2){
            document.getElementById("subcountSelectTbody").removeChild(rows[k]);
            delete rows[k];
            correct = false;
            continue;
        }
        if (!correct){
            if (result["hidden"] === undefined){
                result["hidden"] = [];
            }
            rows[k].classList.add("hidden");
            result["hidden"].push(rows[k]);
            rows[k].setAttribute("dataGroup","hidden");
        }
        else{
            
            let group = rows[k].cells[1].getAttribute("data_"+groupParam);
            if (group){
                if (result[group] === undefined){
                    result[group] = [];
                }
                result[group].push(rows[k]);
                rows[k].setAttribute("dataGroup",group);
            }   
            else{
                if (result["default"] === undefined){
                    result["default"] = [];
                }
                result["default"].push(rows[k]);
                rows[k].setAttribute("dataGroup","default");
            }
        }
        document.getElementById("subcountSelectTbody").removeChild(rows[k]);
    }
    let count = 0;
    for(let group in result){
        if ((group != "default") && (group != "hidden")){
            let tr = document.createElement("tr");
            tr.classList.add("groupRow");
            tr.setAttribute("onclick","toggleGroup('" + group + "','" + groupParam + "')");
            let td = document.createElement("td");
            td.setAttribute("style","text-align: center;");
            td.setAttribute("colspan","3");
            td.textContent = group;
            tr.appendChild(td);
            document.getElementById("subcountSelectTbody").appendChild(tr);
        }
        for(let row of result[group]){
            if (group != "hidden"){
                count++;
                row.cells[0].textContent = count;
            }
            document.getElementById("subcountSelectTbody").appendChild(row);
        }
    }
    
}


/*---------------------------------------------------------------------------*/

function toggleGroup(
        group,
        groupParam
){
    let rows = Array.from(document.getElementById("subcountSelectTbody").rows);
    for(let k in rows){
        if (rows[k].getAttribute("dataGroup") == group){
            rows[k].classList.toggle("hidden");
            rows[k].classList.remove("selected");
        }
    }
}

/*---------------------------------------------------------------------------*/


{   
    let el = document.getElementById("_name");
    let buf = el.cloneNode();
    el = buf.cloneNode();
    document.getElementById("_name").addEventListener("keyup",function(){
        subcountFilter();
    });
    
}

var col = Array.from(document.getElementsByClassName("subcountParam"));

for (let target of col){
    if (target.getAttribute("data_depend_dir")){
        let dependId = target.getAttribute("data_depend_dir");
        let config = {
            attributes: true,
            childList: true,
            subtree: false
        };
        let callback = function(mutationList, observer){
            let path = "";
            if (target.getAttribute("value")){
                console.log(target.getAttribute("value"));
                path = target.getAttribute("data_dir")+target.getAttribute("value")+"/";
                document.getElementById(dependId).setAttribute("data_dir",path);
            }
            else{
                document.getElementById(dependId).setAttribute("data_dir","");
            }
            
        };
        let observer = new MutationObserver(callback);

        observer.observe(target,config);
    }
}

function createSubcount(
        type
){
    showNewSubcountForm(type);
}

function showSubcountOnPage(
        id,
        number
){
    getXhr({
        url: "/_modules/warehouse/php/getForms/get_subcountOnPage_form.php",
        method : "GET",
        body : "id=" + id
    }).then((html) => {
        let workfield = document.getElementById("wareMainBox");
//        let clone = workfield.cloneNode(true);
//        workfield = clone.cloneNode(true);
        let el = document.getElementById("tableBox_info");
        el.innerHTML = html;
        let box = el.getBoundingClientRect();
        
        let table = el.getElementsByTagName("table")[0];
        if (box.top < 48){
            table.style.margin = 48 - box.top + "px 15px";
        }
        gl_workfield_listeners.forEach((el) => {
            workfield.removeEventListener("scroll",el);
        });
        gl_workfield_listeners = [];
        let fn = function(){
            let el = document.getElementById("tableBox_info");
            let box = el.getBoundingClientRect();
            let workfield = document.getElementById("wareMainBox");
            let table = el.getElementsByTagName("table")[0];
            if (box.top < 48){
                table.style.margin = 48 - box.top + "px 15px";
            }
            console.log("!!!");
        }
        workfield.addEventListener("scroll",fn);
        gl_workfield_listeners.push(fn);
        
    });
    selectRow(number);
}

subcountFilter();


