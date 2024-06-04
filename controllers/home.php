<?php
$config = require basePath('config/db.php');
$db = new Database($config);

//TODO DB class query
$query = 'SELECT * FROM trastos LIMIT 3';
$stmt = $db->conn->prepare($query);
$stmt->execute();
$trastos = $stmt->fetchAll();


//Pasarlos a la vista home y cargar la vista
loadView('home', [
    'trastos' => $trastos
]);
