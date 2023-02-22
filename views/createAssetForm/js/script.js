

function assetCreate(){
    let col = Array.from(document.getElementsByClassName("assetParam"));
    let params = {};
    
    let correct = true;
    for(let k in col){
        let key = col[k].id;
        let value = null;
        if (col[k].tagName == "INPUT"){
            value = col[k].value;
        }
        else{
            value = col[k].getAttribute("value");
        }
        if ((!key) || (!value)){
            console.log(col[k]);
            correct = false;
            break;
        }
        params[key] = value;
    }
    
    params["location"] = document.getElementById("dst").getAttribute("value");
    let data = {};
    data["name"] = document.getElementById("name").value.trim();
    data["type"] = document.getElementById("type").textContent.trim();
    data["id"] = (document.getElementById("id")) ? document.getElementById("id").textContent.trim() : "";
    if ((!data["name"]) || (!data["type"])){
        correct = false;
    }
    if (correct){
        data["params"] = params;
        let subCreate = new Promise(resolve => {
            let dec = new Decoder();
            let result = dec.arrayToStr(data);
    //        console.log(result);
            let xhr = new XMLHttpRequest();
            if (data["id"]){
//                xhr.onload = function(){
//                    if (xhr.status == 200){
//
//                        fUnMsgBlock("subcountChange");
//                        resolve(xhr.responseText);
//    //                    fMsgBlock("Сообщение","<h2>Субконто "+xhr.responseText+" изменен</h2>",200,500,"subcountCreateMessage");
//                    }
//                };
//                xhr.open("GET","/_modules/warehouse/php/helpers/change_subcount.php?data="+result);
//                xhr.send();
                
                getXhr({
                    url : "/_modules/warehouse/php/helpers/change_subcount.php",
                    method : "GET",
                    body : "data=" + result
                }).then((html) => {
                    fUnMsgBlock("subcountChange");
                    resolve(html);
                });
                
            }
            else {
//                xhr.onload = function(){
//                    if (xhr.status == 200){
//                        
//                        resolve(xhr.responseText);
//    //                    fMsgBlock("Сообщение","<h2>Субконто "+xhr.responseText+" создан</h2>",200,500,"subcountCreateMessage");
//                    }
//                };
//                console.log(result);
//                xhr.open("GET","/_modules/warehouse/php/helpers/create_subcount.php?data="+result);
//                xhr.send();
                
                getXhr({
                    url : "/_modules/warehouse/php/helpers/create_subcount.php",
                    method : "GET",
                    body : "data=" + result
                }).then((html) => {
                    resolve(html);
                });
                
            }
        });
        
        subCreate.then(id => {
            saveAssetDoc(id,params["price"]);
        });
    }
    else{
        fMsgBlock("Ошибка","<h2 style='width: 100%; text-align: center'>Заполните все данные</h3>",150,500,"errorMsg");
        return;
    }
    
}



/*---------------------------------------------------------------------------*/


function saveAssetDoc(
        id,
        price
){
    let dec = new Decoder();
    let type = "asset_income";
    let header = {};
    let table = [];
//    let timeStamp = document.getElementById("timeStamp_"+win_id).value;
    let src = document.getElementById("src");
    let dst = document.getElementById("dst");
//    header["timeStamp"] = Date.parse(timeStamp)/1000;
    header["type"] = type;
    header["src"] = src.getAttribute("value");
    header["dst"] = dst.getAttribute("value");
    header["account"] = "2410";
    header["author"] = getCookie("login");
    let correct = true;
    for(let key in header){
        if (!header[key]){
            correct = false;
        }
    }
    let buf = {};
    buf["id"] = id;
    buf["price"] = price;
    buf["count"] = 1;
    if ((!buf["id"])||(Number(buf["count"]) == 0)){
        correct = false;
    }
    table.push(buf);
    let data ={
        "header" : header,
        "table" : table
    };
    
    if (!correct){
        fMsgBlock("Ошибка","<h2 style='width: 100%; text-align: center'>Заполните все данные</h3>",150,500,"errorMsg");
        return;
    }
    
    str = dec.arrayToStr(data);
//    let xhr = new XMLHttpRequest();
//    xhr.onload = function(){
//        if (xhr.status == 200){
//            let xhr1 = new XMLHttpRequest();
//            xhr1.onload = function(){
//                if (xhr1.status == 200){
//                    fUnMsgBlock("subcountCreate");
//                    fMsgBlock("Документ Создан",xhr1.responseText,700,1000,"documentCreate");
//                }
//            };
//            xhr1.open("GET","/_modules/warehouse/php/getForms/get_oldDoc_form.php?docId="+xhr.responseText);
//            xhr1.send();
//        }
//    };
//    xhr.open("GET", "/_modules/warehouse/php/helpers/create_document.php?data="+str);
//    xhr.send();
    
    getXhr({
        url : "/_modules/warehouse/php/helpers/create_document.php",
        method : "GET",
        body : "data="+str
    }).then((html) => {
        getXhr({
            url : "/_modules/warehouse/php/getForms/get_oldDoc_form.php",
            method : "GET",
            body : "docId=" + html
        }).then((html) => {
            fUnMsgBlock("subcountCreate");
            fMsgBlock("Документ Создан",html,700,1000,"documentCreate");
        });
    });
    
}


/*---------------------------------------------------------------------------*/


function subcountChange(){
    
}


/*---------------------------------------------------------------------------*/


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
                document.getElementById(dependId).setAttribute("value","");
                document.getElementById(dependId).textContent = "...";
            }
            else{
                document.getElementById(dependId).setAttribute("data_dir","");
                document.getElementById(dependId).setAttribute("value","");
                document.getElementById(dependId).textContent = "...";
            }
        };
        let observer = new MutationObserver(callback);

        observer.observe(target,config);
    }
}






