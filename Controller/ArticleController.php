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
}