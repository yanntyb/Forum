<?php

use Controller\Traits\RenderViewTrait;

class CategoryController
{
    use RenderViewTrait;

    public function delete(int $catId,User $user){
        if($user->getRole()->getName() === "admin"){
            if((new CategoryManager)->getSingleEntity($catId)){
                (new CategoryManager)->delete($catId);
            }
        }
    }

    /**
     * Render category creation page
     */
    public function render_create(){
        $this->render('Category/create',"Créer une categorie");
    }

    /**
     * Create a category
     * @param string $title
     * @param $content
     * @return bool
     */
    public function publish(string $title, $content){
        return (new CategoryManager)->publish($title, $content);
    }
}