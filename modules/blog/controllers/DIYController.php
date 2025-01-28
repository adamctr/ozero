<?php

class DIYController {

    public function __construct() {
    }

    /**
     * @return void
     */
    public function execute() {
        $view = new DIYView();
        $view->show();
    }
}
