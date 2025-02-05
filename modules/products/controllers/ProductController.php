<?php

class ProductController {

    protected $productModel;

    public function __construct() {
        $this->productModel = new ProductModel();
    }

    public function addProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validation = ProductValidator::validate($_POST['product'], $_POST['description'], $_POST['price'], $_POST['stock'], $_FILES['images']);

            if ($validation['status'] === 'error') {
                Utils::sendResponse('error', $validation['message']);
                return;
            }

            $product = $_POST['product'];
            $description = $_POST['description'] ?? null;
            $price = (float)$_POST['price'];
            $stock = (int)$_POST['stock'];
            $imagePaths = [];

            // Gestion de l'upload des images multiples
            if (!empty($_FILES['images']['name'][0])) {
                $imagePaths = $this->handleMultipleImageUpload($_FILES['images']);
                if (!$imagePaths) {
                    Utils::sendResponse('error', 'Erreur lors de l\'upload des images.');
                    return;
                }
            }

            // Ajout du produit et récupération de son ID
            $productId = $this->productModel->addProduct($product, $description, $price, '', $stock);

            if ($productId) {
                // Enregistre les images dans la table des images
                foreach ($imagePaths as $path) {
                    $this->productModel->addProductImage($productId, $path);
                }
                Utils::sendResponse('success', 'Produit ajouté avec succès.');
            } else {
                Utils::sendResponse('error', 'Erreur lors de l\'ajout du produit.');
            }
        }
    }

    private function handleMultipleImageUpload($files) {
        // Extensions autorisées pour les images
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $maxSize = 2 * 1024 * 1024; // Taille maximale de fichier 2MB

        // Utilisation de DOCUMENT_ROOT pour obtenir le chemin absolu du répertoire public
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/products/';
        $imagePaths = [];

        // Créer le répertoire de téléchargement si non existant
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Parcourir chaque fichier téléchargé
        for ($i = 0; $i < count($files['name']); $i++) {
            // Vérification de l'extension et de la taille
            $fileExt = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
            $fileType = $files['type'][$i];
            $fileSize = $files['size'][$i];

            // Vérifier le type de fichier
            if (!in_array($fileType, $allowedTypes)) {
                Utils::sendResponse('error', "Type de fichier non autorisé pour l'image " . ($i + 1));
                return;
            }

            // Vérifier la taille du fichier
            if ($fileSize > $maxSize) {
                Utils::sendResponse('error', "L'image " . ($i + 1) . " dépasse la taille maximale autorisée.");
                return;
            }

            // Renommer l'image pour éviter les conflits
            $newFileName = uniqid('product_') . '.' . $fileExt;
            $filePath = $uploadDir . $newFileName;

            // Déplacer le fichier téléchargé vers le dossier de destination
            if (move_uploaded_file($files['tmp_name'][$i], $filePath)) {
                // Stocker le chemin relatif pour l'URL
                $imagePaths[] = '/uploads/products/' . $newFileName;
            } else {
                Utils::sendResponse('error', 'Erreur lors du téléchargement de l\'image ' . ($i + 1));
                return;
            }
        }

        return $imagePaths;
    }
}
