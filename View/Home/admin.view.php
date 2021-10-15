<link rel="stylesheet" href="/View/assets/home.css">
<link rel="stylesheet" href="/View/assets/admin.css">
<div id="home-main">
    <div id="home-main-list">
        <?php
        if(count($var["users"]) !== 1){?>
            <div class="home-article-content create">
                <h2 class="home-article-title center">Utilisateur</h2>
            </div><?php
        }
        else{?>
            <div class="home-article-content create">
                <h2 class="home-article-title center">Il n'y a pas d'utilisateurs</h2>
            </div><?php
        }
        foreach ($var["users"] as $user){
            if ($user->getId() !== unserialize($_SESSION["user"])->getId()){?>
                <div class="home-article-container">
                    <div class="home-article-content">
                        <h2 class="home-article-title"><?= "{$user->getName()} => {$user->getRole()->getName()}" ?></h2>
                        <div class="action">
                            <a href="/index.php?page=admin" data-id="<?= $user->getId() ?>" data-type="user" class="delete">Supprimer</a>
                            <a href="/index.php?page=profile&id=<?= $user->getId() ?>"  class="modif" type="submit">Modifier</a>
                        </div>
                    </div>
                </div><?php
            }
        }?>
        <div class="home-article-content create">
            <h2 class="home-article-title center">Log</h2>
        </div><?php
        foreach ($var["log"] as $log){?>
            <div class="home-article-container">
                <div class="home-article-content">
                    <h2 class="home-article-title"><?= "{$log["date"]} => {$log["name"]} => {$log["data"]}" ?></h2>
                </div>
            </div><?php
        }?>
    </div>
</div>
<script src="/View/assets/delete.js"></script>
