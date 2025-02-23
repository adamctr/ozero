<?php

class UserController
{

    public function __construct($userId = null)
    {
        if ($userId !== null) {
            $userModel = new UserModel();
            $user = $userModel->getUserById($userId);
        }
    }

    /*     public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processUpdate(); // Si la méthode est POST, on traite la mise à jour
        } else {
            $this->showEditForm(); // Sinon, on affiche le formulaire
        }
    } */

    // Affiche le formulaire d'édition
    public function Profile()
    {
        var_dump($_SESSION, $_COOKIE);
        $jwtManager = new JWT();
        $userId = $jwtManager->getUserIdFromJWT();

        $userModel = new UserModel();
        $user = $userModel->getUserById($userId);

        $roleModel = new RoleModel();
        $role = $roleModel->getRoleById($user->getRoleId());

        $addressModel = new AdressesModel();
        $addresse = $addressModel->getAddressesByUserId($userId);
        $view = new ProfileView();
        $view->show($user, $role, $addresse);
    }

    // Traite la mise à jour de l'utilisateur
    protected function processUpdate()
    {
        $firstName = $_POST['firstName'] ?? null;
        $lastName = $_POST['lastName'] ?? null;
        $nickName = $_POST['nickName'] ?? null;
        $password = $_POST['password'] ?? null;
        $userId = $_POST['userId'];
        // Validation des champs (par exemple, vérifier que le mail est valide)

        // Mise à jour des informations dans la base de données
        $userModel = new UserModel();
        $user = new UserEntity(
            $userId,
            $firstName,
            $lastName,
            $nickName,
            null,
            $password,
            false,
            null,
            $_POST['roleId'] ?? null
        );
        $userModel->updateUser($user);

        // Redirection après la mise à jour
        header('Location: /user/' . $user->getUserId());
        exit();
    }

    public function delete()
    {
        $rawData = file_get_contents('php://input');
        $data = json_decode($rawData, true);

        // Vérification de l'ID de l'utilisateur
        if (!isset($data['userId']) || empty($data['userId'])) {
            Utils::sendResponse('error', "ID de l'utilisateur manquant ou invalide");
            return;
        }

        $userId = $data['userId'];
        $userModel = new UserModel();
        // Appeler la méthode deleteUser dans le modèle pour supprimer l'utilisateur
        $result = $userModel->deleteUser($userId);

        if ($result) {
            // Si la suppression réussit, redirige vers la page d'administration ou une autre page pertinente (via JS)
            Utils::sendResponse("success", 'Utilisateur bien supprimé');
        } else {
            // Si la suppression échoue, affiche un message d'erreur
            Utils::sendResponse('error', "Une erreur est survenue lors de la suppression de l'utilisateur");
        }
    }
}
