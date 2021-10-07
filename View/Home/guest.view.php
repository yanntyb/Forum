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
                <a href="?page=create&cat=<?= $var["same"][1] ?>" class="home-article-content create">
                    <h2 class="home-article-title">Créer une publication</h2>
                </a><?php
            }
            else{?>
                <a href="?page=create" class="home-article-content create">
                    <h2 class="home-article-title">Créer une publication</h2>
                </a><?php
            }?>
        <?php
        }
        if($var[0] === []){?>
            <div class="home-article-content create nothover">
                <h2 class="home-article-title">Il n'y a aucun sujet dans cette categorie</h2>
            </div><?php
        }
        foreach($var[0] as $article){?>
            <div class="home-article-container">
                <a class="home-article-content" style="background-color:<?= $article->getCategory()->getColor() ?>" href="?page=article&article=<?= $article->getId() ?>" >
                    <img class="home-article-img" src="<?= $article->getUser()->getImg() ?>" alt="profile-pic">
                    <h2 class="home-article-title"><?= $article->getTitle() ?></h2>
                    <aside class="home-article-date"><?= $article->getDate() ?></aside>
                </a>
                <?php
                if($user){
                    if($user->getId() === $article->getUser()->getId() || $user->getRole()->getName() === "admin" || $user->getRole()->getName() === "mode"){?>
                        <div class="delete-container">
                            <i class="far fa-trash-alt delete" <?php if(isset($_GET["cat"])){?>
                                data-cat="<?= $article->getCategory()->getId() ?>"<?php
                            }?>  data-id="<?= $article->getId() ?>"></i>
                        </div>
                    <?php
                    }
                }?>
            </div><?php
        }
        ?>
    </div>
</div>

<?php
if($user){?>
    <script src="https://kit.fontawesome.com/78e483bd6f.js" crossorigin="anonymous"></script>
    <script src="View/assets/post_delete.js"></script>
<?php
}
?>


