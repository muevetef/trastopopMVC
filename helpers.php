<?php

function  basePath($path = '')
{
    return __DIR__ . '/' . $path;
}

/**
 * Carga una Vista por su nombre y recibe los datos
 * @param string $name
 * @param array $data
 * @return void
 */
function loadView($name, $data = [])
{
    $viewPath = basePath("views/$name.view.php");
    if (file_exists($viewPath)) {
        extract($data);
        require $viewPath;
    } else {
        echo "No se encuentra la vista '$name' ";
    }
}

/**
 * Carga un parcial por su nombre
 *@param string $name
 *@return void
 */
function loadPartial($name)
{
    $partialPath = basePath("views/partials/$name.php");
    if (file_exists($partialPath)) {
        require $partialPath;
    } else {
        echo "No se encuentra el partial '$name' ";
    }
}

/**
 * Inspecciona una variable
 * @param mixed $value
 * @return void
 */
function inspect($value)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}


/**
 * Inspecciona una variable y para la ejecución
 * @param mixed $value
 * @return void
 */
function inspectAndDie($value)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
    die();
}
