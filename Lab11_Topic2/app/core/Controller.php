<?php
class Controller {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    protected function view($view, $data = []) {
        extract($data);
        require_once __DIR__ . "/../views/" . $view . ".php";
    }

    protected function model($model) {
        require_once __DIR__ . "/../models/" . $model . ".php";
        return new $model($this->pdo);
    }
}
