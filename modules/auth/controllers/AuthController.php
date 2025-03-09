<?php

class AuthController
{

    public function showLoginForm()
    {
        $view = new AuthView();
        (new FrontPageView($view->showLoginForm(), "Page de connexion", "Cette page sert pour l'utilisateur afin de se connecter", ['loginRegister']))->show();
    }

    public function showRegisterForm()
    {
        $view = new AuthView();
        (new FrontPageView($view->showRegisterForm(), "Page d'inscription", "Cette page sert pour l'utilisateur afin de s'inscrire au site", ['loginRegister']))->show();
    }

    public function login()
    {
        if (!Utils::isAjax()) {
            Utils::sendResponse('error', 'Erreur lors de la requête AJAX');
            return;
        }

        $email = trim($_POST['email']) ?? '';
        $password = trim($_POST['password']) ?? '';
        $remember = isset($_POST['remember']) ?? '';

        $validation = AuthValidator::login($email, $password);

        if ($validation['status'] === 'error') {
            Utils::sendResponse('error', $validation['message'], true);
            return;
        }

        $userModel = new UserModel();
        $user = $userModel->getUserByEmail($email);

        if ($user) {
            $this->authenticateUser($user, $remember);
        } else {
            Utils::sendResponse('error', 'Utilisateur non trouvé', true);
        }
    }
    public function register()
    {
        if (!Utils::isAjax()) {
            Utils::sendResponse('error', 'Erreur lors de la requête AJAX');
            return;
        }

        $name = $_POST['name'] ?? '';
        $mail = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $firstName = isset($_POST['firstName']) ? trim($_POST['firstName']) : '';
        $lastName = isset($_POST['lastName']) ? trim($_POST['lastName']) : '';

        if (empty($firstName) || empty($lastName)) {
            Utils::sendResponse('error', 'Les champs Prénom et Nom sont requis.');
            return;
        }

        // Hash du mot de passe avant de l'enregistrer
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $userEntity = new UserEntity(null, $firstName, $lastName, $name, $mail, $hashedPassword);

        $userModel = new UserModel();
        $userModel->addUser($userEntity);

        $user = $userModel->getUserByEmail($mail);
        $this->authenticateUser($user);
    }

    public static function logout()
    {
        $sessionController = new SessionController();
        $sessionController->logout();

        if (isset($_COOKIE['auth_token'])) {
            unset($_COOKIE['auth_token']);
            setcookie('auth_token', '', time() - 3600, '/');
        }

        // Redirection après le logout
        header("Location: /login");
        exit();
    }

    /**
     * Authentifie un utilisateur en générant un JWT et en le stockant dans un cookie.
     * @param UserEntity $user L'utilisateur à authentifier.
     * @param bool $remember Si vrai, le JWT est valide pendant 30 jours, sinon 2 heures.
     */
    private function authenticateUser(UserEntity $user, $remember = false)
    {
        // Vérifier si l'utilisateur est valide avant de procéder
        if (!$user->getUserId()) {
            ResponseController::sendResponse('error', "Utilisateur invalide", false, '');
            return;
        }

        $expirationTime = $remember ? (time() + 30 * 24 * 3600) : (time() + 7200); // 30 jours ou 2 heures

        $headerJWT = [
            'alg' => 'HS256',
            'type' => 'jwt'
        ];

        $payloadJWT = [
            'userId' => $user->getUserId(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            "exp" => $expirationTime,
            "revocate" => 0,
        ];

        $jwt = (new JWT())->generateJWT($headerJWT, $payloadJWT);
        setcookie('auth_token', $jwt, $expirationTime, '/', '', true, true);

        ResponseController::sendResponse('success', "Utilisateur bien connecté", true, '');
    }
}
