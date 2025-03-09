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

    public function updateUserGeneralInfo()
    {
        try {
            $user = new UserEntity(
                $_POST['userId'],
                $_POST['firstName'],
                $_POST['lastName'],
                $_POST['nickName'],
                $_POST['mail'],
                password_hash($_POST['password'], PASSWORD_DEFAULT) ?? null,
                true,
                null,
                $_POST['roleId'] ?? null,
            );
            $userModel = new UserModel();
            $userModel->updateUser($user);

            if ($_POST['roleId'] === '1') {
                header('Location: /profile');
            } else {
                header('Location: /admin/users');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function updateUserAdresse()
    {
        try {
            $addresse = new AddressesEntity([
                'userId' => $_POST['userId'] ?? null,
                'street' => $_POST['street'] ?? null,
                'city' => $_POST['city'] ?? null,
                'zipCode' => $_POST['zipCode'] ?? null,
                'country' => $_POST['country'] ?? null,
                'phone' => $_POST['phone'] ?? null,
            ]);
            $addressesModel = new AdressesModel();
            if ($addressesModel->getAddressesByUserId($_POST['userId'])) {
                $addressesModel->updateAddress($addresse);
            } else {
                $addressesModel->createAddress($addresse);
            }
            if ($_POST['roleId'] === '1') {
                header('Location: /profile');
            } else {
                header('Location: /admin/users');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
