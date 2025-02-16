<?php

class BackCategoryController {

    public function __construct() {
    }

    /**
     * @return void
     */
    public function execute() {
        $view = new BackCategoryView();
        $view->show();
    }
}
