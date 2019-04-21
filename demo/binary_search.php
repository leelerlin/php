<?php

#二分法查找
#有序数组

//循环
function binary_search($var  , $arr = []){
	$i = 0;
	$count = count($arr);
	$lower = 0;
	$high = $count-1;
	while($lower <= $high){
	    $middle = intval(($lower+$high)/2);
	    if($arr[$middle] > $var){
	        $high = $middle-1; $i++;
	    } elseif($arr[$middle] < $var){
	        $lower = $middle+1;$i++;
	    } else{
	    	$i++;
	    	echo $i;
	        return $middle;
	    }
	}
	echo $i;
	return -1;
}


//递归
function binary_search2($var , $arr = [] , $lower = 0 , $high = 0){

	if($lower > $high) return -1;
	$middle = intval(($lower+$high)/2);
	if($arr[$middle] > $var){
        $high = $middle-1;
        return binary_search2($var,$arr,$lower,$high);
	} elseif($arr[$middle] < $var){
        $lower = $middle+1;
        return binary_search2($var,$arr,$lower,$high);
	} else{
	    return $middle;
	}

	return -1;
}


echo binary_search(6000000,$arr);die();

echo binary_search2(6,$arr,0,count($arr));