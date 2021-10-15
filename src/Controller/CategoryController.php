<?php

namespace Yanntyb\App\Controller;

use Yanntyb\App\Model\Classes\Manager\CategoryManager;
use Yanntyb\App\Model\Traits\RenderViewTrait;

class CategoryController
{
    use RenderViewTrait;

    public function delete(int $catId,User $user){
        if($user->getRole()->getName() === "admin"){
            $category = (new CategoryManager)->getSingleEntity($catId);
            if($category){
                (new CategoryManager)->delete($catId);
                $this->logger->info("Category deleted",
                    [
                        "title" => $category->getTitle(),
                        "user" => $user->getName(),
                        "user role" => $user->getRole()->getName()
                    ]);
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
     * @param $color
     * @return bool
     */
    public function publish(string $title, $content, $color): bool
    {
        $user = unserialize($_SESSION["user"]);
        $this->logger->info("New category",
            [
                "title" => $title,
                "user" => $user->getName(),
                "user role" => $user->getRole()->getName()
            ]);
        return (new CategoryManager)->publish($title, $content, $color);

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

    public function editTitle($name, $id, $user, $desc, $color){
        $category = (new CategoryManager)->getSingleEntity($id);
        if($category && $user->getRole()->getName() === "admin"){
            (new CategoryManager)->edit($name, $id, $desc, $color);
        }
    }

    public function archive($id, $user){
        $category = (new CategoryManager)->getSingleEntity($id);
        if($category && $user->getRole()->getName() === "admin"){
            (new CategoryManager)->archive($id, $category->getArchive());
            if($category->getArchive() === 0){
                $this->logger->info("Category archived",
                    [
                        "title" => $category->getName(),
                        "user" => $user->getName(),
                        "user role" => $user->getRole()->getName()
                    ]);
            }
            else{
                $this->logger->info("Category unarchived",
                    [
                        "title" => $category->getName(),
                        "user" => $user->getName(),
                        "user role" => $user->getRole()->getName()
                    ]);
            }
        }
    }
}