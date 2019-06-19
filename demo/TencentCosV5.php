<?php
/**
 * Created by PhpStorm.
 * User: linlei
 * Date: 2019/6/6 10:40
 * describe: 基于腾讯云对象存储 v5 二次封装
 */

namespace App\Http\Libraries;

use Qcloud\Cos\Client;

class MyCos
{

    private $client = null;
    public function __construct($region = COS_REGION,$app_id = COS_APPID,$secret_id = COS_SECRET_ID,$secret_key = COS_SECRET_KEY)
    {
         $this->client = new Client(array(
             'region' => $region, #地域，如ap-guangzhou,ap-beijing-1
             'credentials' => array(
                 'appId' => $app_id,
                 'secretId' => $secret_id,
                 'secretKey' => $secret_key,
             ),
         ));
    }

    /**
     * describe  上传文件  putObject(上传接口，最大支持上传5G文件)
     * @param string $cos_path cos路径
     * @param $data 文件内容或文件路径
     * @param string $bucket  桶名称
     */
    public function upload($cos_path = '',$data = '',$bucket = COS_PRIVATE_BUCKET)
    {
        try {
            if(empty($cos_path) OR empty($data)){
                throw new \Exception('确少参数');
            }
            if(is_dir(dirname($data))){
                $data = fopen($data, 'rb');
            }
            $result = $this->client->putObject(array(
                'Bucket' => $bucket,
                'Key' => $cos_path,
                'Body' => $data
            ));
            if($result['ObjectURL']){
                return $this->response(0,'sussess',['result'=>$cos_path]);
            }else{
                return $this->response(-1,json_encode($result,256));
            }
        } catch (\Exception $e) {
            return $this->response(-1,$e->getMessage());
        }
    }

    /**
     * describe  下载文件到本地或者内存
     * @param string $cos_path cos路径
     * @param string $local_path 本地路径，为空时下载到内存
     * @param string $bucket  存储桶
     * @return array
     */
    public function download($cos_path = '',$local_path = '',$bucket = COS_PRIVATE_BUCKET)
    {
        try {
            if(empty($cos_path)){
                throw new \Exception('缺少参数');
            }
            $params = [
                'Bucket' => $bucket,
                'Key' => $cos_path,
            ];
            if(is_dir(dirname($local_path))){
                $params['SaveAs'] = $local_path;

            }
            $result = $this->client->getObject($params);
            return $this->response(0,'sussess',['result'=>strval($result['Body'])]);
        } catch (\Exception $e) {
            return $this->response(-1,$e->getMessage());
        }
    }

    /**
     * describe  getObjectUrl(获取文件UrL)
     * @param string $cos_path  cos路径
     * @param string $bucket    存储桶
     * @param int $timeout    有效时常
     * @return array
     */
    public function getObjectUrl($cos_path = '',$bucket = COS_PRIVATE_BUCKET,$timeout = 5)
    {
        try {
            if(empty($cos_path)){
                throw new \Exception('缺少参数');
            }
            $signedUrl = $this->client->getObjectUrl($bucket, $cos_path, '+'.$timeout.' minutes');
            return $this->response(0,'sussess',['result'=>$signedUrl]);
        } catch (\Exception $e) {
            return $this->response(-1,$e->getMessage());
        }
    }

    /**
     * describe  删除对象
     * @param string $cos_path
     * @param string $bucket
     * @return array
     */
    public function delete($cos_path = '',$bucket = COS_PRIVATE_BUCKET)
    {
        try {
            $result = $this->client->deleteObject(array(
                'Bucket' => $bucket,
                'Key' => $cos_path,
                'VersionId' => 'string'
            ));
            return $this->response(0,'sussess',['result'=>'']);
        } catch (\Exception $e) {
            return $this->response(-1,$e->getMessage());
        }
    }


    private function response($code = 0,$msg = 'sussess',$data = []){
        return ['code'=>$code,'msg'=>$msg,'data'=>$data];
    }
}