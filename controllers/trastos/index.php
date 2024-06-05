<?php
$config = require basePath('config/db.php');
$db = new Database($config);

$trastos = $db->query('SELECT * FROM trastos')->fetchall();

//Pasarlos a la vista home y cargar la vista
loadView('trastos/index', [
    'trastos' => $trastos
]);
