<?php
require '../helpers.php';

$routes = [
    '/' => 'controllers/home.php',
    '/trastos' => 'controllers/trastos/index.php',
    '/trastos/create' =>  'controllers/trastos/create.php',
    '404' => 'controllers/error/404.php'
];

$uri = $_SERVER['REQUEST_URI'];

inspect($uri);
