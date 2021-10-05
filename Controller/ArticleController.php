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
        $result = [$manager->getSingleEntity($id)];
        if($result[0]){
            $this->render("Article/guest",$result[0]->getTitle(),$result);
            return true;
        }
        return false;

    }
}