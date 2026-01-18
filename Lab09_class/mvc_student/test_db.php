<?php
require_once 'app/core/Database.php';

$conn = Database::getConnection();
echo "✅ Kết nối database thành công";
