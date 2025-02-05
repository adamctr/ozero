<?php

class ProductModel
{
    protected $db;

    public function __construct()
    {
        $this->db = DataBase::getConnection();
    }

    /**
     * Récupère un produit par son ID
     *
     * @param int $productId
     * @return ProductEntity|null
     */
    public function getProductById(int $productId): ?ProductEntity
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE productId = :productId");
        $stmt->bindParam(':productId', $productId, \PDO::PARAM_INT);
        $stmt->execute();

        $product = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($product) {
            return $this->mapToEntity($product);
        }
        return null;
    }

    /**
     * Récupère tous les produits
     *
     * @return ProductEntity[]
     */
    public function getAllProducts(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM products");
        $stmt->execute();

        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $productEntities = [];

        foreach ($products as $product) {
            $productEntities[] = $this->mapToEntity($product);
        }

        return $productEntities;
    }

    /**
     * Ajoute un nouveau produit
     *
     * @param string $product
     * @param string|null $description
     * @param float $price
     * @param string|null $img
     * @param int $stock
     * @return int|null
     */
    public function addProduct(string $product, ?string $description, float $price, ?string $img, int $stock): int|null
    {
        $stmt = $this->db->prepare("INSERT INTO products (product, description, price, img, stock) VALUES (:product, :description, :price, :img, :stock)");
        $stmt->bindParam(':product', $product);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':img', $img);
        $stmt->bindParam(':stock', $stock, \PDO::PARAM_INT);

        $stmt->execute();
        return (int) $this->db->lastInsertId();

    }

    /**
     * Met à jour un produit existant
     *
     * @param int $productId
     * @param string $product
     * @param string|null $description
     * @param float $price
     * @param string|null $img
     * @param int $stock
     * @return bool
     */
    public function updateProduct(int $productId, string $product, ?string $description, float $price, ?string $img, int $stock): bool
    {
        $stmt = $this->db->prepare("UPDATE products SET product = :product, description = :description, price = :price, img = :img, stock = :stock WHERE productId = :productId");
        $stmt->bindParam(':productId', $productId, \PDO::PARAM_INT);
        $stmt->bindParam(':product', $product);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':img', $img);
        $stmt->bindParam(':stock', $stock, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Supprime un produit par son ID
     *
     * @param int $productId
     * @return bool
     */
    public function deleteProduct(int $productId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE productId = :productId");
        $stmt->bindParam(':productId', $productId, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function addProductImage($productId, $imagePath) {
        $sql = "INSERT INTO productsImages (productId, image_path) VALUES (:productId, :image_path)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':productId', $productId, PDO::PARAM_INT);
        $stmt->bindValue(':image_path', $imagePath, PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * Convertit les résultats de la base de données en objet ProductEntity
     *
     * @param array $data
     * @return ProductEntity
     */
    private function mapToEntity(array $data): ProductEntity
    {
        // Assurez-vous de convertir le prix en float
        $price = (float) $data['price']; // Convertir en float
        $createdAt = new \DateTime($data['createdAt']); // Créer un objet DateTime pour createdAt

        return new ProductEntity(
            $data['productId'],
            $data['product'],
            $price,  // Passer le prix en tant que float
            $data['stock'],
            $createdAt,  // Passer un objet DateTime pour createdAt
            $data['description'] ?? null,  // Description peut être null
            $data['img'] ?? null   // Image peut être null
        );
    }
}
