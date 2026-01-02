<?php
$fullname ="Trần Đức Hoàn";
$age = 20;
$gpa = 3.4;
$isactive = true;

const SCHOOL = "EAUT";

echo"<h2> Thông tin sinh viên</h2>";

echo "Họ tên: $fullname<br>";
echo "Tuổi: $age<br>";
echo "GPA: $gpa<br>";
echo "Đang học: $isactive<br>";
echo "Trường" . SCHOOL ."<br><br>";

var_dump($fullname); echo"<br>";
var_dump($age); echo "<br>";
var_dump($gpa); echo "<br>";
var_dump($isactive); echo "<br>";

echo "<br>";
echo "Nháy kép: Tuoi: $age<br>";
echo'Nháy đơn: Tuoi: $age<br>';
?>