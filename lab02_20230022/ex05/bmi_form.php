<?php
$name = $_GET['name'] ?? '';
$height = $_GET['height'] ?? '';
$weight = $_GET['weight'] ?? '';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Tính BMI</title>
</head>
<body>
<h2>Tính BMI</h2>

<form method="get">
    Họ tên: <input type="text" name="name"><br><br>
    Chiều cao (m): <input type ="text" name="height"><br><br>
    Cân nặng (kg): <input type ="text" name="weight"><br><br>
    <button type="submit"> Tính BMI</button>

</form>
<?php 
if ($name && $height>0 && $weight >0) {
$bmi= round($weight / ($height * $height), 2);
 if ($bmi < 18.5) $type = "Gầy";
    elseif ($bmi < 25) $type = "Bình thường";
    elseif ($bmi < 30) $type = "Thừa cân";
    else $type = "Béo phì";

    echo "<h3>Kết quả</h3>";
    echo "Họ tên: $name<br>";
    echo "BMI: $bmi<br>";
    echo "Phân loại: $type";
}

?>
</body>