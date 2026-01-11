<?php
if (session_status() === PHP_SESSION_NONE) session_start();

function require_login(): void {
    if (empty($_SESSION['auth'])) {
        header('Location: lab05_hw_1/login.php');
        exit;
    }
}

function current_student(): array {
    return $_SESSION['student'] ?? [];
}
