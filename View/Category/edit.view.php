<link rel="stylesheet" href="/View/assets/create.css">
<div id="main">
    <div>
        <form action="/?page=edit&type=category" method="post">
            <div>
                <h2>Ancien titre</h2>
                <input class="title" type="text" disabled value="<?= $var->getName() ?>">

            </div>
            <div>
                <h2>Nouveau titre</h2>
                <input required name="title" type="text" placeholder="Un titre trop long sera coupé">
            </div>
            <div>
                <h2>Ancienne description</h2>
                <input class="title" type="text" disabled value="<?= $var->getDescription() ?>">

            </div>
            <div>
                <h2>Nouvelle description</h2>
                <input required class="title" name="description" type="text" placeholder="Une description trop longue sera coupé">
            </div>

            <input type="text" class="hidden" name="id" value="<?= $var->getId() ?>">
            <div id="submit">
                <input type="submit" value="Publier">
            </div>
        </form>
    </div>
</div>