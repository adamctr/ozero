<?php

class SessionController {

    protected $jwtHandler;

    public function __construct() {
        // Utiliser le gestionnaire de JWT
        $this->jwtHandler = new JWT();

        // Assurez-vous que la session est démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
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

    // Méthode pour récupérer le rôle de l'utilisateur
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
            if (!isset($_COOKIE['auth_token'])) {
                return null;
            }
            $payload = $this->jwtHandler->decodeJWT($_COOKIE['auth_token']);
            return $payload['name'] ?? null;
        } catch (Exception $e) {
            return null;
        }
    }

    // Méthode pour récupérer le prénom d'utilisateur depuis le JWT
    public function getFirstName() {
        try {
            if (!isset($_COOKIE['auth_token'])) {
                return null;
            }
            $payload = $this->jwtHandler->decodeJWT($_COOKIE['auth_token']);
            return $payload['firstName'] ?? null;
        } catch (Exception $e) {
            return null;
        }
    }

    // Méthode pour récupérer le nom de famille de l'utilisateur depuis le JWT
    public function getLastName() {
        try {
            if (!isset($_COOKIE['auth_token'])) {
                return null;
            }
            $payload = $this->jwtHandler->decodeJWT($_COOKIE['auth_token']);
            return $payload['lastName'] ?? null;
        } catch (Exception $e) {
            return null;
        }
    }

    // Méthode pour se déconnecter (effacer le cookie JWT et le token CSRF)
    public function logout() {
        // Supprimer le cookie JWT
        setcookie('auth_token', '', time() - 3600, '/');
        // Supprimer le CSRF Token de la session
        unset($_SESSION['csrf_token']);
    }

    // Méthode pour générer ou récupérer le CSRF Token
    public static function getCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    // Méthode pour vérifier le CSRF Token fourni
    public static function verifyCSRFToken($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}
?>
