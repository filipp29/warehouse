function materialPriceSend(){
    
    
    let price = document.getElementById("materialPrice").value.trim();
    let timeStamp = document.getElementById("materialPriceTimeStamp").value;
    let id = document.getElementById("materialPriceId").textContent.trim();
    if ((!price) || (!timeStamp)){
        fMsgBlock("","<h2 style='widht: 100%; text-align: center;'>Заполните все данные<h2>",150,300,"ERROR");
        return;
    }
    timeStamp = Date.parse(timeStamp)/1000;
    console.log(timeStamp);
    let body = "price=" + price +
            "&timeStamp=" + timeStamp +
            "&id=" + id +
            "&action=addPrice";
    
    getXhr({
        url : "/_modules/warehouse/php/components/AddPrice/controller.php",
        method : "GET",
        body : body
    }).then((html) => {
        console.log(html);
        fUnMsgBlock("addPrice");
    });
    
    
}



{
    
    let docHeader = Array.from(document.getElementsByClassName("docHeader"));
    if (docHeader.length > 0){
        let date = docHeader[0].querySelector("input[type=datetime-local]");
        
        document.getElementById("materialPriceTimeStamp").value = date.value;
    }
    
}

