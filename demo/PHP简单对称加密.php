<?php

/**
 * @Author: leeler
 * @Date: 2019-02-21 10:06:16
 * @Last modified by: leeler
 * @Last modified time: 2019-02-21 10:06:47
 * @Eamil: 690447824@qq.com
 */

/**
* 简单对称加密
* @param string $string [需要加密的字符串]
* @param string $skey [加密的key]
* @return [type]   [加密后]
*/
function encode($string = '', $skey = 'cxphp')
{
  $strArr = str_split(base64_encode($string));

  $strCount = count($strArr);
  foreach (str_split($skey) as $key => $value)
  $key < $strCount && $strArr[$key].=$value;
  return str_replace(array('=', '+', '/'), array('O0O0O', 'o000o', 'oo00o'), join('', $strArr));
}

/**
* 简单对称解密
* @param string $string [加密后的值]
* @param string $skey [加密的key]
* @return [type]   [加密前的字符串]
*/
function decode($string = '', $skey = 'cxphp')
{
  $strArr = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', '+', '/'), $string), 2);
  $strCount = count($strArr);
  foreach (str_split($skey) as $key => $value)
   $key <= $strCount && isset($strArr[$key]) && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
  return base64_decode(join('', $strArr));
}

$str = 'linlei123123';
echo $encode = encode($str);
echo '<br/>';
echo $decode = decode($encode);
