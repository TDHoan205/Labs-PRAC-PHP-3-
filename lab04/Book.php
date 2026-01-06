<?php
class Book {
    private string $id;
    private string $title;
    private int $qty;

    public function __construct($id, $title, $qty) {
        $this->id = $id;
        $this->title = $title;
        $this->qty = (int)$qty;
    }

    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getQty() { return $this->qty; }
    public function status() {
        return $this->qty > 0 ? 'Available' : 'Out of stock';
    }
}
