function openFolder(
        id
){
    let path = document.getElementById("explorerPath").getAttribute("data_path") ? (document.getElementById("explorerPath").getAttribute("data_path")+"/") : "";
    fUnMsgBlock("treeExplorer");
    showTreeExplorer(path + id);
    
}

/*---------------------------------------------------------------------------*/

function back(){
    let path = document.getElementById("explorerPath").getAttribute("data_path");
    if (path != ""){
        let buf = path.split("/");
        let result = [];
        for(let i = 0 ; i < buf.length - 1; i ++){
            result.push(buf[i]);
        }
//        console.log(result.join("/"));
        fUnMsgBlock("treeExplorer");
        showTreeExplorer(result.join("/"));
    }
}

/*---------------------------------------------------------------------------*/

function createFolderForm(){
    let path = document.getElementById("explorerPath").getAttribute("data_path");
//    window.location = "/_modules/warehouse/php/components/TreeExplorer/controller.php?action=getCreateFolderForm&path="+ path;
    getXhr({
        url : "/_modules/warehouse/php/components/TreeExplorer/controller.php",
        method : "GET",
        body : "action=getCreateFolderForm&path="+ path
        
    }).then((html) => {
        fMsgBlock("Новая папка",html, 200,500, "createFolder");
    });
}

/*---------------------------------------------------------------------------*/

function createFolder(
        button
){
    let form = button.closest(".createFolderForm");
    let input = form.querySelector("#newFolderName");
    let path = input.getAttribute("data_path");
    let re = /\+/gi;
    let name = input.value.trim().replace(re,'%2B');;
    if (name == ""){
        fMsgBlock("Ошибка","<h1 style='text-align: center'>Введите имя</h1>",250,600,"ERROR");
        return;
    }
    let body = "action=createFolder" + 
            "&path=" + path + 
            "&name=" + name;
    getXhr({
        url : "/_modules/warehouse/php/components/TreeExplorer/controller.php",
        method : "GET",
        body : body
    }).then((html) => {
        w_name = "treeExplorer";
        fUnMsgBlock("createFolder");
        fUnMsgBlock("treeExplorer");
        fMsgBlock("Обозреватель",html, 700,1000, w_name);
        let js = document.getElementById(w_name + "_js").textContent;
        let css = document.getElementById(w_name + "_css").textContent;
        addJsCss(js,css,w_name);
    });
}

/*---------------------------------------------------------------------------*/

function selectTreeElement(
        elem
){
    let list = Array.from(document.getElementsByClassName("selectedTreeElement"));
    list.forEach(el => {
        el.classList.remove("selectedTreeElement");
    });
    elem.closest(".contentBlock").classList.add("selectedTreeElement");
}

/*---------------------------------------------------------------------------*/

function createFile(
        button
){
    let form = button.closest(".createFileForm");
    let input = form.querySelector("#newFileName");
    let link = form.querySelector("#createFileLink").getAttribute("value");
    let path = input.getAttribute("data_path");
    let re = /\+/gi;
    let name = input.value.trim().replace(re,'%2B');
    if (name == ""){
        fMsgBlock("Ошибка","<h1 style='text-align: center'>Введите имя</h1>",250,600,"ERROR");
        return;
    }
    let params = {
        link : link
    };
    let body = "action=createFile" + 
            "&path=" + path + 
            "&name=" + name +
            "&params=" + JSON.stringify(params);
//    console.log("/_modules/warehouse/php/components/TreeExplorer/controller.php?"+body);
    getXhr({
        url : "/_modules/warehouse/php/components/TreeExplorer/controller.php",
        method : "GET",
        body : body
    }).then((html) => {
        w_name = "treeExplorer";
        fUnMsgBlock("createFile");
        fUnMsgBlock("treeExplorer");
        fMsgBlock("Обозреватель",html, 700,1000, w_name);
        let js = document.getElementById(w_name + "_js").textContent;
        let css = document.getElementById(w_name + "_css").textContent;
        addJsCss(js,css,w_name);
    });
    
    
    
    
}

/*---------------------------------------------------------------------------*/

function createFileForm(){
    let path = document.getElementById("explorerPath").getAttribute("data_path");
//    window.location = "/_modules/warehouse/php/components/TreeExplorer/controller.php?action=getCreateFolderForm&path="+ path;
    getXhr({
        url : "/_modules/warehouse/php/components/TreeExplorer/controller.php",
        method : "GET",
        body : "action=getCreateFileForm&path="+ path
        
    }).then((html) => {
        w_name = "createFile";
        fMsgBlock("Новый файл",html, 250,500,w_name );
        let js = document.getElementById(w_name + "_js").textContent;
        let css = "";
        addJsCss(js,css,w_name);
    });
}

/*---------------------------------------------------------------------------*/

function deleteTreeElement(){
    let row = document.getElementsByClassName("selectedTreeElement")[0];
    let elem = row.getElementsByClassName("treeElementBlock")[0];
    let id = elem.getAttribute("data_id");
    let type = row.getAttribute("data_type");
    let path = document.getElementById("explorerPath").getAttribute("data_path");
    let body = "action=delete&path="+ path + 
            "&type=" + type +
            "&id=" + id;
    getXhr({
        url : "/_modules/warehouse/php/components/TreeExplorer/controller.php",
        method : "GET",
        body : body
    }).then((html) => {
        w_name = "treeExplorer";
        fUnMsgBlock("treeExplorer");
        fMsgBlock("Обозреватель",html, 700,1000, w_name);
        let js = document.getElementById(w_name + "_js").textContent;
        let css = document.getElementById(w_name + "_css").textContent;
        addJsCss(js,css,w_name);
    });
}

/*---------------------------------------------------------------------------*/

function openFile(
        id
){
    let path = document.getElementById("explorerPath").getAttribute("data_path");
    let body = "action=getFile" + 
            "&id=" + id + 
            "&path=" + path;
    getXhr({
        url : "/_modules/warehouse/php/components/TreeExplorer/controller.php",
        method : "GET",
        body : body
    }).then((json) => {
        let data = JSON.parse(json);
        let id = data["link"];
        showSubcountForm(id);
    });
}
//{
//    let target = document.getElementById("createFileLink");
//    let dependId = target.getAttribute("data_depend_dir");
//    let config = {
//        attributes: true,
//        childList: true,
//        subtree: false
//    };
//    let callback = function(mutationList, observer){
//        document.getElementById("createFileName").value = target.textContent;
//    };
//    let observer = new MutationObserver(callback);
//
//    observer.observe(target,config);
//}