<?php

class UserController {

    public function __construct($userId = null) {
        if ($userId !== null) {
            $userModel = new UserModel();
            $this->user = $userModel->getUserById($userId);
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processUpdate(); // Si la méthode est POST, on traite la mise à jour
        } else {
            $this->showEditForm(); // Sinon, on affiche le formulaire
        }
    }

    // Affiche le formulaire d'édition
    protected function showEditForm() {
        // Vous pouvez passer $this->user à la vue pour afficher les données de l'utilisateur
        $view = new EditUserView($this->user);
        $view->show();
    }

    // Traite la mise à jour de l'utilisateur
    protected function processUpdate() {
        $firstName = $_POST['firstName'] ?? null;
        $lastName = $_POST['lastName'] ?? null;
        $nickName = $_POST['nickName'] ?? null;
        $password = $_POST['password'] ?? null;

        // Validation des champs (par exemple, vérifier que le mail est valide)

        // Mise à jour des informations dans la base de données
        $userModel = new UserModel();
        $userModel->updateUser(
            $this->user->getUserId(),
            $firstName,
            $lastName,
            $nickName,
            $password
        );

        // Redirection après la mise à jour
        header('Location: /user/' . $this->user->getUserId());
        exit();
    }

    public function delete() {
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
