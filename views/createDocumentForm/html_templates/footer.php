            
            
            <input type="submit" name="submit" value="Отправить">
        </form>
        <div id="count" style="display: none">
            <?=isset($count) ? $count : ""?>
        </div>
        <div id="message">
            
        </div>
        <script>
        
        
        
        /*---------------------------------------------------------------------------*/
/* ##########################################################################
 * ##########################################################################
 * ##########################################################################
 * ##########################################################################
 * ##########################################################################
 * 
 * DECODER CLASS
 * 
 * ##########################################################################
 * ##########################################################################
 * ##########################################################################
 * ---------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------*/


class Decoder{
    
    str = "";
    ar = {};
    count = 0;
    
    
    constructor(){
        this.count = 0;
    }
    
    decode(
            elem
    ){
        
        let isset($reg = /(\{.*) ? $reg = /(\{.* : ""?\})/;
        let isset($regV = /(..*) ? $regV = /(..* : ""?\{)/;
        let $result = {};
        let $flag = true;
        while($flag){
            
            if (!this.str){
                $flag = false;
                break;
            }
            
            this.count++;
            if (this.count > 10000){
                $flag = false;
                break;
            }
            
            if (this.str[0] === "{"){
                if (this.str[1] === "/"){
                    this.str = this.str.replace($reg,"");
                    $flag = false;
                    if ((typeof($result) == "object") && (Object.keys($result).length == 0)){
                        $result = "";
                    }
                    break;
                }
                else{
                    let $index = this.str.match($reg)[0];
                    $index = $index.substr(1,$index.length-2);
                    this.str = this.str.replace($reg,"");
                    $result[$index] = this.decode($index);
                }
            }
            else{
                $result = this.str.match($regV)[0];
                $result =$result.substr(0,$result.length -1);
                this.str = this.str.replace($regV,"{");
                
            }
            
        }
        return $result;
        
    }
    
    
    strToArray(
            $str
    ){
        this.str = $str;
        return this.decode("");
    }
    
    
    encode(
            $key,
            $value
    ){
        $key = String($key);
        $key = $key.trim();
        
        let $result = "{"+$key+"}";
        if (typeof($value) == "object"){
            for (let $k in $value){
                $result += this.encode($k,$value[$k]);
            }
        }
        else{
            $value = String($value);
            $value = $value.trim();
            $result += $value;
        }
        $result += "{/"+$key+"}";
        return $result;
    }
    
    arrayToStr(
            $ar
    ){
        
        this.ar = $ar;
        let $result = "";
        for(let $k in $ar){
            $result += this.encode($k,$ar[$k]);
        }
        return $result;
    }
    
    
    
}


/*---------------------------------------------------------------------------*/
/* ##########################################################################
 * ##########################################################################
 * ##########################################################################
 * ##########################################################################
 * ##########################################################################
 * 
 * 
 * ##########################################################################
 * ##########################################################################
 * ##########################################################################
 * ---------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------*/
        
        
        
            function onFormSubmit(){
                let xhr = new XMLHttpRequest();
                xhr.onload = function(){
                    if (xhr.status == 200){
                        document.getElementById("message").innerHTML = xhr.responseText;
                    }
                }
                let header = {};
                let count = document.getElementById("count").textContent;
                let timeStamp = new Date(document.getElementById("timeStamp").value);
                header["src"] = document.getElementById("src").value;
                header["dst"] = document.getElementById("dst").value;
                header["timeStamp"] = timeStamp.getTime()/1000;
                let table = [];
                for (i = 0; i < count; i++){
                    table[i] = {};
                    table[i]["id"] = document.getElementById("material_"+i).value;
                    table[i]["price"] = document.getElementById("price_"+i).value;
                    table[i]["count"] = document.getElementById("count_"+i).value;
                }
                console.log(header);
                console.log(table);
                let data = {};
                data["table"] = table;
                data["header"] = header;
                let dec = new Decoder;
                str = dec.arrayToStr(data);
                console.log(timeStamp.getTime()/1000);
                xhr.open("GET", "/_modules/warehouse/php/helpers/create_document.php?data="+str);
                xhr.send();
            }
        
        </script>
    </body>
</html>