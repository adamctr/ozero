<?php

class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        try {
            $config = array(
                'host' => $_ENV['DB_HOST'],
                'dbname' => $_ENV['DB_NAME'],
                'user' => $_ENV['DB_USER'],
                'port' => $_ENV['DB_PORT'] ?? null,
                'password' => $_ENV['DB_PASSWORD'],
                'charset' => $_ENV['DB_CHARSET'],
            );
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4;port={$config['port']}";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            $this->connection = new PDO($dsn, $config['user'], $config['password'], $options);
        }
        catch (PDOException $e) {
            throw new Exception("Erreur de connexion à la base de données: " . $e->getMessage());
        }
    }

    /**
     * @return PDO
     */
    public static function getConnection() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->connection;
    }
}
