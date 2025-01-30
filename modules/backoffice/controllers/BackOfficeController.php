<?php

class BackOfficeController {

    public function __construct() {
    }

    /**
     * @return void
     */
    public function execute() {
        $view = new BackOfficeView();
        $view->show();
    }
}
