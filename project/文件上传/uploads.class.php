<?php
//面对对象单、多文件上传
//by @linlei
class Upload{
	protected $uploadPath;
	protected $imgFlag;
	protected $maxSize;
	protected $allowExt;
	protected $allowMime;
	protected $filesInfo;  //多文件数组  $_FILE
	protected $fileInfo;   //单个文件数组
	protected $error;
	protected $ext;
	protected $code;  //return 0 -1
	protected $msg = '';	//上传信息
	protected $src = '';   //上传后服务器路径
	/**
	 * @param string $uploadPath  保存路径
	 * @param bool $imgFlag	 是否验证是否是图片
	 * @param number $maxSize 限制上传大小 5M
	 * @param array $allowExt  允许图片扩展
	 * @param array $allowMime	允许图片类型
	 */
	public function __construct($uploadPath='./uploads',$imgFlag=true,$maxSize=5242880,$allowExt=array('jpeg','jpg','png','gif'),$allowMime=array('image/jpeg','image/png','image/gif')){
		$this->uploadPath=$uploadPath;
		$this->imgFlag=$imgFlag;
		$this->maxSize=$maxSize;
		$this->allowExt=$allowExt;
		$this->allowMime=$allowMime;
		$this->filesInfo=$this->getFiles();;   //文件信息
	}
	/**
	 * 检测上传文件是否出错
	 * @return boolean
	 */
	protected function checkError(){
		if(!is_null($this->fileInfo)){
			if($this->fileInfo['error']>0){
				switch($this->fileInfo['error']){
					case 1:
						$this->error=$this->fileInfo['name'].'超过了PHP配置文件中upload_max_filesize选项的值';
						break;
					case 2:
						$this->error=$this->fileInfo['name'].'超过了表单中MAX_FILE_SIZE设置的值';
						break;
					case 3:
						$this->error=$this->fileInfo['name'].'文件部分被上传';
						break;
					case 4:
						$this->error=$this->fileInfo['name'].'没有选择上传文件';
						break;
					case 6:
						$this->error=$this->fileInfo['name'].'没有找到临时目录';
						break;
					case 7:
						$this->error=$this->fileInfo['name'].'文件不可写';
						break;
					case 8:
						$this->error=$this->fileInfo['name'].'由于PHP的扩展程序中断文件上传';
						break;

				}
				return false;
			}else{
				return true;
			}
		}else{
			$this->error='文件上传出错';
			return false;
		}
	}
	/**
	 * 检测上传文件的大小
	 * @return boolean
	 */
	protected function checkSize(){
		if($this->fileInfo['size']>$this->maxSize){
			$this->error='上传文件过大';
			return false;
		}
		return true;
	}
	/**
	 * 检测扩展名
	 * @return boolean
	 */
	protected function checkExt(){
		$this->ext=strtolower(pathinfo($this->fileInfo['name'],PATHINFO_EXTENSION));
		if(!in_array($this->ext,$this->allowExt)){
			$this->error=$this->fileInfo['name'].'不允许的扩展名';
			return false;
		}
		return true;
	}
	/**
	 * 检测文件的类型
	 * @return boolean
	 */
	protected function checkMime(){
		if(!in_array($this->fileInfo['type'],$this->allowMime)){
			$this->error=$this->fileInfo['name'].'不允许的文件类型';
			return false;
		}
		return true;
	}
	/**
	 * 检测是否是真实图片
	 * @return boolean
	 */
	protected function checkTrueImg(){
		if($this->imgFlag){
			if(!@getimagesize($this->fileInfo['tmp_name'])){
				$this->error=$this->fileInfo['name'].'不是真实图片';
				return false;
			}
			return true;
		}
	}
	/**
	 * 检测是否通过HTTP POST方式上传上来的
	 * @return boolean
	 */
	protected function checkHTTPPost(){
		if(!is_uploaded_file($this->fileInfo['tmp_name'])){
			$this->error=$this->fileInfo['name'].'文件不是通过HTTP POST方式上传上来的';
			return false;
		}
		return true;
	}
	/**
	 * 检测目录不存在则创建
	 */
	protected function checkUploadPath(){
		if(!file_exists($this->uploadPath)){
			mkdir($this->uploadPath,0777,true);
		}
	}
	/**
	 * 产生唯一字符串
	 * @return string
	 */
	protected function getUniName(){
		return md5(uniqid(microtime(true),true));
	}
	/**
	 * 上传文件
	 * @return array
	 */
	public function uploadFile(){
		$return = array();
		foreach ($this->filesInfo as $this->fileInfo) {
			if($this->checkError()&&$this->checkSize()&&$this->checkExt()&&$this->checkMime()&&$this->checkTrueImg()&&$this->checkHTTPPost()){
						$this->checkUploadPath();
						$this->uniName=$this->getUniName();
						$this->destination=$this->uploadPath.'/'.$this->uniName.'.'.$this->ext;
						if(@move_uploaded_file($this->fileInfo['tmp_name'], $this->destination)){
							$this->code = 1;
							$this->msg = '上传成功';
							$this->src = $this->destination;
							$return[] = $this->createReturn();
						}else{
							$this->code = -1;
							$this->msg=$this->fileInfo['name'].'文件移动失败';
							$return[] = $this->createReturn();
						}
					}else{
						$this->code = -1;
						$this->msg = $this->error;
						$return[] = $this->createReturn();
					}
		}
		return $return;
	}
	/**
	 * 生成返回信息
	 * @return [type] [description]
	 */
	public function createReturn(){
		$return = array(
			'code' => $this->code,
			'msg' => $this->msg,
			'src' => $this->src
		);
		return $return;
	}

	/**
	 * 构建上传文件信息
	 * @return array
	 */
	function getFiles(){
		$i=0;
		$files = [];
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

}

//例子
/*
$ob = new Upload('./linlei');
$res = $ob -> uploadFile();
var_dump($res);  //array(1) { [0]=> array(3) { ["code"]=> int(1) ["msg"]=> string(12) "上传成功" ["src"]=> string(45) "./linlei/59268f4e7ce4c8c68bd9685971052089.jpg" } }
 */
