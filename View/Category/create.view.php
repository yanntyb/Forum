<link rel="stylesheet" href="/View/assets/create.css">
<div id="main">
    <div>
        <form action="/?page=publish&type=category" method="post">
            <div>
                <h2>Titre</h2>
                <input required name="title" type="text" placeholder="Un titre trop long sera coupé">
            </div>
            <div>
                <h2>Descriptif </h2>
                <textarea required name="content"></textarea>
            </div>
            <div id="submit">
                <input type="submit" value="Publier">
            </div>
        </form>
    </div>
</div>