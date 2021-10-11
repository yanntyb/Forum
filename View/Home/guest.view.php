<?php
    if(isset($_SESSION["user"])){
        $user = unserialize($_SESSION["user"]);
    }
    else{
        $user = false;
    }
?>

<link rel="stylesheet" href="View/assets/home.css">
<div id="home-main">
    <div id="home-main-list">
        <?php
        if($user){
            if($var["same"][0]){?>
                <a href="?page=create&type=article&cat=<?= $var["same"][1] ?>" class="home-article-content create">
                    <h2 class="home-article-title center">Créer une publication</h2>
                </a><?php
            }
            else{?>
                <a href="?page=create&type=article" class="home-article-content create">
                    <h2 class="home-article-title center">Créer une publication</h2>
                </a><?php
            }?>
        <?php
        }
        if($var["same"][0] && $var[0] === []){?>
            <div class="home-article-content create nothover">
                <h2 class="home-article-title center">Il n'y a aucune publication dans cette categorie</h2>
            </div><?php
        }
        else if ($var[0] === []){?>
            <div class="home-article-content create nothover">
                <h2 class="home-article-title center">Il n'y a aucune publication</h2>
            </div><?php
        }
        foreach($var[0] as $article){?>
            <div id="article-<?= $article->getId() ?>" class="home-article-container">
                <a class="home-article-content <?php
                if(isset($_GET["new"])){
                    if($article->getId() === intval($_GET["new"])){
                        echo "new";
                    }
                }?>"
                   style="background-color:<?= $article->getCategory()->getColor() ?>" href="/?page=article&methode=render&article=<?php echo $article->getId();?>" >
                    <figure class="home-article-figure">
                        <img class="home-article-img" src="<?= $article->getUser()->getImg() ?>" alt="profile-pic">
                        <figcaption><?= substr($article->getUser()->getName(),0,40) ?></figcaption>
                    </figure>

                    <h2 class="home-article-title"><?= $article->getTitle() ?></h2>
                    <aside class="home-article-date"><?= $article->getDate();?>
                    </aside>
            </a><?php
            if($user){
                if($user->getId() === $article->getUser()->getId() || $user->getRole()->getName() === "admin" || $user->getRole()->getName() === "mode"){?>
                    <a href=
                       "<?php
                       //If user is in a category and not in home then he is redirect to the category page when he click on delete icon
                       if(isset($_GET["cat"])){
                           echo "/index.php?page=category&cat=" . $_GET["cat"];
                       }
                       else{
                           echo "/index.php";
                       }
                       ?>"
                       class="far fa-trash-alt delete" data-type="article" data-id="<?= $article->getId() ?>"></a>
                    <a href="/index.php?page=article&methode=edit&id=<?= $article->getId() ?>" class="far fa-edit edit"></a>

                    <?php
                }
            }
            ?>

            </div><?php
        }
        ?>
    </div>
</div>

<?php
if($user){?>
    <script src="https://kit.fontawesome.com/78e483bd6f.js" crossorigin="anonymous"></script>
    <script src="/View/assets/delete.js"></script>
<?php
}
?>


