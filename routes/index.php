<?php

$router = new Router();

require_once __DIR__ . '/front.php';
require_once __DIR__ . '/api.php';

$router->match();
