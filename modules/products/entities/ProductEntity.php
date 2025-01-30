<?php

class ProductEntity {
    private ?int $productId;        // Clé primaire, nullable
    private string $product;        // Nom du produit
    private ?string $description;   // Description optionnelle
    private float $price;           // Prix en float
    private int $stock;             // Stock en entier
    private \DateTime $createdAt;   // Date de création
    private ?string $img;           // Image optionnelle

    // Constructeur
    public function __construct(
        int $productId,
        string $product,
        float $price,
        int $stock,
        \DateTime $createdAt,
        ?string $description = null,  // Paramètre optionnel
        ?string $img = null           // Paramètre optionnel
    ) {
        $this->productId = $productId;
        $this->product = $product;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
        $this->createdAt = $createdAt;
        $this->img = $img;
    }

    // Getters
    public function getProductId(): ?int {
        return $this->productId;
    }

    public function getProduct(): string {
        return $this->product;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function getImg(): ?string {
        return $this->img;
    }

    public function getStock(): int {
        return $this->stock;
    }

    public function getCreatedAt(): \DateTime {
        return $this->createdAt;
    }
}
