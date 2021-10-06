const delete_icone = document.querySelectorAll(".delete");

for(let icone of delete_icone){
    icone.addEventListener("click",() => {
        let req = new XMLHttpRequest();
        req.open("POST","index.php?page=delete");
        req.send(JSON.stringify({"id": icone.dataset.id}));
    })
}