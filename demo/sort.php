<?php

$arr = [9, 8, 7, 6, 5, 4, 3, 2, 1, 0];
function get_time() {
    return microtime(true);
}
function bubble_sort($arr = []) {
    //冒泡排序

    $count = count($arr);
    for ($i = 0; $i < $count - 1; $i++) {
        for ($j = $i + 1; $j < $count; $j++) {
            if ($arr[$i] > $arr[$j]) {
//递增
                $tmp     = $arr[$j];
                $arr[$j] = $arr[$i];
                $arr[$i] = $tmp;
            }
        }
    }
    return ($arr);
}
function quick_sort($arr = []) {
    //快速排序
    $count = count($arr);
    if ($count > 1) {
        $base      = $arr[0];
        $left_arr  = [];
        $right_arr = [];
        for ($i = 1; $i < $count; $i++) {
            if ($arr[$i] > $base) {
                $right_arr[] = $arr[$i];
            } else {
                $left_arr[] = $arr[$i];
            }
        }
        $left_arr  = quick_sort($left_arr);
        $right_arr = quick_sort($right_arr);
        return array_merge($left_arr, array($base), $right_arr);
    } else {
        return $arr;
    }
}

/*for($i = 0; $i < 200000; $i++) {
$arr[] = rand(1, 200000);
}*/

/*$time1 = get_time();
//bubble_sort($arr);
$time2 = get_time();

echo $time2-$time1;
echo '<hr/>';
$time3 = get_time();
quick_sort($arr);
$time4 = get_time();
echo $time4-$time3;*/

#选择排序
function selectSort($arr) {
//双重循环完成，外层控制轮数，内层控制比较次数
    $len = count($arr);
    for ($i = 0; $i < $len - 1; $i++) {
        //先假设最小的值的位置
        $p = $i;
        for ($j = $i + 1; $j < $len; $j++) {
            //$arr[$p] 是当前已知的最小值
            if ($arr[$p] > $arr[$j]) {
                //比较，发现更小的,记录下最小值的位置；并且在下次比较时采用已知的最小值进行比较。
                $p = $j;
            }
        }
        //已经确定了当前的最小值的位置，保存到$p中。如果发现最小值的位置与当前假设的位置$i不同，则位置互换即可。
        if ($p != $i) {
            $tmp     = $arr[$p];
            $arr[$p] = $arr[$i];
            $arr[$i] = $tmp;
        }
    }
    //返回最终结果
    return $arr;
}

#插入排序
function insertSort($arr) {
    $len = count($arr);
    for ($i = 1; $i < $len; $i++) {
        $tmp = $arr[$i];
        //内层循环控制，比较并插入
        for ($j = $i - 1; $j >= 0; $j--) {
            if ($tmp < $arr[$j]) {
                //发现插入的元素要小，交换位置，将后边的元素与前面的元素互换
                $arr[$j + 1] = $arr[$j];
                $arr[$j]     = $tmp;
            } else {
                //如果碰到不需要移动的元素，由于是已经排序好是数组，则前面的就不需要再次比较了。
                break;
            }
        }
    }
    return $arr;
}
