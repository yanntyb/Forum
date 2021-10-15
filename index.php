<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

session_start();


require "vendor/autoload.php";

use Yanntyb\App\Controller\ProfileController;
use Yanntyb\App\Controller\UserController;
use Yanntyb\App\Model\Classes\Manager\ArticleManager;
use Yanntyb\App\Model\Classes\Manager\CommentManager;
use Yanntyb\App\Model\Classes\Manager\CategoryManager;

use Yanntyb\App\Controller\ArticleController;
use Yanntyb\App\Controller\CategoryController;
use Yanntyb\App\Controller\CommentController;
use Yanntyb\App\Controller\HomeController;
use Yanntyb\App\Controller\LoginController;

use Yanntyb\App\Model\Classes\Manager\UserManager;

if(isset($_GET["page"])){
    switch($_GET["page"]){
        case "article":
            //If render_by_id return false mean that articleManager could not resolved the article based on his id ($_GET["article"]
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
                case "archive":
                    $user = unserialize($_SESSION["user"]);
                    if(!is_array($user)){
                        (new ArticleController)->archive($_GET["id"], $user);
                    }
                    header("Location: index.php?new={$_GET['id']}");
                    break;
            }
            break;
        case "login":
            (new HomeController)->render_connect();
            break;
        case "deco":
            unset($_SESSION["user"]);
            header("Location: index.php?page=login");
            break;
        case "checkLog":
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
                $message = (new LoginController)->sendToken($_POST["mail"]);
                var_dump($message);
            }

            break;
        case "checkToken":
            if(isset($_GET["token"])){
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
                        $category = (new CategoryController)->publish($_POST["title"], $_POST["content"], $_POST["color"]);
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
            if($data) {
                $user = unserialize($_SESSION["user"]);
                if (!is_array($user)) {
                    if ($data->type === "article") {
                        if ((new ArticleController)->delete($data->id, $user)) {
                            if ($data->cat) {
                                $cat = (new CategoryManager)->getSingleEntity(intval($data->cat));
                            }
                        }
                    } else if ($data->type === "category") {
                        (new CategoryController)->delete($data->id, $user);
                    } else if ($data->type === "comment") {
                        (new CommentController)->delete($data->id, $user);
                    } else if ($data->type === "user") {
                        if ($user->getRole()->getName() === "admin") {
                            (new UserController)->delete($data->id);
                        }
                    }

                }
            }
            break;
        case "comment":
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
                                    (new CommentController)->edit($comment);
                                    break;
                                }
                            }
                        }
                    }
            }

            break;
        case "category":
            if(isset($_GET["id"])) {
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
                    if(isset($_POST["title"], $_POST["id"], $_POST["description"], $_POST["color"])){
                        $user = unserialize($_SESSION["user"]);
                        if(!is_array($user)){
                            (new CategoryController)->editTitle($_POST["title"] , $_POST["id"], $user, $_POST["description"], $_POST["color"]);
                        }
                    }
                    header("Location: index.php?page=category");
                    break;
                case "article":
                    $user = unserialize($_SESSION["user"]);
                    if(!is_array($user)) {
                        if (isset($_POST["title"], $_POST["content"], $_POST["id"], $_POST["category"])) {
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
                                (new CommentController)->editContent($comment, $user, $_POST["content"], $_POST["id"]);
                            }
                        }
                        header("Location: index.php?page=article&methode=render&article=" . $comment->getArticle()->getId() . "&new=" . $comment->getId() . "#comment-id-" . $comment->getId());
                    }
                    else{
                        header("Location: index.php");
                    }
                    break;
                case "profile":
                    $user = (new UserManager)->getSingleEntity($_POST["id"]);
                    if(!is_array($user)){
                        if(isset($_POST["oldPass"],$_POST["newPass"],$_POST["newPassConfirme"],$_POST["name"])){
                            if($_POST["oldPass"] === $user->getPass() && $_POST["newPass"] !== "" && $_POST["newPassConfirme"] !== "" && $_POST["newPass"] === $_POST["newPassConfirme"]){
                                (new ProfileController)->changePass($_POST["newPass"],$user);
                            }
                            if($_POST["name"] !== ""){
                                (new ProfileController)->changeName($_POST["name"], $user);
                            }
                        }
                        if($user->getId() === $_POST["id"]){
                            $_SESSION["user"] = serialize((new UserManager)->getSingleEntity($user->getId()));
                        }

                    }
                    header("Location: index.php");
                    break;
            }
            break;
        case "profile":
            $user = unserialize($_SESSION["user"]);
            if(!is_array($user)){
                if(isset($_GET["id"])){
                    $userToModif = (new UserManager)->getSingleEntity($_GET["id"]);
                    if($userToModif){
                        if($user->getRole()->getName() === "admin"){
                            (new ProfileController)->editProfile($userToModif);
                            break;
                        }
                        header("Location: index.php");
                        break;
                    }
                    header("Location: index.php");
                }
                else{
                    (new ProfileController)->editProfile($user);
                }
                break;
            }
            header("Location: index.php");
            break;

        case "admin":
            $user = unserialize($_SESSION["user"]);
            if(!is_array($user)){
                if(isset($_GET["methode"],$_GET["id"])){
                    if($_GET["method"] === "modif"){
                        $userToModif = (new UserManager)->getSingleEntity($_GET["id"]);
                    }
                }
                if($user->getRole()->getName() === "admin"){
                    (new HomeController)->render_admin();
                }
            }
            break;
    }
}
else{
    (new HomeController)->render_home();
    die();
}