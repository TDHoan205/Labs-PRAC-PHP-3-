<?php
/**
 * Trình bày các hàm xử lý logic cơ bản cho Lab 03
 */

// 1. Tìm số lớn nhất và nhỏ nhất
function max2($a, $b) {
    return ($a > $b) ? $a : $b;
}

function min2($a, $b) {
    return ($a < $b) ? $a : $b;
}

// 2. Kiểm tra số nguyên tố: Trả về true nếu $n là số nguyên tố
function isPrime(int $n): bool {
    if ($n < 2) return false;
    for ($i = 2; $i <= sqrt($n); $i++) {
        if ($n % $i == 0) return false;
    }
    return true;
}

// 3. Tính giai thừa: n! = 1 * 2 * ... * n
function factorial(int $n) {
    if ($n < 0) return null;
    if ($n == 0) return 1;
    $result = 1;
    for ($i = 1; $i <= $n; $i++) {
        $result *= $i;
    }
    return $result;
}

// 4. Tìm ước chung lớn nhất (GCD) bằng thuật toán Euclid
function gcd(int $a, int $b): int {
    $a = abs($a);
    $b = abs($b);
    while ($b != 0) {
        $r = $a % $b;
        $a = $b;
        $b = $r;
    }
    return $a;
}
?>