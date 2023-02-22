

function subcountCreate(){
    let col = Array.from(document.getElementsByClassName("subcountCreateParam"));
    let params = {};
    
    let correct = true;
    for(let k in col){
        let key = col[k].id;
        let value = "";
        if (col[k].tagName == "INPUT"){
            value = col[k].value.trim();
        }
        else{
            value = col[k].getAttribute("value");
        }
        
        if ((!key) || (!value)){
            correct = false;
            break;
        }
        params[key.split("_")[1]] = value;
    }
    let data = {};
    data["name"] = document.getElementById("create_name").value.trim();
    data["type"] = document.getElementById("type").textContent.trim();
    data["id"] = (document.getElementById("id")) ? document.getElementById("id").textContent.trim() : "";
    if ((!data["name"]) || (!data["type"])){
        correct = false;
    }
    if (correct){
        data["params"] = params;
        let dec = new Decoder();
        let result = dec.arrayToStr(data);
//        console.log(result);
        let xhr = new XMLHttpRequest();
        if (data["id"]){
//            xhr.onload = function(){
//                if (xhr.status == 200){
//                    
//                    fUnMsgBlock("subcountChange");
//                    showSubcountListForm(data["type"]);
////                    fMsgBlock("Сообщение","<h2>Субконто "+xhr.responseText+" изменен</h2>",200,500,"subcountCreateMessage");
//                }
//            };
            fUnMsgBlock("subcountListForm");
//            xhr.open("GET","/_modules/warehouse/php/helpers/change_subcount.php?data="+result);
//            xhr.send();

            let re = /\+/gi;
            getXhr({
                url : "/_modules/warehouse/php/helpers/change_subcount.php",
                method : "GET",
                body : "data=" + result.replace(re, '%2B')
            }).then((html) => {
                console.log(html);
                fUnMsgBlock("subcountChange");
                if (document.getElementById("tableBox")){
                    showPageForm();
                }
                else{
                    showSubcountListForm(data["type"]);
                }
            });
            
        }
        else {
//            xhr.onload = function(){
//                if (xhr.status == 200){
//                    fUnMsgBlock("subcountCreate");
//                    showSubcountListForm(data["type"]);
////                    fMsgBlock("Сообщение","<h2>Субконто "+xhr.responseText+" создан</h2>",200,500,"subcountCreateMessage");
//                }
//            };
            fUnMsgBlock("subcountListForm");
//            xhr.open("GET","/_modules/warehouse/php/helpers/create_subcount.php?data="+result);
//            xhr.send();

            let re = /\+/gi;
            getXhr({
                url : "/_modules/warehouse/php/helpers/create_subcount.php",
                method : "GET",
                body : "data=" + result.replace(re, '%2B')
            }).then((html) => {
                fUnMsgBlock("subcountCreate");
                if (document.getElementById("tableBox")){
                    showPageForm();
                }
                else{
                    showSubcountListForm(data["type"]);
                }
            });
            
        }
    }
    
}


/*---------------------------------------------------------------------------*/


function subcountChange(){
    
}


/*---------------------------------------------------------------------------*/


var col = Array.from(document.getElementsByClassName("subcountCreateParam"));

for (let target of col){
    if (target.getAttribute("data_depend_dir")){
        let dependId = target.getAttribute("data_depend_dir");
        dependId = "create_" + dependId;
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






