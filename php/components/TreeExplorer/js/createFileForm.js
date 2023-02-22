{
    let target = document.getElementById("createFileLink");
    let dependId = target.getAttribute("data_depend_dir");
    let config = {
        attributes: true,
        childList: true,
        subtree: false
    };
    let callback = function(mutationList, observer){
        document.getElementById("newFileName").value = target.textContent;
    };
    let observer = new MutationObserver(callback);

    observer.observe(target,config);
}