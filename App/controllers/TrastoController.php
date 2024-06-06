<?php

namespace App\Controllers;

use Core\Database;
use Core\Validation;

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

    function store()
    {
        //asegurar que llegan todo los campos requeridos o válidos
        $allowedFields = ['title', 'description', 'details', 'price', 'condition', 'category', 'tags', 'seller', 'address', 'city', 'state', 'phone', 'email'];

        $newTrastoData = array_intersect_key($_POST, array_flip($allowedFields));
        //sanitizar los valores de todos los campos
        $newTrastoData = array_map('sanitize', $newTrastoData);

        $newTrastoData['user_id'] = 2; //Fake logged user
        $requiredFields = ['title', 'description', 'email', 'city'];
        //recorrer los campos requerido  y guardar los errores si los hay
        $errors = [];
        foreach ($requiredFields as $field) {
            if (empty($newTrastoData[$field]) || !Validation::string($newTrastoData[$field])) {
                $errors[$field] = 'El valor no es un texto válido';
            }
        }

        //si hay errores los pasamos a la vista
        if ($errors) {
            loadView('trastos/create', ['errors' => $errors, 'trastos' => $newTrastoData]);
        } else {
            //sinó hay errores guardamos el trasto
            // $this->db->query("INSERT INTO `trastos` (`user_id`, `title`, `description`, `details`, `price`, `condition`, `category`, `tags`, `seller`, `address`, `city`, `state`, `phone`, `email`) VALUES (:user_id, :title, :description, :details, :price, :condition, :category, :tags, :seller, :address, :city, :state, :phone, :email)", $newTrastoData);

            $fields = [];
            //Tenemos que convertir los valores vacios a null
            foreach ($newTrastoData as $field => $value) {
                $fields[] = '`' . $field . '`';
            }
            $fields = implode(', ', $fields);

            $values = [];
            foreach ($newTrastoData as $field => $value) {
                //passar los strings vacios a null
                if ($value === '') {
                    $newTrastoData[$field] = null;
                }
                $values[] = ':' . $field;
            }
            $values = implode(', ', $values);


            $query = "INSERT INTO trastos ($fields) VALUES ($values)";
            $this->db->query($query, $newTrastoData);
            //si no hay error redireccionar a /trastos
            redirect('/trastos');
        }
    }
}
