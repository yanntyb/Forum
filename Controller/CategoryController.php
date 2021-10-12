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

    public function edit($id, $user){
        $category = (new CategoryManager)->getSingleEntity($id);
        if($category){
            $this->render("Category/edit","Edit " . $category->getName(), $category);
        }
        else{
            header("Location: index.php");
        }
    }

    public function editTitle($name, $id, $user, $desc){
        $category = (new CategoryManager)->getSingleEntity($id);
        if($category && $user->getRole()->getName() === "admin"){
            (new CategoryManager)->edit($name, $id, $desc);
        }
    }

    public function archive($id, $user){
        $category = (new CategoryManager)->getSingleEntity($id);
        if($category && $user->getRole()->getName() === "admin"){
            (new CategoryManager)->archive($id, $category->getArchive());
        }
    }
}