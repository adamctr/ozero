<?php

class BackUserEditProfileController
{
    private $userId;
    public function __construct()
    {
        $userId = (new SessionController())->getUserId();
        $this->userId = $userId;
    }

    /**
     * @return void
     */
    public function execute()
    {
        $view = new BackUserEditProfileView($this->userId);
        $view->show();
    }

    public function updateUser()
    {
        try {
            $user = new UserEntity(
                $_POST['userId'],
                $_POST['firstName'],
                $_POST['lastName'],
                $_POST['nickName'],
                $_POST['mail'],
                $_POST['password'] ?? null,
                true,
                null,
                $_POST['roleId'] ?? null,
            );
            $userModel = new UserModel();
            $userModel->updateUser($user);
            header('Location: /admin/users');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
