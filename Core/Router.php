<?php

namespace Core;

use App\Controllers\ErrorController;
use Core\Middleware\Autorize;

class Router
{
    protected $routes = [];

    function registerRoute($method, $uri, $action, $middleware)
    {
        list($controller, $controllerMethod) = explode('@', $action);

        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod,
            'middleware' => $middleware
        ];
    }

    /**
     * Añade una ruta por GET
     * @param string $uri
     * @param string $controller
     * @return void
     */
    function get($uri, $controller, $middleware = [])
    {
        $this->registerRoute('GET', $uri, $controller, $middleware);
    }

    /**
     * Añade una ruta por POST
     * @param string $uri
     * @param string $controller
     * @return void
     */
    function post($uri, $controller, $middleware = [])
    {
        $this->registerRoute('POST', $uri, $controller, $middleware);
    }

    /**
     * Añade una ruta por PUT
     * @param string $uri
     * @param string $controller
     * @return void
     */
    function put($uri, $controller, $middleware = [])
    {
        $this->registerRoute('PUT', $uri, $controller, $middleware);
    }

    /**
     * Añade una ruta por DELETE
     * @param string $uri
     * @param string $controller
     * @return void
     */
    function delete($uri, $controller, $middleware = [])
    {
        $this->registerRoute('DELETE', $uri, $controller, $middleware);
    }

    function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Recibe una uri y un método y carga el contolador
     * correspondiente
     *
     * @param string $uri
     * @param string $method
     * @return void
     */
    function route($uri)
    {
        //mirar el método
        $requestedMethod = $_SERVER['REQUEST_METHOD'];

        //mirar el _method que nos llega y lo guardamos en caso qu eno sea ni GET ni POST
        if ($requestedMethod === 'POST' && isset($_POST['_method'])) {
            $requestedMethod = strtoupper($_POST['_method']);
        }
        //Separamos la URI por sus segmentos
        $uriSegments = explode('/', trim($uri, '/'));
        // inspect($uriSegments);

        foreach ($this->routes as $route) {

            //Separamos la URI de la route registrada en segmantos
            $routeSegments = explode('/', trim($route['uri'], '/'));
            // inspect($routeSegments);
            if (
                count($uriSegments) === count($routeSegments)  &&
                strtoupper($route['method']) ===  $requestedMethod
            ) {
                $params = [];
                $match = true;

                for ($i = 0; $i < count($uriSegments); $i++) {
                    //Si el segmento no encaja y no hay parametro salimos
                    if (
                        $routeSegments[$i] !== $uriSegments[$i] &&
                        !preg_match('/\{(.+?)\}/', $routeSegments[$i])
                    ) {
                        $match = false;
                        break;
                    }

                    //Miramos si se trata de un parametro y nos lo quedamos
                    if (preg_match('/\{(.+?)\}/', $routeSegments[$i], $matches)) {
                        $params[$matches[1]] = $uriSegments[$i];
                        // inspect($params);
                    }
                }

                if ($match) {
                    //Llamamos al middleware antes del controlador

                    foreach ($route['middleware'] as $middleware) {
                        (new Autorize())->handle($middleware);
                    }

                    //Montamos la ruta del controller
                    $controller = 'App\\controllers\\' . $route['controller'];
                    $controllerMethod = $route['controllerMethod'];

                    //Creamos una intancia del controlador;
                    $controllerInstance = new $controller();
                    $controllerInstance->$controllerMethod($params);
                    return;
                }
            }
        }
        ErrorController::notFound();
    }
}
