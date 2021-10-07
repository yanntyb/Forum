<?php

use Controller\Traits\RenderViewTrait;

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
            if((new CategoryManager)->getSingleEntity($category)){
                $var = [$manager->getAllEntity("category_fk",$category), "same" => [true, $category]];
            }
            else{
                header("Location: index.php");
            }
        }
        else{
            $var = [$manager->getAllEntity(), "same" => [false]];
        }
        $this->render('Home/guest',"Home",$var);
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


}