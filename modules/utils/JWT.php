<?php

class JWT {

    protected $secretKey;

    public function __construct() {
        $this->secretKey = getenv('JWT_SECRET');
    }

    public function base64UrlEncode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    function generateJWT($header, $payload) {
        if (empty($this->secretKey)) {
            throw new Exception("Secret Key not set");
        }

        // 1. Encode le header en Base64Url
        $headerEncoded = self::base64UrlEncode(json_encode($header));

        // 2. Encode le payload en Base64Url
        $payloadEncoded = self::base64UrlEncode(json_encode($payload));

        // 3. Crée la signature (HMAC avec SHA256)
        $signature = hash_hmac('sha256', $headerEncoded . '.' . $payloadEncoded, $this->secretKey, true);
        $signatureEncoded = self::base64UrlEncode($signature);

        // 4. Retourne le JWT complet (header.payload.signature)
        return $headerEncoded . '.' . $payloadEncoded . '.' . $signatureEncoded;
    }

     public function verifyJWT($jwt) {
        // Séparer les trois parties du JWT
        list($headerEncoded, $payloadEncoded, $signatureEncoded) = explode('.', $jwt);

        // Recréer la signature
        $signatureToVerify = hash_hmac('sha256', $headerEncoded . '.' . $payloadEncoded, $this->secretKey, true);
        $signatureToVerifyEncoded = self::base64UrlEncode($signatureToVerify);

         // Comparer les signatures
         if ($signatureToVerifyEncoded === $signatureEncoded) {
             // Vérification de l'expiration du token
             $payload = json_decode(self::base64UrlDecode($payloadEncoded), true);
             if (isset($payload['exp']) && time() >= $payload['exp']) {
                 throw new Exception('Token has expired');
             }
             return true;  // Le token est valide
         } else {
             return false; // Le token est invalide
         }
    }

    // Fonction pour décoder le JWT et récupérer le payload
    public function decodeJWT($jwt) {
        // Séparer le JWT en ses trois parties
        list($headerEncoded, $payloadEncoded, $signatureEncoded) = explode('.', $jwt);

        // Décoder le payload en JSON
        $payload = json_decode(self::base64UrlDecode($payloadEncoded), true);

        return $payload;
    }

    // Méthode pour récupérer le user_id depuis le JWT stocké dans le cookie
    public function getUserIdFromJWT() {
        // Vérifier si le cookie contenant le JWT existe
        if (!isset($_COOKIE['auth_token'])) {
            return null;
            //throw new Exception('JWT cookie not found');
        }

        // Récupérer le JWT du cookie
        $jwt = $_COOKIE['auth_token'];

        if (!$this->verifyJWT($jwt)) {
            return null;
            //throw new Exception('Invalid JWT');
        }

        $payload = $this->decodeJWT($jwt);

        return isset($payload['userId']) ? $payload['userId'] : null;
    }

    // Fonction pour décoder un Base64Url
    public function base64UrlDecode($data) {
        // Remplacer les caractères spécifiques de Base64Url
        $data = strtr($data, '-_', '+/');
        // Ajouter les caractères de padding '=' si nécessaire
        $padding = strlen($data) % 4;
        if ($padding) {
            $data .= str_repeat('=', 4 - $padding);
        }
        // Décoder le Base64 classique
        return base64_decode($data);
    }
}
