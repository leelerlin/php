<?php

function jumpFloor($number) {
    // write code here
    if ($number <= 2) {
        return 1;
    }

    $limit2    = floor($number / 2); //最多可以跳多少次2阶梯
    $jump_time = 0;
    for ($i = 0; $i <= $limit2; ++$i) {
        if ($i == 0) {
            ++$jump_time;
        } elseif ($i == $limit2 && $number % 2 == 0) {
            ++$jump_time;
        } else {
            if ($i == 1) {
                $jump_time += $number - 1;
            } else {
                $jump_time += $number - $i;
            }
        }
    }
    return $jump_time;
}
$a = jumpFloor(6);
var_dump($a);
