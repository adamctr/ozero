<?php

class ProductValidator
{
    static public function validate($product, $description, $price, $stock, $images)
    {
        // Vérifier que les champs obligatoires sont remplis
        if (empty($product) || empty($price) || empty($stock)) {
            return ['status' => 'error', 'message' => "Merci de renseigner tous les champs obligatoires"];
        }

        // Vérifier que le prix est un nombre valide et positif
        if (!is_numeric($price) || $price <= 0) {
            return ['status' => 'error', 'message' => "Le prix doit être un nombre positif"];
        }

        // Vérifier que le stock est un entier valide et positif
        if (!filter_var($stock, FILTER_VALIDATE_INT) || $stock < 0) {
            return ['status' => 'error', 'message' => "Le stock doit être un entier positif"];
        }

        // Vérifier que les images sont valides si elles sont fournies
        if (!empty($images['name'][0])) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            $maxSize = 2 * 1024 * 1024; // 2MB

            for ($i = 0; $i < count($images['name']); $i++) {
                if (!in_array($images['type'][$i], $allowedTypes)) {
                    return ['status' => 'error', 'message' => "Seuls les formats JPEG, PNG et WEBP sont acceptés"];
                }
                if ($images['size'][$i] > $maxSize) {
                    return ['status' => 'error', 'message' => "Chaque image doit faire moins de 2MB"];
                }
            }
        }

        return ['status' => 'success', 'message' => "Validation réussie"];
    }
}
