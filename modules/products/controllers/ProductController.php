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
                    $this->productModel->addProductImages($productId, $path);
                }
                Utils::sendResponse('success', 'Produit ajouté avec succès.');
            } else {
                Utils::sendResponse('error', 'Erreur lors de l\'ajout du produit.');
            }
        }
    }

    public function deleteImage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);

            $productId = $data['productId'];  // ID du produit
            $imageName = $data['image'];  // Nom de l'image à supprimer

            // Vérifier si l'image est associée au produit
            if (!$this->productModel->isImageAssociatedWithProduct($productId, $imageName)) {
                Utils::sendResponse('error', 'L\'image ne fait pas partie de ce produit.');
                return;
            }

            // Supprimer l'image de la base de données
            $imageDeleted = $this->productModel->deleteProductImage($productId, $imageName);
            if ($imageDeleted) {
                // Supprimer le fichier image physiquement
                $imagePath = $_SERVER['DOCUMENT_ROOT'] . $imageName;
                if (file_exists($imagePath)) {
                    unlink($imagePath);  // Supprime le fichier image
                    Utils::sendResponse('success', 'Image supprimée avec succès.');
                } else {
                    Utils::sendResponse('error', 'Le fichier image n\'existe pas sur le serveur.');
                }
            } else {
                Utils::sendResponse('error', 'Erreur lors de la suppression de l\'image dans la base de données.');
            }
        }
    }

    public function updateProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $productId = $_POST['productId'] ?? null;
            $product = $_POST['product'] ?? null;
            $description = $_POST['description'] ?? null;
            $price = isset($_POST['price']) ? (float)$_POST['price'] : null;
            $stock = isset($_POST['stock']) ? (int)$_POST['stock'] : null;

            // Vérifier que l'ID et le nom du produit sont bien envoyés
            if (!$productId || !$product) {
                Utils::sendResponse('error', 'ID du produit ou nom du produit manquant.');
                return;
            }

            // Validation des données
            $validation = ProductValidator::validate($product, $description, $price, $stock, $_FILES['images'] ?? []);
            if ($validation['status'] === 'error') {
                Utils::sendResponse('error', $validation['message']);
                return;
            }

            // Mise à jour du produit
            $updated = $this->productModel->updateProduct($productId, $product, $description, $price, null, $stock);

            if ($updated) {
                // Gestion des images si une nouvelle est envoyée
                if (!empty($_FILES['images']['name'][0])) {
                    $imagePaths = $this->handleMultipleImageUpload($_FILES['images']);
                    if ($imagePaths) {
                        foreach ($imagePaths as $path) {
                            $this->productModel->addProductImages($productId, $path);
                        }
                    } else {
                        Utils::sendResponse('error', 'Erreur lors de l\'upload des images.');
                        return;
                    }
                }

                Utils::sendResponse('success', 'Produit mis à jour avec succès.');
            } else {
                Utils::sendResponse('error', 'Erreur lors de la mise à jour du produit.');
            }
        }
    }

    public function deleteProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);

            $productId = $data['productId'];

            // Récupérer les images du produit avant la suppression
            $productImages = $this->productModel->getProductImages($productId);

            // Supprimer les images du produit dans la base de données
            $imagesDeleted = true;
            foreach ($productImages as $imagePath) {
                $deleted = $this->productModel->deleteProductImage($productId, $imagePath);
                if (!$deleted) {
                    $imagesDeleted = false;
                    break;
                }
            }

            // Supprimer les fichiers images physiques
            if ($imagesDeleted) {
                foreach ($productImages as $imagePath) {
                    $imagePathFull = $_SERVER['DOCUMENT_ROOT'] . $imagePath;
                    if (file_exists($imagePathFull)) {
                        unlink($imagePathFull);  // Supprimer le fichier image
                    }
                }
            }

            // Supprimer le produit de la base de données
            $deleted = $this->productModel->deleteProduct($productId);

            if ($deleted) {
                Utils::sendResponse('success', 'Produit supprimé avec succès.');
            } else {
                Utils::sendResponse('error', 'Erreur lors de la suppression du produit.');
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
