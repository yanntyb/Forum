<?php

use Controller\Traits\RenderViewTrait;

class HomeController
{
    use RenderViewTrait;

    /**
     * Render home page
     */
    public function render_home(){
        $manager = new ArticleManager();
        $var = $manager->getAllEntity();
        $this->render('Home/guest',"Home",$var);
    }

    public function render_connect(){
        if(isset($_GET["error"])){
            $var = $_GET["error"]["message"];
        }
        else{
            $var = null;
        }
        $this->render("Home/connexion","Connexion",$var);
    }

    public function checkLog($name,$pass): bool
    {
        $user = (new UserManager)->checkLog($name,$pass);
        if($user){
            $_SESSION["user"] = $user;
            return true;
        }
        return false;
    }

}