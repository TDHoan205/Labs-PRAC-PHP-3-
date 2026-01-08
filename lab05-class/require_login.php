<?php
/**
 * File: require_login.php
 * Mục tiêu: Chặn truy cập nếu chưa login
 */

session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
