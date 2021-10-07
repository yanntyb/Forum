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
                    <h2 class="home-article-title center">Créer une publication</h2>
                </a><?php
            }
            else{?>
                <a href="?page=create" class="home-article-content create">
                    <h2 class="home-article-title center">Créer une publication</h2>
                </a><?php
            }?>
        <?php
        }
        if($var["same"][0] && $var[0] === []){?>
            <div class="home-article-content create nothover">
                <h2 class="home-article-title center">Il n'y a aucun sujet dans cette categorie</h2>
            </div><?php
        }
        else if ($var[0] === []){?>
            <div class="home-article-content create nothover">
                <h2 class="home-article-title center">Il n'y a aucun sujet</h2>
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
                   style="background-color:<?= $article->getCategory()->getColor() ?>" href="?page=article&article=<?= $article->getId() ?>" >
                    <img class="home-article-img" src="<?= $article->getUser()->getImg() ?>" alt="profile-pic">
                    <h2 class="home-article-title"><?= $article->getTitle() ?></h2>
                    <aside class="home-article-date"><?php echo $article->getDate();
                        if($user){
                            if($user->getId() === $article->getUser()->getId() || $user->getRole()->getName() === "admin" || "mode"){?>
                                <div class="delete-container">
                                    <i class="far fa-trash-alt delete" data-id="<?= $article->getId() ?>"></i>
                                </div>
                                <?php
                            }
                        }?></aside>
                </a>
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


