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
        if($user){?>
            <a href="?page=create" class="home-article-content create">
                <h2 class="home-article-title">Créer une publication</h2>
            </a>
        <?php
        }
        foreach($var as $article){?>
            <div class="home-article-container">
                <a class="home-article-content" style="background-color:<?= $article->getCategory()->getColor() ?>" href="?page=article&article=<?= $article->getId() ?>" >
                    <img class="home-article-img" src="<?= $article->getUser()->getImg() ?>" alt="profile-pic">
                    <h2 class="home-article-title"><?= $article->getTitle() ?></h2>
                    <aside class="home-article-date">date</aside>
                </a>
                <?php
                if($user){
                    if($user->getId() === $article->getUser()->getId()){?>
                        <div class="delete-container">
                            <i class="far fa-trash-alt delete" data-id="<?= $article->getId() ?>"></i>
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


