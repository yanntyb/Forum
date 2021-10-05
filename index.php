<?php


session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Model/Class/DB.php";

require_once $_SERVER["DOCUMENT_ROOT"] . "/Model/Trait/RenderViewTrait.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Model/Trait/GlobalManagerTrait.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Model/Trait/GlobalEntityTrait.php";

require_once $_SERVER["DOCUMENT_ROOT"] . "/Model/Class/Entity/Role.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Model/Class/Manager/RoleManager.php";

require_once $_SERVER["DOCUMENT_ROOT"] . "/Model/Class/Entity/User.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Model/Class/Manager/UserManager.php";

require_once $_SERVER["DOCUMENT_ROOT"] . "/Model/Class/Entity/Category.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Model/Class/Manager/CategoryManager.php";

require_once $_SERVER["DOCUMENT_ROOT"] . "/Model/Class/Entity/Comment.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Model/Class/Manager/CommentManager.php";

require_once $_SERVER["DOCUMENT_ROOT"] . "/Model/Class/Entity/Article.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Model/Class/Manager/ArticleManager.php";

if(isset($_GET["page"])){
    switch($_GET["page"]){
        case "home":
            require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/HomeController.php";
            (new HomeController)->render_home();
            die();
        case "article":
            require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/ArticleController.php";
            //If render_by_id return false mean that articleManager couldnt resolved the article based on his id ($_GET["article"]
            //If so user is redirect to home page
            if((new ArticleController)->render_by_id($_GET["article"]) === false){
                header("Location: index.php?page=home");
                die();
            }
            die();
        case "login":
            require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/HomeController.php";
            (new HomeController)->render_connect();
            die();
        case "checkLog":
            require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/LoginController.php";
            $user = (new LoginController)->checkLog($_POST["name"],$_POST["pass"]);
            if($user){
                $_SESSION["user"] = serialize($user);
                header("Location: index.php");
            }
            else{
                header("Location: index.php?page=login");
            }
        default:
            require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/HomeController.php";
            (new HomeController)->render_home();
            die();
    }
}
else{
    require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/HomeController.php";
    (new HomeController)->render_home();
    die();
}