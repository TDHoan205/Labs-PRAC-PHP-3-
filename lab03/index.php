<?php
require_once "functions.php";

$action = $_GET["action"] ?? "home";
$a = isset($_GET["a"]) ? (int)$_GET["a"] : 0;
$b = isset($_GET["b"]) ? (int)$_GET["b"] : 0;
$n = isset($_GET["n"]) ? (int)$_GET["n"] : 0;

echo "<h2>LAB03 - Mini Utility</h2>";
echo "<p>
<a href='?action=max&a=10&b=22'>Max</a> |
<a href='?action=min&a=10&b=22'>Min</a> |
<a href='?action=prime&n=17'>Prime</a> |
<a href='?action=fact&n=6'>Factorial</a> |
<a href='?action=gcd&a=12&b=18'>GCD</a>
</p>";

echo "<div style='border: 1px solid #ccc; padding: 15px; background: #f9f9f9;'>";
switch ($action) {
    case "max":
        echo "Max của $a và $b là: " . max2($a, $b);
        break;
    case "min":
        echo "Min của $a và $b là: " . min2($a, $b);
        break;
    case "prime":
        echo "Số $n " . (isPrime($n) ? "là số nguyên tố" : "không phải số nguyên tố");
        break;
    case "fact":
        $res = factorial($n);
        echo "Giai thừa của $n là: " . ($res ?? "Không hợp lệ");
        break;
    case "gcd":
        echo "ƯCLN của $a và $b là: " . gcd($a, $b);
        break;
    default:
        echo "Vui lòng chọn một chức năng từ menu trên.";
        break;
}
echo "</div>";
?>