<?php

class BackUserController {

    public function __construct() {
    }

    /**
     * @return void
     */
    public function execute() {
        $view = new BackUserView();
        $view->show();
    }
}
