<?php

//缓存成静态文件

class File {
	private $_dir;

	const EXT = '.txt';

	public function __construct() {
		$this->_dir = dirname(__FILE__) . '/files/';
	}
	public function cacheData($key, $value = '', $cacheTime = 0) {
		$filename = $this->_dir  . $key . self::EXT;

		if($value !== '') { // 将value值写入缓存
			if(is_null($value)) {
				return @unlink($filename);
			}
			$dir = dirname($filename);
			if(!is_dir($dir)) {
				mkdir($dir, 0777);
			}

			$cacheTime = sprintf('%011d', $cacheTime);
			return file_put_contents($filename,$cacheTime . json_encode($value));  //编码json数据
		}

		if(!is_file($filename)) {
			return FALSE;
		}
		$contents = file_get_contents($filename);
		$cacheTime = (int)substr($contents, 0 ,11);   //获取过期时间
		$value = substr($contents, 11);				  //获取缓存值
		if($cacheTime !=0 && ($cacheTime + filemtime($filename) < time())) {  //判断缓存是否失效
			@unlink($filename);
			return FALSE;
		}
		return json_decode($value, true);

	}
}

$file = new File();

$file->cacheData('test1','cacheData',10);  //写入缓存
echo $file->cacheData('test1');  //读取缓存
$file->cacheData('test1',null);  //删除缓存