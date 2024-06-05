<?php
use Core\Database;

$config = require basePath('config/db.php');
$db = new Database($config);

$id = $_GET['id'] ?? '';
$params = [
    'id' => $id
];

$trasto = $db->query('SELECT * FROM trastos WHERE id = :id', $params)->fetch();


loadView('trastos/show', [
    'trasto' => $trasto
]);

