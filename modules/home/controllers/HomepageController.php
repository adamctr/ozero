<?php

class HomepageController {

    public function __construct() {
    }

    /**
     * @return void
     */
    public function execute() {
        $view = new HomepageView();
        $view->show();
    }

    public function blog() {
        $view = new ArticlesPageView();
        $view->blogShow();
    }

    public function diy() {
        $view = new ArticlesPageView();
        $view->diyShow();
    }
}
