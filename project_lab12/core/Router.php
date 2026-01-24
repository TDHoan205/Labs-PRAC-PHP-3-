<?php
class Router {
    public static function route($routes) {
        $c = isset($_GET['c']) ? $_GET['c'] : 'employee';
        $a = isset($_GET['a']) ? $_GET['a'] : 'index';
        $controllerName = ucfirst($c) . 'Controller';
        if (!isset($routes[$controllerName])) {
            http_response_code(404);
            echo "404 Not Found";
            exit;
        }
        require_once $routes[$controllerName];
        $controller = new $controllerName();
        if (!method_exists($controller, $a)) {
            http_response_code(404);
            echo "404 Action Not Found";
            exit;
        }
        $controller->$a();
    }
}
