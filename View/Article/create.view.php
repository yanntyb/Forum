<link rel="stylesheet" href="/View/assets/create.css">
<div id="main">
    <div>
        <form action="/?page=publish&type=article" method="post">
            <div>
                <h2>Titre</h2>
                <input required name="title" type="text" placeholder="Un titre trop long sera coupé">
            </div>
            <div>
                <h2>Contenu</h2>
                <textarea required name="content"></textarea>
            </div>
            <div>

                    <?php
                    if(!is_array($var[0])){?>
                        <input name="category" class="hidden" type="text" value="<?= $var[0]->getId() ?>">
                        <input name="page" class="hidden" type="text" value="<?= $var[0]->getId() ?>"><?php
                    }
                    else{?>
                        <h2>Categorie</h2>
                        <div class="select">
                            <select name="category"><?php
                            foreach($var[0] as $cat){
                                if($cat->getArchive() === 0 || $var[1]->getRole()->getName() === "admin"){?>
                                    <option value="<?= $cat->getId()?>"><?= $cat->getName() ?></option><?php
                                }
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