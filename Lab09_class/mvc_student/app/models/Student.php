<?php
require_once __DIR__ . '/../core/Database.php';

class Student {

    public static function all() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM students");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
