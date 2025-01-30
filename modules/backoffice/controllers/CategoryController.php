<?php

class CategoryController {

    public function __construct() {
    }

    /**
     * @return void
     */
    public function execute() {
        $view = new CategoryView();
        $view->show();
    }
}
