<?php

namespace Yanntyb\App\Controller;

use Yanntyb\App\Model\Classes\Entity\User;
use Yanntyb\App\Model\Classes\Manager\ArticleManager;
use Yanntyb\App\Model\Classes\Manager\CategoryManager;
use Yanntyb\App\Model\Classes\Manager\CommentManager;
use Yanntyb\App\Model\Traits\RenderViewTrait;

class ArticleController
{
    use RenderViewTrait;

    /**
     * Render article based on his id
     * @param int $id
     * @return bool
     */
    public function render_by_id(int $id): bool{
        $manager = new ArticleManager();
        $result = $manager->getSingleEntity($id);
        if($result){
            $this->render("Article/single",$result->getTitle(),$result);
            return true;
        }
        return false;
    }

    /**
     * Article publication page
     */
    public function render_create($user, $catId = null){
        if($catId){
            $category = (new CategoryManager)->getSingleEntity($catId);
        }
        else{
            $category = (new CategoryManager)->getAllEntity();
        }
        $var = [$category, $user];
        $this->render("Article/create","Création d'une publication",$var);
    }

    /**
     * Insert a new article in BDD
     * @param string $title
     * @param string $content
     * @param int $category
     * @return false|string
     */
    public function publish(string $title, string $content, int $category)
    {
        $user = unserialize($_SESSION["user"]);
        $articleId = (new ArticleManager)->publish($title,$content,$category,$user->getId());
        if($articleId){
            $this->logger->info("Article created",
                [
                    "title" => $title,
                    "user" => $user->getName(),
                    "user role" => $user->getRole()->getName()
                ]);
            return $articleId;
        }
        return false;
    }

    /**
     * Delete Article from data base based
     * First check if connected user's id match with article's user's id
     * @param int $articleId
     * @param User $user
     * @return bool
     */
    public function delete(int $articleId, User $user): bool
    {
        $article = (new ArticleManager)->getSingleEntity($articleId);
        if($article){
            if($article->getUser()->getId() === $user->getId() || $user->getRole()->getName() === "admin" || $user->getRole()->getName() === "mode"){
                (new ArticleManager)->deleteById($articleId);
                $this->logger->info("Article deleted",
                    [
                        "title" => $article->getTitle(),
                        "user" => $user->getName(),
                        "user role" => $user->getRole()->getName()
                    ]);
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    /**
     * Add comment to article based on article's id and user's id
     * @param string $content
     * @param int $articleId
     * @param User $user
     * @return false|string
     */
    public function addComment(string $content, int $articleId, User $user)
    {
        if((new ArticleManager)->getSingleEntity($articleId)){
            $comment = (new CommentManager)->addComment($content,$articleId,$user->getId());
            if($comment){
                $this->logger->info("Comment added",
                    [
                        "title" => (new CommentManager)->getSingleEntity($comment)->getContent(),
                        "user" => $user->getName(),
                        "user role" => $user->getRole()->getName()
                    ]);
                return $comment;
            }
            return false;
        }
        return false;
    }

    public function edit($id, $user){
        $article = (new ArticleManager)->getSingleEntity($id);
        if($user->getId() === $article->getUser()->getId() || $user->getRole() === "admin" || $user->getRole() === "mode"){
            $this->render("Article/edit", "Edit " . $article->getTitle(),$article);
        }
    }

    public function editContent($title, $content, $id, $user, $cat){
        $article = (new ArticleManager)->getSingleEntity($id);
        if($article){
            if((new CategoryManager)->getSingleEntity($cat)){
                if($user->getId() === $article->getUser()->getId() || $user->getRole()->getName() === "admin" || $user->getRole()->getName() === "mode"){
                    (new ArticleManager)->edit($title, $content, $id, $cat);
                    $this->logger->info("Article edited",
                        [
                            "article name" => (new ArticleManager)->getSingleEntity($article->getId())->getTitle(),
                            "user" => $user->getName(),
                            "user role" => $user->getRole()->getName()
                        ]);
                }
            }

        }
    }

    public function archive(int $id, User $user){
        $article = (new ArticleManager)->getSingleEntity($id);
        if($article && ($article->getUser()->getId() === $user->getId() || $user->getRole()->getName() === "admin" || $user->getRole()->getName() === "mode")){
            (new ArticleManager)->archive($id, $article->getArchive());
            if($article->getArchive() === 1){
                $this->logger->info("Article unarchived",
                    [
                        "title" => $article->getTitle(),
                        "user" => $user->getName(),
                        "user role" => $user->getRole()->getName()
                    ]);
            }
            else{
                $this->logger->info("Article archived",
                    [
                        "title" => $article->getTitle(),
                        "user" => $user->getName(),
                        "user role" => $user->getRole()->getName()
                    ]);
            }

        }
    }
}