<link rel="stylesheet" href="View/assets/single.css">
<div id="single-main">
    <div id="single-content" data-userid="<?= $var->getUser()->getId() ?>">
        <h1 class="single-title">
            <?= $var->getTitle() ?>
        </h1>
        <div id="single-article">
            <div id="single-article-user">
                <img id="single-article-user-img" src="<?= $var->getUser()->getImg() ?>" alt="<?= $var->getUser()->getName() . '-profile-pic' ?>">
                <h3 id="single-article-user-name"><?= $var->getUser()->getName() ?></h3>
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
                <div class="comment-single">
                    <div class="comment-user">
                        <img class="comment-user-img" src="<?= $comment->getUser()->getImg() ?>" alt="<?= $comment->getUser()->getName() . '-profile-pic' ?>">
                        <h4 class="comment-user-name"><?= $comment->getUser()->getName() ?></h4>
                    </div>
                    <div class="comment-content">
                        <?= $comment->getContent() ?>
                    </div>
                </div>
                <?php
            }

            $sessionUser = unserialize($_SESSION["user"]) ?? false;
            if($sessionUser){
                ?>
                <form class="comment-single">
                    <div class="comment-user">
                        <img src="<?= $sessionUser->getImg() ?>" alt="<?= $sessionUser->getName() . '-profile-pic' ?>" class="comment-user-img">
                        <h4 class="comment-user-name"><?= $sessionUser->getName() ?></h4>
                    </div>
                    <div class="comment-content">
                        <textarea name="" id="" cols="30" rows="10"></textarea>
                        <div id="submit">
                            <input type="submit" value="Envoyer">
                        </div>
                    </div>
                </form><?php
            }
        ?>
    </div>
</div>