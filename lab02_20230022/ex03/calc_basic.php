<?php
$a=10;
$b= 3;

echo "<h2>Tính toán cơ bản</h2>";

echo "Tổng: " . ( $a + $b ) ."<br>";
echo "Hiệu: " .( $a - $b ) ."<br>";
echo "Tích: " .($a * $b) ."<br>";    
echo "Thương: " .($a / $b) ."<br>";  
echo "Chia dư: " .($a % $b) ."<br>";

$massage="Kết quả của ";
$massage.="$a và $b";
echo $massage ."<br><br>";

var_dump( "5"==5);
echo "<br>";
var_dump("5"===5);
/*
giải thích:
==: so sánh giá trị
===: so sánh giá trị và kiểu dữ liệu
*/
?>