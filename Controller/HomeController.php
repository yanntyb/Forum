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
}