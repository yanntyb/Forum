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
            <a style="background-color:<?= $article->getCategory()->getColor() ?>" href="?page=article&article=<?= $article->getId() ?>" class="home-article-content">
                <img class="home-article-img" src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6e/Breezeicons-actions-22-im-user.svg/1200px-Breezeicons-actions-22-im-user.svg.png" alt="profile-pic">
                <h2 class="home-article-title"><?= $article->getTitle() ?></h2>
                <aside class="home-article-date">date</aside>
            </a>
            <?php
        }
        ?>

    </div>
</div>

