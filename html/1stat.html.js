Array.from(document.getElementsByClassName("menuBlock")).forEach((el) => {
    el.addEventListener("click",() => clickMenu(el));
});
getXhr({
    url : "/_modules/warehouse/php/getForms/get_pageSubmenuOne.php",
    method : "POST",
    body : ""
}).then((html) => {
    let wareMenu = document.getElementById("wareMenu");
    wareMenu.innerHTML = html + wareMenu.innerHTML;
    initMenu();
});

//if (getCookie("login") != "filipp"){
//    document.getElementById("wareMainBox").innerHTML = "<h1>Ведуться работы</h1>";
//}