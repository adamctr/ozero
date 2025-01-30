<?php

class UserEditProfileController {
    private $userId;
    public function __construct() {
        $userId = (new SessionController())->getUserId();
        $this->userId = $userId;
    }

    /**
     * @return void
     */
    public function execute() {
        $view = new UserEditProfileView($this->userId);
        $view->show();
    }
}
