<?php
$n = (int)($_GET["n"] ?? 10);

echo "<h3>A) Bảng cửu chương</h3>";
echo "<table border='1' style='border-collapse:collapse; text-align:center;'>";
for ($i = 1; $i <= 9; $i++) {
    echo "<tr>";
    for ($j = 1; $j <= 9; $j++) {
        echo "<td style='padding:5px;'>$j x $i = " . ($i * $j) . "</td>";
    }
    echo "</tr>";
}
echo "</table>";

echo "<h3>B) Tổng chữ số của $n</h3>";
$tempN = abs($n);
$sum = 0;
while ($tempN > 0) {
    $sum += $tempN % 10;
    $tempN = (int)($tempN / 10);
}
echo "Tổng các chữ số: $sum";

echo "<h3>C) Số lẻ từ 1 đến $n (Dừng nếu > 15)</h3>";
for ($i = 1; $i <= $n; $i++) {
    if ($i > 15) break;
    if ($i % 2 == 0) continue;
    echo "$i ";
}
?>