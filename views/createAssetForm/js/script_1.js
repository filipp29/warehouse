

function subcountCreate(){
    let col = Array.from(document.getElementsByClassName("subcountParam"));
    let params = {};
    
    let correct = true;
    for(let k in col){
        let key = col[k].id;
        let value = col[k].getAttribute("value");
        if ((!key) || (!value)){
            correct = false;
            break;
        }
        params[key] = value;
    }
    let data = {};
    data["name"] = document.getElementById("name").value.trim();
    data["type"] = document.getElementById("type").textContent.trim();
    if ((!data["name"]) || (!data["type"])){
        correct = false;
    }
    if (correct){
        data["params"] = params;
        let dec = new Decoder();
        let result = dec.arrayToStr(data);
//        console.log(result);
        let xhr = new XMLHttpRequest();
        xhr.onload = function(){
            if (xhr.status == 200){
                fUnMsgBlock("subcountCreate");
                fMsgBlock("Сообщение","<h2>Субконто "+xhr.responseText+" создан</h2>",200,500,"subcountCreateMessage");
            }
        };
        xhr.open("GET","/_modules/warehouse/php/helpers/create_subcount.php?data="+result);
        xhr.send();
    }
    
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






