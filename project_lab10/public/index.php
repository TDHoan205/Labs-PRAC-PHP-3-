<?php
require_once __DIR__ . '/../app/config/db.php';

$c = $_GET['c'] ?? 'products';
$a = $_GET['a'] ?? 'index';

switch ($c) {
    case 'products':
        require_once __DIR__ . '/../app/controllers/ProductController.php';
        $ctrl = new ProductController($pdo);
        if($a=='index') $ctrl->index();
        elseif($a=='create') $ctrl->create();
        elseif($a=='store') $ctrl->store();
        elseif($a=='edit') $ctrl->edit();
        elseif($a=='update') $ctrl->update();
        elseif($a=='delete') $ctrl->delete();
        break;

    case 'customers':
        require_once __DIR__ . '/../app/controllers/CustomerController.php';
        $ctrl = new CustomerController($pdo);
        if($a=='index') $ctrl->index();
        elseif($a=='create') $ctrl->create();
        elseif($a=='store') $ctrl->store();
        elseif($a=='edit') $ctrl->edit();
        elseif($a=='update') $ctrl->update();
        break;

    case 'orders':
        require_once __DIR__ . '/../app/controllers/OrderController.php';
        $ctrl = new OrderController($pdo);
        if($a=='index') $ctrl->index();
        elseif($a=='create') $ctrl->create();
        elseif($a=='store') $ctrl->store();
        elseif($a=='show') $ctrl->show();
        elseif($a=='success') $ctrl->success();
        break;
        
    default:
        echo "404 Not Found";
}