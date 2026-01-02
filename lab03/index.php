<?php
require_once "functions.php";
$action =$_GET['action'] ??'';

$a=$_GET['a'] ?? 0;
$b=$_GET['b'] ?? 0;
$n=$_GET['n'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <TItle>Lab 03- Menu hàm PHP</TItle>
</head>
<body>
    <h2> Lab 03 - Mini Utility PHP</h2>
    <!--Menu gọi qua URL-->
<ul>
    <li><a href="?action=max&a=5&b=3">Max của 5 và 3</a></li>
    <li><a href="?action=min&a=5&b=3">Min của 5 và 3</a></li>
    <li><a href="?action=prime&n=5">Kiểm tra số nguyên tố của 17</a></li>
    <li><a href="?action=factorial&n=5">Giai thừa của 5!</a></li>
    <li><a href="?action=gcd&a=24&b=18">UCLN của 24 và 18</a></li>
</ul>
<hr>
<?php
switch($action){
case'max':
    echo"Max của $a và $b là: " . max2($a,$b);
    break;
case'min':
    echo"Min của $a và $b là: " . min2($a,$b);
    break;
case'prime':
  if(isPrime($n)){
    echo"$n là số nguyên tố";
  } else{
    echo "$n không phải là số nguyên tố";
  }
    break;
case'factorial':
   $result =factorial($n);
   if($result===null){
    echo "Không tính được gia thừa của số âm";

   }else{
    echo "Giai thừa của $n là: $result";
   }
    break;
case'gcd':
    echo"UCLN của $a và $b là: " . gcd($a,$b);
    break;
default:
echo"Lựa chọn không hợp lệ, vui lòng chọn lại.";

}
?>
</body>
</html>