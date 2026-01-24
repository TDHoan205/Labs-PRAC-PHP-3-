<?php
require_once __DIR__ . '/../core/Router.php';

$routes = [
    'EmployeeController' => __DIR__ . '/../app/Controllers/EmployeeController.php',
];
Router::route($routes);
