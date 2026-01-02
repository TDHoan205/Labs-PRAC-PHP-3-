<?php
$a = $_GET['a'] ?? null;
$b = $_GET['b'] ?? null;
$op = $_GET['op'] ?? null;

if ($a===null || $b===null || $op===null) {
    echo"Vui lòng nhập URL theo mẫu:<br>";
    echo"?a=10&b=3&op=add";
    exit; 
}
$a =(float)$a;
$b =(float)$b;

switch ($op) {
    case 'add':
        $result = $a + $b;
        echo"$a +$b=$result";
        break;
    case 'sub':
        $result = $a - $b;
        echo"$a - $b=$result";
        break;
    case "mul":
        $result = $a + $b;
        echo"$a  $b=$result";
        break;
    case "div":
        if ($b==0){
           echo"Không thể chia cho 0";

        }else{
            $result = $a / $b;
            echo "$a / $b = $result";
        }
        break;
    default:
    echo"Phép toán không hợp lệ";   
}
?>