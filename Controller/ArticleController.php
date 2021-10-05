<?php

use Controller\Traits\RenderViewTrait;

class ArticleController
{
    use RenderViewTrait;

    /**
     * @param $id
     * Render article based on his id
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

    public function render_create(){
        $category = (new CategoryManager)->getAllEntity();
        $this->render("Article/create","Création d'une publication",$category);
    }
}