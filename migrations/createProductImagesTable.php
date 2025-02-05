<?php

class CreateProductImagesTable extends Migrations
{
    public function migrate()
    {
        $table = 'productsImages';
        $sql = "CREATE TABLE IF NOT EXISTS `$table` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `productId` INT NOT NULL,
            `image_path` VARCHAR(255) NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (`productId`) REFERENCES products(`productId`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        $this->db->exec($sql);
        error_log("Migration appliquée : Création de la table '$table'.\n");
    }
}
