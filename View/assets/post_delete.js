const delete_icone = document.querySelectorAll(".delete");
const parent = document.querySelector("#home-main-list");

for(let icon of delete_icone){
    icon.addEventListener("click",() => {
        render(icon);
    })
}

/**
 * Render home page article list based on
 * @param icon
 */
function render(icon){
    for(let div of parent.querySelectorAll(".home-article-container:not(.create)")){
        parent.removeChild(div);
    }
    let req = new XMLHttpRequest();
    req.open("POST","index.php?page=delete");
    req.onload = () => {
        const response = JSON.parse(req.responseText);
        for(let article of response){
            let div = document.createElement("div");
            div.className = "home-article-container";
            parent.appendChild(div);
            div.innerHTML = `
                <a class="home-article-content" style="background-color:${article.category.color}" href="?page=article&article=${article.id}" >
                    <img class="home-article-img" src="${article.user.img}" alt="profile-pic">
                    <h2 class="home-article-title">${article.title}</h2>
                    <aside class="home-article-date">date</aside>
                </a>
                `
            if(article.connected.id === article.user.id){
                div.innerHTML += `
                    <div class="delete-container">
                            <i class="far fa-trash-alt delete" data-id="${article.id}"></i>
                    </div>
                    `
            }
        }
        for(let icon of document.querySelectorAll(".delete")){
            icon.addEventListener("click",() => {
                render(icon);
            })
        }
    }
    req.send(JSON.stringify({"id": icon.dataset.id}));
}