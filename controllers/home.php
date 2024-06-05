<?php
$config = require basePath('config/db.php');
$db = new Database($config);

$trastos = $db->query('SELECT * FROM trastos LIMIT 3')->fetchall();

//Pasarlos a la vista home y cargar la vista
loadView('home', [
    'trastos' => $trastos
]);
