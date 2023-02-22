            <br>
            <label for="count">Количество</label>
            <br>
            <input type="number" min="0" name="count" id="count">
            <br>
            <label for="price">Цена</label>
            <br>
            <input type="number" min="0" name="price" id="price">
            <br>
            <label for="docId">Номер документа</label>
            <br>
            <input type="number" min="0" name="docId" id="docId">
            <br>
            
            <input type="submit" name="submit" value="Отправить">
        </form>
        <div id="message">
            
        </div>
        <script>
        
            function onFormSubmit(){
                let xhr = new XMLHttpRequest();
                xhr.onload = function(){
                    if (xhr.status == 200){
                        document.getElementById("message").textContent = xhr.responseText;
                    }
                }
                let src = document.getElementById("src").value;
                let dst = document.getElementById("dst").value;
                let count = document.getElementById("count").value;
                let material = document.getElementById("material").value;
                let docId = document.getElementById("docId").value;
                let price = document.getElementById("price").value;
                let data = "src="+src+"&dst="+dst+"&count="+count+"&material="+material+"&docId="+docId+"&price="+price;
                console.log(data);
                xhr.open("GET", "/_modules/warehouse/php/helpers/create_entry.php?"+data);
                xhr.send();
            }
        
        </script>
    </body>
</html>