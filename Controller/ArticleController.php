<?php

use Controller\Traits\RenderViewTrait;

class ArticleController
{
    use RenderViewTrait;

    /**
     * Render article based on his id
     * @param $id
     * @return bool
     */
    public function render_by_id($id): bool{
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
    public function render_create(){
        $category = (new CategoryManager)->getAllEntity();
        $this->render("Article/create","Création d'une publication",$category);
    }

    /**
     * Insert a new article in BDD
     * @param $title
     * @param $content
     * @param $category
     * @return bool
     */
    public function publish($title, $content, $category): bool
    {
        if((new ArticleManager)->publish($title,$content,$category,unserialize($_SESSION["user"])->getId())){
            return true;
        }
        return false;
    }

    /**
     * Delete Article from data base based
     * First check if connected user's id match with article's user's id
     * @param $articleId
     * @param $user_id
     * @return bool
     */
    public function delete($articleId,$user_id): bool
    {
        $article = (new ArticleManager)->getSingleEntity($articleId);
        if($article){
            if($article->getUser()->getId() === $user_id){
                (new ArticleManager)->deleteById($articleId);
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

    public function all_to_json(){
        if(isset($_SESSION["user"]) && !is_array(unserialize($_SESSION["user"]))){
            $userId = unserialize($_SESSION["user"])->getId();
        }
        else{
            $userId = false;
        }
        $articles = (new ArticleManager)->getAllEntity();
        $return = [];
        foreach($articles as $article){
            $return[] = [
                "title" => $article->getTitle(),
                "category" => [
                    "name" => $article->getCategory(),
                    "color" => $article->getCategory()->getColor(),
                ],
                "id" => $article->getId(),
                "user" => [
                    "id" => $article->getUser()->getId(),
                    "img" => $article->getUser()->getImg()
                ],
                "connected" => [
                    "id" => $userId
                ]
            ];
        }
        return json_encode($return);
    }
}