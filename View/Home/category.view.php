<link rel="stylesheet" href="View/assets/home.css">
<div id="home-main">
    <div id="home-main-list">
        <?php
        foreach($var as $category){?>
            <div class="home-article-container">
            <a class="home-article-content" style="background-color:<?= $category->getColor() ?>" href="?page=category&cat=<?= $category->getId() ?>" >
                <h2 class="home-article-title"><?= $category->getName() ?></h2>
                <aside class="home-article-date">date</aside>
            </a>
            </div><?php
        }
        ?>
    </div>
</div>
