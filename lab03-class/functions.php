<?php
function max2($a, $b){
return ($a>$b )?$a:$b;
}
function min2($a, $b){

    return ($a<$b )?$a:$b;  
}
function isPrime($n){
    if($n<2) return false;
    if($n== 2) return true;
    if($n% 2== 0) return false;

    for ($i = 3; $i * $i <= $n; $i += 2){
        if($n%$i == 0) return false;
    }
    return true;
}

function factorial($n){
    if ($n < 0) return null;

    $res = 1;
    for ($i = 2; $i <= $n; $i++) { // <= n
        $res *= $i;
    }
    return $res;
}

function gcd ($a, $b){
    $a=abs((int)$a);
    $b=abs((int)$b);

    while ($b != 0){
        $r=$a%$b;
        $a=$b;
        $b=$r;
    }
    return $a;
}
?>