<?php

class ProductBackController {

    public function __construct() {
    }

    /**
     * @return void
     */
    public function execute() {
        $view = new ProductBackView();
        $view->show();
    }
}
