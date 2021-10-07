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
        foreach($var as $category){?>
            <div class="home-article-container">
            <a class="home-article-content" style="background-color:<?= $category->getColor() ?>" href="?page=category&cat=<?= $category->getId() ?>" >
                <h2 class="home-article-title"><?= $category->getName() ?></h2><?php
                if($user){
                    if($user->getRole()->getName() === "admin"){?>
                        <div class="delete-container">
                            <i class="far fa-trash-alt delete" data-id="<?= $category->getId() ?>"></i>
                        </div>
                        <?php
                    }
                }?>

            </a>
            </div><?php
        }
        ?>
    </div>
</div>

<?php
if($user){?>
    <script src="https://kit.fontawesome.com/78e483bd6f.js" crossorigin="anonymous"></script>
    <script src="View/assets/category_delete.js"></script>
    <?php
}
?>