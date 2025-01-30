<?php

class BlogController {

    public function __construct() {
    }

    /**
     * @return void
     */
    public function execute() {
        $view = new BlogView();
        $view->show();
    }
}
