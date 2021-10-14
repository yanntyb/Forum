<?php
if(isset($_SESSION["user"])){
    $user = unserialize($_SESSION["user"]);
}
else{
    $user = false;
}
?>

<link rel="stylesheet" href="/View/assets/home.css">
<div id="home-main">
    <div id="home-main-list">
        <?php
        if($user && $user->getRole()->getName() === "admin"){?>
            <a href="?page=create&type=category" class="home-article-content create">
                <h2 class="home-article-title center">Créer une categorie</h2>
            </a><?php
        }
        if($var === []){?>
            <div class="home-article-content create">
                <h2 class="home-article-title center">Il n'y a aucune categorie</h2>
            </div>
            <?php
        }
        foreach($var as $category){?>
            <div class="home-article-container">
            <a class="home-article-content" style="background-color:<?= $category->getColor() ?>" href="?page=category&cat=<?= $category->getId() ?>" >
                <h2 class="home-article-title"><?php
                    echo ucfirst($category->getName()) . "   (" . ucfirst($category->getDescription()) . ")";
                    if($category->getArchive() === 1){
                        echo "<span class='archive-span'>Archivé</span>";
                    }
                ?></h2>
            </a><?php
                if($user){
                    if($user->getRole()->getName() === "admin"){?>
                        <div class="delete-container">
                            <a href="/index.php?page=category" data-type="category" class="far fa-trash-alt delete" data-id="<?= $category->getId() ?>"></a>
                            <a href="/index.php?page=category&methode=edit&id=<?= $category->getId() ?>" class="far fa-edit edit"></a>
                            <a href="/index.php?page=category&methode=archive&id=<?= $category->getId() ?>" class="far fa-file-archive archive"></a>
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
    <script src="/View/assets/delete.js"></script>
    <?php
}
?>