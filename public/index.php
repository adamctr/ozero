<?php


require '../vendor/autoload.php';

Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../')->load();

require_once '../includes/autoload.php';
Autoloader::register();

define('APP_ENV', 'dev');

require_once '../includes/database.php';

$migrations = new Migrations();
$migrations->migrate();

require_once '../routes/index.php';











