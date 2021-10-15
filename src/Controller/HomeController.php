<?php

namespace Yanntyb\App\Controller;

use Yanntyb\App\Model\Classes\Manager\ArticleManager;
use Yanntyb\App\Model\Classes\Manager\CategoryManager;
use Yanntyb\App\Model\Classes\Manager\LogManager;
use Yanntyb\App\Model\Classes\Manager\UserManager;
use Yanntyb\App\Model\Traits\RenderViewTrait;

class HomeController
{
    use RenderViewTrait;

    /**
     * Render home page
     * If category is specified then only show article of this category
     */
    public function render_home(string $category = null){
        $manager = new ArticleManager();
        if($category){
            /*
             * If no category match with specified id in $_GET then user is redirected to home page
             */
            $categoryName = (new CategoryManager)->getSingleEntity($category)->getName();
            if($categoryName){
                $var = [$manager->getAllEntity("category_fk",$category), "same" => [true, $category]];
                $this->render('Home/guest',ucfirst($categoryName),$var);
            }
            else{
                header("Location: index.php");
            }
        }
        else{
            $var = [$manager->getAllEntity(), "same" => [false]];
            $this->render('Home/guest',"Home",$var);
        }

    }

    /**
     * Render login / register page
     */
    public function render_connect(){
        if(isset($_GET["error"])){
            $var = $_GET["error"]["message"];
        }
        else{
            $var = null;
        }
        $this->render("Home/connexion","Connexion",$var);
    }

    /**
     * Check user's logs
     * @param $name
     * @param $pass
     * @return bool
     */
    public function checkLog($name,$pass): bool
    {
        $user = (new UserManager)->checkLog($name,$pass);
        if($user){
            $_SESSION["user"] = $user;
            return true;
        }
        return false;
    }

    /**
     * Render category page
     */
    public function render_category(){
        $var = (new CategoryManager)->getAllEntity();
        $this->render("Home/category","Categories",$var);
    }

    public function render_admin(){
        $var = [
            "users" => (new UserManager)->getAllEntity(),
            "log" => (new LogManager)->getAllLog()
        ];
        $this->render("Home/admin", "administration", $var);
    }


}