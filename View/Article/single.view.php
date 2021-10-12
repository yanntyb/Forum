<?php
if(isset($_SESSION["user"])){
    $user = unserialize($_SESSION["user"]);
}
else{
    $user = false;
}
?>

<link rel="stylesheet" href="/View/assets/single.css">
<div id="single-main">
    <div id="single-content" data-userid="<?= $var->getUser()->getId() ?>">
        <h1 class="single-title">
            <?= ucfirst($var->getTitle()) ?>
        </h1>
        <div id="single-article">
            <div id="single-article-user">
                <img id="single-article-user-img" src="<?= $var->getUser()->getImg() ?>" alt="<?= $var->getUser()->getName() . '-profile-pic' ?>">
                <h3 id="single-article-user-name"><?= $var->getUser()->getName() . "  (" . $var->getDate() . ")" ?></h3>
            </div>
            <div id="single-article-content">
                <?= $var->getContent() ?>
            </div>
        </div>
    </div>
    <div id="comment">
        <h1 class="single-title">Commentaire(s)</h1>
        <?php
            foreach((new CommentManager())->getArticleComment($var->getId()) as $comment){?>
                <div id="comment-id-<?= $comment->getId() ?>"
                     class="comment-single <?php
                     if(isset($_GET["new"])){
                         if($comment->getId() === intval($_GET["new"])){
                             echo "new";
                         }
                     }?>">
                    <div class="comment-user">
                        <img class="comment-user-img" src="<?= $comment->getUser()->getImg() ?>" alt="<?= $comment->getUser()->getName() . '-profile-pic' ?>">
                        <h4 class="comment-user-name"><?= $comment->getUser()->getName() . "  (" . $comment->getDate() . ")" ?></h4>
                    </div>
                    <div class="comment-content">
                        <?= $comment->getContent() ?>
                    </div>
                </div><?php
                if($user && ($comment->getArticle()->getCategory()->getArchive() === 0 || $user->getRole()->getName() === "admin")){
                    if($user->getId() === $comment->getUser()->getId() || $user->getRole()->getName() === "admin" || $user->getRole()->getName() === "mode"){?>
                        <a href="/index.php?page=article&methode=render&article=<?=$comment->getArticle()->getId() ?>"  class="far fa-trash-alt delete" data-type="comment" data-id="<?= $comment->getId() ?>"></a>
                        <a href="/index.php?page=comment&methode=edit&id=<?= $comment->getId() ?>" class="far fa-edit edit"></a>
                        <?php
                    }
                }
            }
            if(($user && $var->getCategory()->getArchive() === 0) || ($user && $user->getRole()->getName() === "admin")){
                ?>
                <form action="/index.php?page=comment&methode=new" method="post" class="comment-single" id="form-comment">
                    <div class="comment-user">
                        <img src="<?= $user->getImg() ?>" alt="<?= $user->getName() . '-profile-pic' ?>" class="comment-user-img">
                        <h4 class="comment-user-name"><?= $user->getName() ?></h4>
                    </div>
                    <div class="comment-content">
                        <textarea name="content" id="" cols="30" rows="10"></textarea>
                        <div id="submit">
                            <input type="submit" value="Envoyer">
                        </div>
                        <input class="hidden" type="text" name="article-id" value="<?= $var->getId()?>">
                    </div>
                </form><?php
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
