<?php

class UserController
{
    private $purchaseId;

    public function __construct($purchaseId = null)
    {
        $this->purchaseId = $purchaseId;
    }
    // Affiche le formulaire d'édition
    public function Profile()
    {
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

    public function getOrders()
    {
        try {
            if (!isset($_COOKIE['auth_token'])) {
                header('Location: /login');
            } else {
                $jwtManager = new JWT();
                if (!$jwtManager->getUserIdFromJWT()) {
                    header('Location: /login');
                } else {
                    $userId = $jwtManager->getUserIdFromJWT();
                    $purchaseModel = new PurchaseModel();
                    $purchases = $purchaseModel->getAllPurchasesById($userId);
                    $view = new OrderView();
                    $view->showOrders($purchases);
                }
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function getOrderDetails()
    {
        try {
            if (!isset($_COOKIE['auth_token'])) {
                header('Location: /login');
            } else {
                $jwtManager = new JWT();
                if (!$jwtManager->getUserIdFromJWT()) {
                    header('Location: /login');
                } else {
                    $userId = $jwtManager->getUserIdFromJWT();;
                    $purchaseModel = new PurchaseModel();
                    $purchase = $purchaseModel->getPurchaseById($userId, $this->purchaseId);
                    $view = new OrderView();
                    $view->showOrderDetails($purchase);
                }
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
