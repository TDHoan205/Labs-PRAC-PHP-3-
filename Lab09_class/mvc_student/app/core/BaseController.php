<?php
class BaseController {

    protected function render($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/layout.php';
    }
}
