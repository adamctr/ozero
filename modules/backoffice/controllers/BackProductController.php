<?php

class BackProductController {

    public function __construct() {
    }

    /**
     * @return void
     */
    public function execute() {
        $view = new BackProductView();
        $view->show();
    }
}
