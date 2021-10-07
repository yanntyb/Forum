<link rel="stylesheet" href="View/assets/create.css">
<div id="main">
    <div>
        <form action="?page=publish" method="post">
            <div>
                <h2>Titre</h2>
                <input name="title" type="text" placeholder="Un titre trop long sera coupé">
            </div>
            <div>
                <h2>Contenu</h2>
                <textarea name="content"></textarea>
            </div>
            <div>

                    <?php
                    if(!is_array($var)){?>
                        <input name="category" class="hidden" type="text" value="<?= $var->getId() ?>">
                        <input name="page" class="hidden" type="text" value="<?= $var->getId() ?>"><?php
                    }
                    else{?>
                        <h2>Categorie</h2>
                        <div class="select">
                            <select name="category"><?php
                            foreach($var as $cat){?>
                                <option value="<?= $cat->getId()?>"><?= $cat->getName() ?></option><?php
                            }?>
                            </select>
                        </div><?php
                    }
                    ?>


            </div>
            <div id="submit">
                <input type="submit" value="Publier">
            </div>
        </form>
    </div>
</div>