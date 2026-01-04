<?php
$a = (float)($_GET["a"] ?? 0);
$b = (float)($_GET["b"] ?? 0);
$op = $_GET["op"] ?? "add";
$result = null;
$error = "";

switch ($op) {
    case 'add': $result = $a + $b; $label = "+"; break;
    case 'sub': $result = $a - $b; $label = "-"; break;
    case 'mul': $result = $a * $b; $label = "*"; break;
    case 'div':
        if ($b == 0) {
            $error = "Không chia được cho 0";
        } else {
            $result = $a / $b;
            $label = "/";
        }
        break;
    default: $error = "Toán tử không hợp lệ";
}

if ($error) {
    echo "Lỗi: $error";
} else {
    echo "<h3>$a $label $b = $result</h3>";
}
?>