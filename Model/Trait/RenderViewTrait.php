<?php

namespace Controller\Traits;

trait RenderViewTrait {

    public function render(string $view, string $title, array $var = null) {
        ob_start();
        require_once $_SERVER['DOCUMENT_ROOT'] . "/View/$view.view.php";
        $html = ob_get_clean();
        require_once $_SERVER['DOCUMENT_ROOT'] . '/View/_partials/base.view.php';
    }
}