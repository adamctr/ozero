<?php

class BackUserEditProfileController {
    private $userId;
    public function __construct() {
        $userId = (new SessionController())->getUserId();
        $this->userId = $userId;
    }

    /**
     * @return void
     */
    public function execute() {
        $view = new BackUserEditProfileView($this->userId);
        $view->show();
    }
}
