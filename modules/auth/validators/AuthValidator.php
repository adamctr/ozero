<?php


class AuthValidator
{

    static public function login($email, $password)
    {
        if (empty($email) || empty($password)) {
            return ['status' => 'error', 'message' => "Merci de renseigner vos informations"];
        }

        $userModel = new UserModel();
        $user = $userModel->getUserByEmail($email);

        if ($user && $user->getMail()) {
            if (password_verify($password, $user->getPassword())) {
                return ['status' => 'success', 'message' => "Vous vous êtes bien connecté !"];
            } else {
                return ['status' => 'error', 'message' => "Email ou mot de passe incorrect"];
            }
        } else {
            return ['status' => 'error', 'message' => "Email ou mot de passe incorrect"];
        }
    }

    static public function register($email, $password)
    {
        // Vérifier que l'email et le mot de passe ne sont pas vides
        if (empty($email) || empty($password)) {
            return ['status' => 'error', 'message' => "Merci de renseigner vos informations"];
        }

        // Validation de l'adresse email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['status' => 'error', 'message' => "L'adresse email n'est pas valide"];
        }

        // Validation du mot de passe
        if (strlen($password) < 8) {
            return ['status' => 'error', 'message' => "Le mot de passe doit contenir au moins 8 caractères"];
        }
        if (!preg_match('/[A-Z]/', $password)) {
            return ['status' => 'error', 'message' => "Le mot de passe doit contenir au moins une lettre majuscule"];
        }

        // Vérifier si l'utilisateur existe déjà
        $userModel = new UserModel();
        $user = $userModel->getUserByEmail($email);

        if ($user && $user->getMail()) {
            return ['status' => 'error', 'message' => "L'email est déjà utilisé"];
        } else {
            return ['status' => 'success', 'message' => "Inscription réussie"];
        }
    }
}
