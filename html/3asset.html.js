Array.from(document.getElementsByClassName("menuBlock")).forEach((el) => {
    el.addEventListener("click",() => clickMenu(el));
});
showPageForm();

//if (getCookie("login") != "filipp"){
//    document.getElementById("wareMainBox").innerHTML = "<h1>Ведуться работы</h1>";
//}