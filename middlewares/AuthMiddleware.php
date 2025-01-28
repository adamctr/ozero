<?php

class AuthMiddleware
{
    public function handle()
    {
        // Vérification du token dans l'en-tête Authorization (pour les requêtes AJAX/API)
        $headers = getallheaders();
        $jwt = new JWT();

        // Sinon, vérification du token dans les cookies (pour les requêtes classiques)
        if (isset($_COOKIE['auth_token'])) {
            $token = $_COOKIE['auth_token'];
        } else {
            $this->unauthorizedResponse();
            exit;
        }

        // Vérification du token
        try {
            $decoded = $jwt->verifyJWT($token);
        } catch (Exception $e) {
            $this->invalidTokenResponse($e->getMessage());
            exit;
        }

        return true;
    }

    private function extractTokenFromHeader($authorizationHeader)
    {
        if (!preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches)) {
            $this->malformedHeaderResponse();
            exit;
        }
        return $matches[1];
    }

    private function unauthorizedResponse()
    {
        http_response_code(401); // Unauthorized
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized: No token provided']);
    }

    private function malformedHeaderResponse()
    {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'Malformed Authorization header']);
    }

    private function invalidTokenResponse($errorMessage)
    {
        http_response_code(401); // Unauthorized
        echo json_encode(['status' => 'error', 'message' => 'Invalid token: ' . $errorMessage]);
    }

    public function seeHeaders() {
        $headers = getallheaders();
        echo '<pre>';
        print_r($headers);
        echo '</pre>';

    }
}
