<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';
require '../helpers.php';

//Creamos un router
use Core\Router;

$router = new Router();
//traemos el archivo con las rutas
$routes = require basePath('routes.php');

//mirar la uri de la peticion http
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


$router->route($uri);
