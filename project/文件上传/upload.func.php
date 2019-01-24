<?php

/**
 * 构建上传文件信息
 * @return array
 */
function getFiles(){
	$i=0;
	foreach($_FILES as $file){
		if(is_string($file['name'])){
			$files[$i]=$file;
			$i++;
		}elseif(is_array($file['name'])){
			foreach($file['name'] as $key=>$val){
				$files[$i]['name']=$file['name'][$key];
				$files[$i]['type']=$file['type'][$key];
				$files[$i]['tmp_name']=$file['tmp_name'][$key];
				$files[$i]['error']=$file['error'][$key];
				$files[$i]['size']=$file['size'][$key];
				$i++;
			}
		}
	}
	return $files;

}
/**
 * 针对于单文件上传
 * @param array $fileInfo 单文件信息
 * @param string $path
 * @param string $flag  检测图片真实性
 * @param number $maxSize
 * @param array $allowExt
 * @return string
 */
function uploadFile($fileInfo,$path='./uploads',$flag=true,$maxSize=1048576,$allowExt=array('jpeg','jpg','png','gif')){
	//$flag=true;
	//$allowExt=array('jpeg','jpg','gif','png');
	//$maxSize=1048576;//1M
	//判断错误号
	if($fileInfo['error']===UPLOAD_ERR_OK){
		//检测上传得到小
		if($fileInfo['size']>$maxSize){
			$res['mes']=$fileInfo['name'].'上传文件过大';
		}
		$ext=getExt($fileInfo['name']);
		//检测上传文件的文件类型
		if(!in_array($ext,$allowExt)){
			$res['mes']=$fileInfo['name'].'非法文件类型';
		}
		//检测是否是真实的图片类型
		if($flag){
			if(!getimagesize($fileInfo['tmp_name'])){
				$res['mes']=$fileInfo['name'].'不是真实图片类型';
			}
		}
		//检测文件是否是通过HTTP POST上传上来的
		if(!is_uploaded_file($fileInfo['tmp_name'])){
			$res['mes']=$fileInfo['name'].'文件不是通过HTTP POST方式上传上来的';
		}
		if($res) return $res;
		//$path='./uploads';
		if(!file_exists($path)){
			mkdir($path,0777,true);
			chmod($path,0777);
		}
		$uniName=getUniName();
		$destination=$path.'/'.$uniName.'.'.$ext;
		if(! @move_uploaded_file($fileInfo['tmp_name'],$destination)){
			$res['mes']=$fileInfo['name'].'文件移动失败';
		}
		$res['mes']=$fileInfo['name'].'上传成功';
		$res['dest']=$destination;
		return $res;

	}else{
		//匹配错误信息
		switch ($fileInfo ['error']) {
			case 1 :
				$res['mes'] = '上传文件超过了PHP配置文件中upload_max_filesize选项的值';
				break;
			case 2 :
				$res['mes'] = '超过了表单MAX_FILE_SIZE限制的大小';
				break;
			case 3 :
				$res['mes'] = '文件部分被上传';
				break;
			case 4 :
				$res['mes'] = '没有选择上传文件';
				break;
			case 6 :
				$res['mes'] = '没有找到临时目录';
				break;
			case 7 :
			case 8 :
				$res['mes'] = '系统错误';
				break;
		}
		return $res;
	}
}

/**
 * 得到文件扩展名
 * @param string $filename
 * @return string
 */
function getExt($filename){
	return strtolower(pathinfo($filename,PATHINFO_EXTENSION));
}

/**
 * 产生唯一字符串
 * @return string
 */
function getUniName(){
	return md5(uniqid(microtime(true),true));
}


//例子
/*header("content-type:text/html;charset=utf-8");
$files=getFiles();
foreach($files as $fileInfo){
	$res=uploadFile($fileInfo ,'./linlei');
	echo $res['mes'],'<br/>';
	$uploadFiles[]=$res['dest'];
}
$uploadFiles=array_values(array_filter($uploadFiles));
print_r($uploadFiles);*/

