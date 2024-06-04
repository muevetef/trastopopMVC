<?php
require '../helpers.php';

$routes = [
    '/' => 'controllers/home.php',
    '/trastos' => 'controllers/trastos/index.php',
    '/trastos/create' =>  'controllers/trastos/create.php',
    '404' => 'controllers/error/404.php'
];

$uri = $_SERVER['REQUEST_URI'];
if(array_key_exists($uri, $routes)){
    //la ruta está definida
    require basePath($routes[$uri]);
}else{
    //cargamos la página de error
    require basePath($routes['404']);
}
inspect($uri);
