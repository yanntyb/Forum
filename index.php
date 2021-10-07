<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

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

require_once $_SERVER["DOCUMENT_ROOT"] . "/Model/Class/Entity/Token.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Model/Class/Manager/TokenManager.php";

session_start();

if(isset($_GET["page"])){
    switch($_GET["page"]){
        case "article":
            require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/ArticleController.php";
            //If render_by_id return false mean that articleManager couldnt resolved the article based on his id ($_GET["article"]
            //If so user is redirect to home page
            if((new ArticleController)->render_by_id($_GET["article"]) === false){
                header("Location: index.php?page=home");
                break;
            }
            break;
        case "login":
            require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/HomeController.php";
            (new HomeController)->render_connect();
            break;
        case "deco":
            unset($_SESSION["user"]);
            header("Location: index.php?page=login");
            break;
        case "checkLog":
            require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/LoginController.php";
            if(isset($_POST["name"], $_POST["pass"])){
                if($_POST["name"] !== "" && $_POST["pass"] !== ""){
                    $user = (new LoginController)->checkLog($_POST["name"],$_POST["pass"]);
                    if($user){
                        $_SESSION["user"] = serialize($user);
                        header("Location: index.php");
                    }
                    else{
                        header("Location: index.php?page=login");
                    }
                }
                else{
                    header("Location: index.php?page=login");
                }
            }
            else{
                header("Location: index.php?page=login");
            }
            break;
        case "checkRegister":
            if(isset($_POST["mail"])){
                require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/LoginController.php";
                $message = (new LoginController)->sendToken($_POST["mail"]);
                var_dump($message);
            }

            break;
        case "checkToken":
            if(isset($_GET["token"])){
                require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/LoginController.php";
                (new LoginController)->checkToken($_GET["token"]);
            }
            else{
                header("Location: index.php?page=login");
            }
            break;
        case "create":
            require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/ArticleController.php";
            $user = unserialize($_SESSION["user"]);
            if($user){
                if(isset($_GET["cat"])){
                    if((new CategoryManager)->getSingleEntity($_GET["cat"])){
                        (new ArticleController)->render_create($_GET["cat"]);
                    }
                    else{
                        (new ArticleController)->render_create();
                    }
                }
                (new ArticleController)->render_create();
            }
            else{
                header("Location: index.php");
            }
            break;
        case "publish":
            if(isset($_POST["title"], $_POST["content"], $_POST["category"], $_SESSION["user"])){
                require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/ArticleController.php";
                $article = (new ArticleController)->publish($_POST["title"],$_POST["content"],$_POST["category"]);
                if($article){
                    /**
                     * If article is created from categorie then user is redirected to corresponding category page
                     * ?new=$article is used to display animation on the new created article
                     */
                    if(isset($_POST["page"])){
                        if((new CategoryManager)->getSingleEntity($_POST["page"])){
                            header("Location: index.php?page=category&cat=" . $_POST["category"] . "&new=" .$article . "#article-" . $article);
                        }
                        else{
                            header("Location: index.php?new=" .$article . "#article-" . $article);
                        }
                    }
                    else{
                        header("Location: index.php?new=" .$article . "#article-" . $article);
                    }

                }
                else{
                    header("Location: index.php");
                };
            }
            else{
                header("Location: index.php");
            }
            break;
        case "delete":
            $data = json_decode(file_get_contents("php://input"));
            if($data){
                $user = unserialize($_SESSION["user"]);
                if(!is_array($user)){
                    require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/ArticleController.php";
                    if((new ArticleController)->delete($data->id,$user)){
                        echo (new ArticleController)->all_to_json($data->cat);
                    };
                }
                else{
                    header("Location: index.php");
                }
            }
            else{
                header("Location: index.php");
            }
            break;
        case "addcomment":
            require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/ArticleController.php";
            if(isset($_POST["content"]) && $_POST["content"] !== ""){
                $user = unserialize($_SESSION["user"]);
                if(!is_array($user)){
                    $comment_id = (new ArticleController)->addComment($_POST["content"],$_POST["article-id"],$user);
                    if($comment_id){
                        header("Location: index.php?page=article&article=" . $_POST["article-id"] . "&new=" . $comment_id . "#comment-id-" . $comment_id);
                    }
                }
            }
            break;
        case "category":
            if(isset($_GET["cat"])){
                require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/HomeController.php";
                (new HomeController)->render_home($_GET["cat"]);
            }
            else{
                require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/HomeController.php";
                (new HomeController)->render_category();
            }
            break;
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