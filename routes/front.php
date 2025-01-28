<?php


$router->addRoute('GET', '/',  'HomepageController#execute');
$router->addRoute('GET', '/diy',  'DIYController#execute');

$router->addRoute('GET', '/login',  'AuthController#showLoginForm', '');
$router->addRoute('GET', '/register',  'AuthController#showRegisterForm', '');



