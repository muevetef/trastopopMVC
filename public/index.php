<?php
require '../helpers.php';
require basePath('Database.php');
$config = require basePath('config/db.php');

$db = new Database($config);

require basePath('Router.php');
//Creamos un router
$router = new Router();
//registramos las rutas en el router
$router->get('/', 'controllers/home.php');
$router->get('/trastos', 'controllers/trastos/index.php');
$router->get('/trastos/create', 'controllers/trastos/create.php');

//mirar la uri de la peticion http
$uri = $_SERVER['REQUEST_URI'];
//mirar el método
$method = $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);
