<?php

class ResponseController
{
    /**
     * Fonction utilitaire pour envoyer une réponse JSON avec un message dynamique et des données
     * @param string $status Le statut de la réponse (success, error, etc.)
     * @param string $message Le message à afficher
     * @param mixed $data Données supplémentaires à envoyer (facultatif)
     * @param bool $isHtmlMessage Si vrai, génère un message HTML pour l'affichage (comme dans `DynamicMessageView`)
     */
    public static function sendResponse($status, $message, $isHtmlMessage = false, $data = null, )
    {
        header('Content-Type: application/json');

        $response = [
            'status' => $status,
            'message' => $message
        ];

        if ($data) {
            $response['data'] = $data;
        }

        if ($isHtmlMessage) {
            $divMessageHtml = DynamicMessageView::getDivMessage($status, $message);
            $response['divMessageHtml'] = $divMessageHtml;
        }

        echo json_encode($response);
        exit;
    }

    /**
     * Vérifie si la requête est une requête AJAX
     * @return bool
     */
    public static function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
}
