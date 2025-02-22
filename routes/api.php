<?php

$router->addRoute('POST', '/login', 'AuthController#login');
$router->addRoute('POST', '/register', 'AuthController#register');
$router->addRoute('POST', '/logout', 'AuthController#logout');

// -- Avec permissions et connecté

// Produits
$router->addRoute('POST', '/admin/products/add', 'ProductController#addProduct');
$router->addRoute('POST', '/admin/products/delete', 'ProductController#deleteProduct');
$router->addRoute('POST', '/admin/products/update', 'ProductController#updateProduct');
$router->addRoute('POST', '/admin/products/deleteimage', 'ProductController#deleteImage');

// Utilisateurs
$router->addRoute('POST', '/admin/users/add', 'UserController#addUser');

// Articles
$router->addRoute('POST', '/admin/articles/uploadimage', 'ArticleController#uploadImage');
$router->addRoute('POST', '/admin/articles/create', 'ArticleController#create');
$router->addRoute('POST', '/admin/articles/update/{id}', 'ArticleController#update');


$router->addRoute('POST', '/panier/checkoutsession', 'CheckoutController#execute');
$router->addRoute('GET', '/panier/checkoutsession', 'CheckoutController#getCheckoutSession');
$router->addRoute('GET', '/panier/checkoutsessionsuccess', 'CheckoutController#getCheckoutSuccess');
