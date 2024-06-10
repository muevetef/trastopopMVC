<?php
//registramos las rutas en el router
$router->get('/', 'HomeController@index');
$router->get('/trastos', "TrastoController@index");
$router->get('/trasto/create', "TrastoController@create");
$router->get('/trasto/edit/{id}', "TrastoController@edit");
$router->get('/trasto/{id}', "TrastoController@show");

$router->post('/trasto', "TrastoController@store");
$router->put('/trasto/{id}', "TrastoController@update");
$router->delete('/trasto/{id}', "TrastoController@delete");


//Rutas para la autenticación de los usuarios
$router->get('/auth/register', 'UserController@create');
$router->get('/auth/login', 'UserController@login');

$router->post('/auth/create', 'UserController@store');