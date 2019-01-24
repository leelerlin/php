<?php

date_default_timezone_set("Asia/Shanghai");
$start = time();  //当前时间
$end = strtotime('2018-04-29 22:30'); //见面时间
$s = $end - $start;  //总共多少秒
$day = floor($s / (60*60*24));  //天
$have_s = $s - $day * (60*60*24);
$hour = floor(($have_s /(60*60))); //时
$have_s -= $hour * (60*60);
$minute = floor($have_s/60); //分
$second = $have_s - $minute * 60;
echo "距离与女神见面的时间总共还有{$s}秒，倒计时{$day}天{$hour}个小时{$minute}分钟{$second}秒";
