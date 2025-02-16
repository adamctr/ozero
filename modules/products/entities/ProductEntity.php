<?php

class ProductEntity {
    private ?int $productId;        // Clé primaire, nullable
    private string $product;        // Nom du produit
    private ?string $description;   // Description optionnelle
    private float $price;           // Prix en float
    private int $stock;             // Stock en entier
    private \DateTime $createdAt;   // Date de création
    private array $images = [];           // Image(s)

    // Constructeur
    public function __construct(
        int $productId,
        string $product,
        float $price,
        int $stock,
        \DateTime $createdAt,
        ?string $description = null,  // Paramètre optionnel
        ?array $images = null           // Paramètre optionnel
    ) {
        $this->productId = $productId;
        $this->product = $product;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
        $this->createdAt = $createdAt;
        $this->images = $images;    }

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

    public function getImages(): array
    {
        return $this->images;
    }

    public function getFirstImage(): ?string
    {
        return !empty($this->images) ? $this->images[0] : null;
    }

    public function setImages(array $images): void
    {
        $this->images = $images;
    }

    public function getStock(): int {
        return $this->stock;
    }

    public function getCreatedAt(): \DateTime {
        return $this->createdAt;
    }
}
