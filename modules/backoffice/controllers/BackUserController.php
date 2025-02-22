<?php

class BackUserController
{

    public function __construct() {}

    /**
     * @return void
     */
    public function execute()
    {
        $userModel = new UserModel();
        $userList = $userModel->getUsers();

        $roleModel = new RoleModel();
        $rolesList = $roleModel->getRoles();

        $view = new BackUserView();
        $view->show($userList, $rolesList);
    }

    public function createUser()
    {

        $user = new UserEntity(
            null,
            $_POST['firstName'],
            $_POST['lastName'],
            $_POST['nickName'],
            $_POST['mail'],
            $_POST['password'] ?? null,
            true,
            null,
            $_POST['roleId'],
        );
        $userModel = new UserModel();
        $userModel->addUser($user);
        header('Location: /admin/users');
    }
}
