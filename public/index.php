<?php
require '../helpers.php';
require basePath('Database.php');


require basePath('Router.php');
//Creamos un router
$router = new Router();
//traemos el archivo con las rutas
$routes = require basePath('routes');

//mirar la uri de la peticion http
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//mirar el método
$method = $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);
