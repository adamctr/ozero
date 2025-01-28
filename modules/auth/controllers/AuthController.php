<?php

class AuthController {

    public function showLoginForm() {
        $view = new AuthView();
        (new PageView($view->showLoginForm(), "Page de connexion", "Cette page sert pour l'utilisateur afin de se connecter", ['loginRegister']))->show();
    }

    public function showRegisterForm() {
        $view = new AuthView();
        (new PageView($view->showRegisterForm(), "Page d'inscription", "Cette page sert pour l'utilisateur afin de s'inscrire au site", ['loginRegister']))->show();
    }

    public function login() {
        if (!Utils::isAjax()) {
            Utils::sendResponse('error', 'Erreur lors de la requête AJAX');
            return;
        }

        $email = trim($_POST['email']) ?? '';
        $password = trim($_POST['password']) ?? '';
        $remember = trim($_POST['remember']) ?? '';

        $validation = ValidatorController::login($email, $password);
        if ($validation) {
            $userModel = new UserModel();
            $user = $userModel->getUserByEmail($email);

            $this->authenticateUser($user, $remember);
        }
    }

    public function register() {
        if (!Utils::isAjax()) {
            Utils::sendResponse('error', 'Erreur lors de la requête AJAX');
            return;
        }

        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $validation = ValidatorController::register($email, $password);
        if ($validation) {
            $userEntity = new UserEntity(null, $name, $email, $password);
            $userModel = new UserModel();
            $userModel->createUser($userEntity);

            $user = $userModel->getUserByEmail($email);
            $this->authenticateUser($user); // Connexion automatique après enregistrement
        }
    }

    public static function logout() {
        $sessionController = new SessionController();
        $sessionController->logout();

        if (isset($_COOKIE['auth_token'])) {
            unset($_COOKIE['auth_token']);
            setcookie('auth_token', '', time() - 3600, '/');
        }

        header("Location: /login");
        exit;
    }

    /**
     * Authentifie un utilisateur en générant un JWT et en le stockant dans un cookie.
     * @param UserEntity $user L'utilisateur à authentifier.
     * @param bool $remember Si vrai, le JWT est valide pendant 30 jours, sinon 2 heures.
     */
    private function authenticateUser(UserEntity $user, $remember = false) {
        $expirationTime = $remember ? (time() + 30 * 24 * 3600) : (time() + 7200); // 30 jours ou 2 heures

        $headerJWT = [
            'alg' => 'HS256',
            'type' => 'jwt'
        ];

        $payloadJWT = [
            'userId' => $user->getId(),
            "exp" => $expirationTime,
            "revocate" => 0,
        ];

        $jwt = (new JWT())->generateJWT($headerJWT, $payloadJWT);
        setcookie('auth_token', $jwt, $expirationTime, '/', '', true, true);
    }
}
