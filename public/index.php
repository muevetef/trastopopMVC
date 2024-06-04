<?php
require '../helpers.php';
require basePath('Database.php');
$config = require basePath('config/db.php');

$db = new Database($config);


//TODO refactorizar el router a clase
$routes = [
    '/' => 'controllers/home.php',
    '/trastos' => 'controllers/trastos/index.php',
    '/trastos/create' =>  'controllers/trastos/create.php',
    '404' => 'controllers/error/404.php'
];

$uri = $_SERVER['REQUEST_URI'];
if (array_key_exists($uri, $routes)) {
    //la ruta está definida
    require basePath($routes[$uri]);
} else {
    //cargamos la página de error
    require basePath($routes['404']);
}
inspect($uri);
