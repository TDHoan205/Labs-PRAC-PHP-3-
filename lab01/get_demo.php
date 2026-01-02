<?php
if (isset($_GET['name']) && isset($_GET['age'])) {
    $name = htmlspecialchars($_GET['name']);
    $age = htmlspecialchars($_GET['age']);
    echo "Xin chào $name, tuổi: $age";
} else {
    echo "Vui lòng nhập theo mẫu:<br>";
    echo "get_demo.php?name=An&age=20";
}
?>
