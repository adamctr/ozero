<?php

$router->addRoute('POST', '/login', 'AuthController#login');
$router->addRoute('POST', '/register', 'AuthController#register');
$router->addRoute('POST', '/logout', 'AuthController#logout');

// Avec permissions et connecté
$router->addRoute('POST', '/admin/products/add', 'ProductController#addProduct');



