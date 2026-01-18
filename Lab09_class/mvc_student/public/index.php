<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$c = $_GET['c'] ?? 'student';
$a = $_GET['a'] ?? 'index';

$controllerName = ucfirst($c) . 'Controller';
require_once "../app/controllers/$controllerName.php";

$controller = new $controllerName();
$controller->$a();
