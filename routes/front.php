<?php

// Front Office
$router->addRoute('GET', '/',  'HomepageController#execute');
$router->addRoute('GET', '/diy',  'DIYController#execute');
$router->addRoute('GET', '/blog',  'BlogController#execute');
$router->addRoute('GET', '/login',  'AuthController#showLoginForm', '');
$router->addRoute('GET', '/register',  'AuthController#showRegisterForm', '');

// BackOffice
$router->addRoute('GET', '/admin',  'BackOfficeController#execute');
$router->addRoute('GET', '/admin/users',  'BackUserController#execute');
$router->addRoute('GET', '/admin/users/{id}', 'UserEditProfileController#execute', );
$router->addRoute('GET', '/admin/categories',  'CategoryController#execute');
$router->addRoute('GET', '/admin/products',  'ProductBackController#execute');





