<?php
require_once '../app/core/Database.php';

$controller = $_GET['c'] ?? 'student';
$controller = ucfirst($controller) . 'Controller';
$action = $_GET['a'] ?? 'index';

$controllerFile = "../app/controllers/{$controller}.php";

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $ctrl = new $controller();
    if (method_exists($ctrl, $action)) {
        $ctrl->$action();
    } else {
        die("Action không tồn tại");
    }
} else {
    die("Controller không tồn tại");
}