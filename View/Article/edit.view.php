<link rel="stylesheet" href="/View/assets/create.css">
<div id="main">
    <div>
        <form action="/?page=edit&type=article" method="post">
            <div>
                <h2>Ancien titre</h2>
                <input class="title" type="text" disabled value="<?= $var->getTitle() ?>">

            </div>
            <div>
                <h2>Nouveau titre</h2>
                <input required name="title" type="text" placeholder="Un titre trop long sera coupé">
            </div>
            <div>
                <h2>Ancien contenu</h2>
                <textarea disabled required ><?= $var->getContent() ?></textarea>
            </div>
            <div>
                <h2>Nouveau Contenu</h2>
                <textarea required name="content"></textarea>
            </div>
            <div>
                <h2>Ancienne Categorie</h2>
                <div class="select">
                    <select disabled>
                        <option><?= $var->getCategory()->getName() ?></option>
                    </select>
                </div>
            </div>
            <div>
                <h2>Nouvelle categorie</h2>
                <div class="select">
                <select name="category"><?php
                    foreach((new CategoryManager)->getAllEntity() as $cat){?>
                        <option value="<?= $cat->getId()?>"><?= $cat->getName() ?></option><?php
                    }?>
                </select>
                </div>
            </div>
            <input class="hidden" type="text" name="id" value="<?= $var->getId() ?>">
            <div id="submit">
                <input type="submit" value="Publier">
            </div>
        </form>
    </div>
</div>