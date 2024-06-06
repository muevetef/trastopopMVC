<?php

namespace App\Controllers;

use Core\Database;

class TrastoController
{
    protected $db;

    function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    function index()
    {

        $trastos = $this->db->query('SELECT * FROM trastos')->fetchall();

        //Pasarlos a la vista home y cargar la vista
        loadView('trastos/index', [
            'trastos' => $trastos
        ]);
    }

    function show($params)
    {
        $trasto = $this->db->query('SELECT * FROM trastos WHERE id = :id', $params)->fetch();
        if (!$trasto) {
            ErrorController::notFound('No se encuentra el trasto');
            return;
        }
        loadView('trastos/show', [
            'trasto' => $trasto
        ]);
    }

    function create()
    {
        loadView('trastos/create');
    }
}
