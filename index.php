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
            switch($_GET["methode"]){
                case "edit":
                    if(isset($_GET["id"])){
                        $user = unserialize($_SESSION["user"]);
                        if(!is_array($user)){
                            if((new ArticleController)->edit($_GET["id"], $user) === false){
                                header("Location: index.php");
                            }
                        }

                    }
                    break;
                case "render":
                    if((new ArticleController)->render_by_id($_GET["article"]) === false){
                        header("Location: index.php");
                        break;
                    }
                    break;
            }
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
                $mail = (new LoginController)->checkToken($_GET["token"]);
                if($mail){
                    $_SESSION["mail"] = $mail;
                    (new HomeController)->renderSetPass();
                }
            }
            else{
                header("Location: index.php?page=login");
            }
            break;
        case "create":
            $user = unserialize($_SESSION["user"]);
            if($user){
                if(isset($_GET["type"])){
                    if($_GET["type"] === "article"){
                        require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/ArticleController.php";
                        if(isset($_GET["cat"])){
                            if((new CategoryManager)->getSingleEntity($_GET["cat"])){
                                (new ArticleController)->render_create($user, $_GET["cat"]);
                            }
                            else{
                                (new ArticleController)->render_create($user);
                            }
                        }
                        (new ArticleController)->render_create($user);
                    }
                    else if($_GET["type"] === "category"){
                        if($user->getRole()->getName() === "admin"){
                            require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/CategoryController.php";
                            (new CategoryController)->render_create();
                        }
                        else{
                            header("Location: index.php");
                        }
                    }
                }
                else{
                    header("Location: index.php");
                }
            }
            else{
                header("Location: index.php");
            }
            break;
        case "publish":
            if(isset($_POST["title"], $_POST["content"]) && $_POST["content"] !== "" && $_POST["title"] !== "") {
                if ($_GET["type"] === "article" && isset($_POST["category"], $_SESSION["user"])) {
                    require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/ArticleController.php";
                    $article = (new ArticleController)->publish($_POST["title"], $_POST["content"], $_POST["category"]);
                    if ($article) {
                        /**
                         * If article is created from categorie then user is redirected to corresponding category page
                         * ?new=$article is used to display animation on the new created article
                         */
                        if (isset($_POST["category"])) {
                            if ((new CategoryManager)->getSingleEntity($_POST["category"])) {
                                header("Location: index.php?page=category&cat=" . $_POST["category"] . "&new=" . $article . "#article-" . $article);
                            } else {
                                header("Location: index.php?new=" . $article . "#article-" . $article);
                            }
                        } else {
                            header("Location: index.php?new=" . $article . "#article-" . $article);
                        }

                    } else {
                        header("Location: index.php");
                    }
                }
                else if($_GET["type"] === "category"){
                    $user = unserialize($_SESSION["user"]);
                    if($user->getRole()->getName() === "admin"){
                        require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/CategoryController.php";
                        $category = (new CategoryController)->publish($_POST["title"], $_POST["content"]);
                        header("Location: index.php?page=category");
                    }
                    else{
                        header("Location: index.php");
                    }
                }
                else{
                    header("Location: index.php");
                }
                break;
            }
            header("Location: index.php");
            break;
        case "delete":
            $data = json_decode(file_get_contents("php://input"));
            if($data){
                $user = unserialize($_SESSION["user"]);
                if(!is_array($user)){
                    if($data->type === "article"){
                        require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/ArticleController.php";
                        if((new ArticleController)->delete($data->id, $user)){
                            if($data->cat){
                                $cat = (new CategoryManager)->getSingleEntity(intval($data->cat));
                            }
                        }
                    }
                    else if($data->type === "category"){
                        require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/CategoryController.php";
                        (new CategoryController)->delete($data->id, $user);
                    }
                    else if($data->type === "comment"){
                        require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/CommentController.php";
                        (new CommentController)->delete($data->id, $user);
                    }

                }
            }
            else{
                header("Location: index.php");
            }
            break;
        case "comment":
            require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/ArticleController.php";
            switch($_GET["methode"]){
                case "new":
                    if(isset($_POST["content"]) && $_POST["content"] !== ""){
                        $user = unserialize($_SESSION["user"]);
                        if(!is_array($user)){
                            $comment_id = (new ArticleController)->addComment($_POST["content"],$_POST["article-id"],$user);
                            if($comment_id){
                                header("Location: index.php?page=article&methode=render&article=" . $_POST["article-id"] . "&new=" . $comment_id . "#comment-id-" . $comment_id);
                            }
                        }
                    }
                    break;
                case "edit":
                    $user = unserialize($_SESSION["user"]);
                    if(!is_array($user)){
                        if(isset($_GET["id"])){
                            $comment = (new CommentManager)->getSingleEntity($_GET["id"]);
                            if($comment){
                                if($user->getId() === $comment->getUser()->getId() || $user->getRole()->getName() === "admin" || $user->getRole()->getName() === "mode"){
                                    require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/CommentController.php";
                                    (new CommentController)->edit($comment);
                                    break;
                                }
                            }
                        }
                    }
            }

            break;
        case "category":
            require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/HomeController.php";
            if(isset($_GET["id"])) {
                require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/CategoryController.php";
                switch($_GET["methode"]) {
                    case "edit" :
                        if (isset($_SESSION["user"])) {
                            $user = unserialize($_SESSION["user"]);
                            if (!is_array($user)) {
                                (new CategoryController)->edit($_GET["id"], $user);
                            } else {
                                header("Location: index.php");
                            }
                        } else {
                            header("Location: index.php");
                        }
                        break;
                    case "archive":
                        if(isset($_SESSION["user"])){
                            $user = unserialize($_SESSION["user"]);
                            if(!is_array($user)){

                                (new CategoryController)->archive($_GET["id"], $user);
                            }
                        }
                        header("Location: index.php?page=category");
                        break;
                    default:
                        header("Location: index.php");
                        break;

                }
            }
            else{
                if(isset($_GET["cat"])){
                    (new HomeController)->render_home($_GET["cat"]);
                }
                else{
                    (new HomeController)->render_category();
                }
            }

            break;
        case "edit":
            switch ($_GET["type"]){
                case "category":
                    if(isset($_POST["title"], $_POST["id"], $_POST["description"])){
                        $user = unserialize($_SESSION["user"]);
                        if(!is_array($user)){
                            require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/CategoryController.php";
                            (new CategoryController)->editTitle($_POST["title"] , $_POST["id"], $user, $_POST["description"]);
                        }
                    }
                    header("Location: index.php?page=category");
                    break;
                case "article":
                    $user = unserialize($_SESSION["user"]);
                    if(!is_array($user)) {
                        if (isset($_POST["title"], $_POST["content"], $_POST["id"], $_POST["category"])) {
                            require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/ArticleController.php";
                            (new ArticleController)->editContent($_POST["title"], $_POST["content"], $_POST["id"], $user, $_POST["category"]);
                        }
                    }
                    header("Location: index.php?page=article&methode=render&article=" . $_POST["id"]);
                    break;
                case "comment":
                    $user = unserialize($_SESSION["user"]);
                    $comment = (new CommentManager)->getSingleEntity($_POST["id"]);
                    if($comment){
                        if(!is_array($user)) {
                            if(isset($_POST["content"], $_POST["id"])){
                                require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/CommentController.php";
                                (new CommentController)->editContent($comment, $user, $_POST["content"], $_POST["id"]);
                            }
                        }
                        header("Location: index.php?page=article&methode=render&article=" . $comment->getArticle()->getId() . "&new=" . $comment->getId() . "#comment-id-" . $comment->getId());
                    }
                    else{
                        header("Location: index.php");
                    }

            }
    }
}
else{
    require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/HomeController.php";
    (new HomeController)->render_home();
    die();
}