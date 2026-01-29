<?php
require_once __DIR__ . '/../app/Controllers/ProductController.php';

$controller = new ProductController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        $controller->index();
        break;
    case 'form':
        $controller->form();
        break;
    case 'save':
        $controller->save();
        break;
    case 'delete':
        $controller->delete();
        break;
    default:
        $controller->index();
        break;
}