{
let constructor_path = "/_modules/warehouse/php/components/MinBalanceTable/constructor.php";

function showAddMinBalanceForm(){
    let name = "minBalanceTableAddForm";
    let body = "action=getAddForm";
    getXhr({
        url : constructor_path,
        method : "GET",
        body : body
    }).then(function(html){
        fMsgBlock("Добавить запись/Изменить запись",html, 300,600, name);
    });
}

function addNewMinBalance(){
    let name = "minBalanceTableAnswer";
    let subcount1 = document.getElementById("minBalanceAdd_warehouse").getAttribute("value");
    let subcount2 = document.getElementById("minBalanceAdd_material").getAttribute("value");
    let count = document.getElementById("minBalanceAdd_count").value;
    let body = "action=add";
    body += "&subcount1=" + subcount1;
    body += "&subcount2=" + subcount2;
    body += "&count=" + count;
    getXhr({
        url : constructor_path,
        method : "GET",
        body : body
    }).then(function(html){
        fUnMsgBlock("minBalanceTableAddForm");
        fUnMsgBlock("minBalanceTable");
        
        fMsgBlock("","<div style='text-align: center'>"+html+"</div>", 100,250, name,showMinBalanceTableForm);
        
    });
}

function minBalanceTableSort(){
    let rowList = Array.from(document.getElementById("minBalanceTbody").rows);
    let warehouse = new RegExp(document.getElementById("minBalanceFilter_filter_subcount1").value.trim(),"i");
    let material = new RegExp(document.getElementById("minBalanceFilter_filter_subcount2").value.trim(),"i");
    let filterRed = document.getElementById("minBalanceFilter_filter_notFull").checked;
    rowList.forEach(row => {
        row.classList.remove("hidden");
        let correct = true;
        let rowWarehouse = row.cells[0].textContent;
        let rowMaterial = row.cells[1].textContent;
        let rowRed = row.cells[0].classList.contains("red");
        if ((!warehouse.test(rowWarehouse)) || (!material.test(rowMaterial))){
            correct = false;
        }
        if ((filterRed) && (!rowRed)){
            correct = false;
        }
        if (!correct){
            row.classList.add("hidden");
        }
    });
}

function minBalanceTableDelete(
        button
){
    let row = button.closest("tr");
    let subcount1 = row.cells[0].getAttribute("data_id");
    let subcount2 = row.cells[1].getAttribute("data_id");
    let body = "action=delete" +
            "&subcount1=" + subcount1 + 
            "&subcount2=" + subcount2;
    
    getXhr({
        url : constructor_path,
        method : "GET",
        body : body
    }).then((result) => {
        if (result == 2){
            row.closest("tbody").removeChild(row);
        }
        else{
            fMsgBlock("","<h2>Ошибка</h2>",250,400,"ERROR");
        }
    });
}

document.getElementById("minBalanceFilter_filter_subcount1").addEventListener("keyup",minBalanceTableSort);
document.getElementById("minBalanceFilter_filter_subcount2").addEventListener("keyup",minBalanceTableSort);
document.getElementById("minBalanceFilter_filter_notFull").addEventListener("change",minBalanceTableSort);
}
