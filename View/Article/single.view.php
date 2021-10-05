<link rel="stylesheet" href="View/assets/single.css">
<div id="single-main">
    <div id="single-content" data-userid="<?= $var->getUser()->getId() ?>">
        <h1 class="single-title">
            <?= $var->getTitle() ?>
        </h1>
        <div id="single-article">
            <div id="single-article-user">
                <img id="single-article-user-img" src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6e/Breezeicons-actions-22-im-user.svg/1200px-Breezeicons-actions-22-im-user.svg.png" alt="">
                <h3 id="single-article-user-name"><a href="#"><?= $var->getUser()->getName() ?></a></h3>
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
                        <img class="comment-user-img" src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6e/Breezeicons-actions-22-im-user.svg/1200px-Breezeicons-actions-22-im-user.svg.png" alt="">
                        <h4 class="comment-user-name"><?= $comment->getUser()->getName() ?></h4>
                    </div>
                    <div class="comment-content">
                        <?= $comment->getContent() ?>
                    </div>
                </div>
                <?php
            }
        ?>
    </div>
</div>