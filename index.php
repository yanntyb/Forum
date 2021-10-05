<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/Model/Class/DB.php";

require_once $_SERVER["DOCUMENT_ROOT"] . "/Model/Trait/RenderViewTrait.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Model/Trait/GlobalManagerTrait.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Model/Trait/GlobalEntityTrait.php";

require_once $_SERVER["DOCUMENT_ROOT"] . "/Model/Class/Entity/Category.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Model/Class/Manager/CategoryManager.php";

require_once $_SERVER["DOCUMENT_ROOT"] . "/Model/Class/Entity/Article.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Model/Class/Manager/ArticleManager.php";

if(isset($_GET["page"])){
    switch($_GET["page"]){
        case "home":
            require_once $_SERVER["DOCUMENT_ROOT"] . "/Controller/HomeController.php";
            (new HomeController)->render_home();
    }
}