const delete_icone = document.querySelectorAll(".delete");

for(let icon of delete_icone){
    icon.addEventListener("click",(e) => {
        render(icon);
    })
}

/**
 * Render home page article list based on
 * @param icon
 */
function render(icon){
    let req = new XMLHttpRequest();
    req.open("POST","index.php?page=delete");
    let catId
    if(icon.dataset.cat === undefined){
        catId = false;
    }
    else{
        catId = icon.dataset.cat;
    }
    req.send(JSON.stringify({"id": icon.dataset.id, "cat": catId, "type": icon.dataset.type}));
}