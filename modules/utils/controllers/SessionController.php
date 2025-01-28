<?php

class SessionController {

    protected $jwtHandler;

    public function __construct() {
        // Utiliser le gestionnaire de JWT
        $this->jwtHandler = new JWT();
    }

    // Méthode pour récupérer l'ID de l'utilisateur depuis le JWT
    public function getUserId() {
        try {
            return $this->jwtHandler->getUserIdFromJWT();
        } catch (Exception $e) {
            return null;
        }
    }

    // Méthode pour vérifier si l'utilisateur est connecté (en vérifiant si le JWT est valide)
    public function isLoggedIn() {
        try {
            return $this->jwtHandler->getUserIdFromJWT() !== null;
        } catch (Exception $e) {
            return false;
        }
    }

    // Méthode pour récupérer le rôle du user
    public function getRole() {
        $userId = $this->getUserId();
        if (!$userId) {
            return null;
        }

        // Récupérer le rôle de l'utilisateur depuis la base de données
        $userModel = new UserModel();
        $user = $userModel->getUserById($userId);
        return $user->getRole();
    }

    // Méthode pour récupérer le nom d'utilisateur depuis le JWT
    public function getName() {
        try {
            $payload = $this->jwtHandler->decodeJWT($_COOKIE['auth_token']);
            return $payload['name'] ?? null;
        } catch (Exception $e) {
            return null;
        }
    }

    // Méthode pour se déconnecter (effacer le cookie JWT)
    public function logout() {
        // Supprimer le cookie JWT
        setcookie('auth_token', '', time() - 3600, '/'); // Détruire le cookie JWT
    }
}
