function saveRequest(){
    let material = document.getElementById("requestMaterial").getAttribute("value").trim();
    let warehouse = document.getElementById("requestWarehouse").getAttribute("value").trim();
    let count = document.getElementById("requestCount").value.trim();
    if ((material == "") || (warehouse == "") || (count == "")){
        let text = "<h2 style='width: 100%; text-align: center;'>Заполните все данные</h2>";
        fMsgBlock("Ошибка",text,155,210,"ERROR");
        return
    }
    let body = "action=create" + 
            "&material=" + material +
            "&warehouse=" + warehouse +
            "&count=" + count;
    getXhr({
        url : "/_modules/warehouse/php/components/Request/controller.php",
        body : body,
        method : "GET"
    }).then((html) => {
        fUnMsgBlock("requestTableForm");
        showRequestTableForm();
        fUnMsgBlock("createRequest");
    });
}


/*---------------------------------------------------------------------------*/

function showCreateRequestForm(){
    let name = "createRequest";
    let body = "action=createForm";
    getXhr({
        url : "/_modules/warehouse/php/components/Request/controller.php",
        method : "GET",
        body : body
    }).then(function(html){
        fMsgBlock("Создать запрос материала",html, 265,530, name);
        let js = document.getElementById(name + "_js").textContent;
        let css = document.getElementById(name + "_css").textContent;
        addJsCss(js,css,name);
    });
}

/*---------------------------------------------------------------------------*/

function deleteRequest(
        button
){
    let row = button.closest("tr");
    let material = row.cells[2].getAttribute("dataId");
    let warehouse = row.cells[1].getAttribute("dataId");
    let body = "action=delete" + 
            "&material=" + material +
            "&warehouse=" + warehouse;
    getXhr({
        url : "/_modules/warehouse/php/components/Request/controller.php",
        method : "GET",
        body : body
    }).then(function(html){
        fUnMsgBlock("requestTableForm");
        showRequestTableForm();
    });
}

/*---------------------------------------------------------------------------*/

function submitRequest(
        button
){
    let row = button.closest("tr");
    let material = row.cells[2].getAttribute("dataId");
    let warehouse = row.cells[1].getAttribute("dataId");
    let body = "action=submit" + 
            "&material=" + material +
            "&warehouse=" + warehouse;
    getXhr({
        url : "/_modules/warehouse/php/components/Request/controller.php",
        method : "GET",
        body : body
    }).then(function(html){
        console.log(html);
        fUnMsgBlock("requestTableForm");
        showRequestTableForm();
    });
}


/*---------------------------------------------------------------------------*/