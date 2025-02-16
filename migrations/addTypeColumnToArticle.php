<?php

class AddTypeColumnToArticle extends Migrations
{
    public function migrate()
    {
        $table = 'articles';

        // Vérifier si la colonne 'type' existe déjà dans la table
        $checkColumnSql = "SHOW COLUMNS FROM `$table` LIKE 'type'";
        $result = $this->db->query($checkColumnSql);

        if ($result->rowCount() == 0) {
            // La colonne n'existe pas, on peut l'ajouter
            $sql = "ALTER TABLE `$table` 
                    ADD COLUMN `type` VARCHAR(255) NOT NULL AFTER `content`";
            $this->db->exec($sql);
            error_log("Migration appliquée : Ajout de la colonne 'type' à la table '$table'.\n");
        } else {
            // La colonne existe déjà, pas d'action nécessaire
            error_log("Migration ignorée : La colonne 'type' existe déjà dans la table '$table'.\n");
        }
    }
}
