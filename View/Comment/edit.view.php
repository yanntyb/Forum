<link rel="stylesheet" href="/View/assets/create.css">
<div id="main">
    <div>
        <form action="/?page=edit&type=comment" method="post">
            <div>
                <h2>Ancien contenue</h2>
                <textarea class="title" disabled><?= $var->getContent() ?></textarea>

            </div>
            <div>
                <h2>Nouveau contenue</h2>
                <textarea class="title" required name="content"></textarea>
            </div>
            <input class="hidden" type="text" name="id" value="<?= $var->getId() ?>">
            <div id="submit">
                <input type="submit" value="Publier">
            </div>
        </form>
    </div>
</div>