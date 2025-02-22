<?php

// Front Office
$router->addRoute('GET', '/',  'HomepageController#execute');
$router->addRoute('GET', '/diy',  'ArticleController#showDiy');
$router->addRoute('GET', '/blog',  'ArticleController#showBlog');
$router->addRoute('GET', '/articles/{id}',  'ArticleController#execute');
$router->addRoute('GET', '/login',  'AuthController#showLoginForm', '');
$router->addRoute('GET', '/register',  'AuthController#showRegisterForm', '');


// BackOffice
$router->addRoute('GET', '/admin',  'BackOfficeController#execute');
$router->addRoute('GET', '/admin/users',  'BackUserController#execute');
$router->addRoute('GET', '/admin/users/{id}', 'BackUserEditProfileController#execute',);
$router->addRoute('GET', '/admin/categories',  'BackCategoryController#execute');
$router->addRoute('GET', '/admin/products',  'BackProductController#execute');
$router->addRoute('GET', '/admin/articles',  'BackArticleController#execute');
$router->addRoute('GET', '/admin/articles/create',  'BackArticleController#create');
$router->addRoute('GET', '/admin/articles/edit/{id}',  'BackArticleController#create');
