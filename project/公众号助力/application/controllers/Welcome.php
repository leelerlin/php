<?php
defined('BASEPATH') OR exit('No direct script access allowed');

const APPID = 'wx24729e274a64e468';
const AppSecret = '7c600721900a0159b91ece7fc9b03c54';

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	

	public function index2()
	{
		$this->load->view('welcome_message');
	}

	public function index(){
		echo 123;
		
	}

	//发送code
	public function sendCode(){
		$redirect_uri = urlencode('');  //????
		$state = mt_rand(100,100000);

		$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=". APPID ."&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_base&state={$state}#wechat_redirect";
		header('Location:'.$url);
	}

	//获取用户open_id   scope=snsapi_base
	public function getOpenId(){
		$code = trim($this->input->get('code'));
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=". APPID ."&secret=". AppSecret ."&code=CODE&grant_type=authorization_code";
		$ret = file_get_contents($url);
		$arr = json_decode($ret,true);
		if($arr){
			$open_id = $arr['openid'];
			$user = $this->db->where('open_id',$open_id)->get('users')->row();
			if ( ! $user) {//用户不存在 请求授权页面
				$redirect_uri = urlencode('');  //????
				$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=". APPID ."&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_userinfo&state={$state}#wechat_redirect";
				header('Location:'.$url);
			}

			$return = array(
				'user_id' => $user->user_id,
				'open_id' => $user->open_id
			);
			echo json_encode($return);die();
		}
	}

	//获取并保存用户信息   scope=snsapi_userinfo
	public function getUserInfo(){
		$code = trim($this->input->get('code'));
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=". APPID ."&secret=". AppSecret ."&code=CODE&grant_type=authorization_code";
		$ret = file_get_contents($url);
		$arr = json_decode($ret,true);
		if ($arr) {
			$open_id = $arr['openid'];
			$access_token = $arr['access_token'];
			$request_url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$open_id}&lang=zh_CN";
			$userinfo = file_get_contents($request_url);
			if ($userinfo) {
				$user_arr = json_decode($userinfo,true);
				$insert_user = array(
				    'open_id' => $user_arr['openid'],
				    'nick_name' => $user_arr['nickname'],
				    'gender' => $user_arr['sex'],
				    'country' => $user_arr['country'],
				    'province' => $user_arr['province'],
				    'city' => $user_arr['city'],
				    'avatar_url' => $user_arr['headimgurl'],
				    'union_id' => $user_arr['unionid'],
				);
				$this->db->insert('users',$insert_user);
			}
		}
	}


	//我也要抢手机充值卡
	public function GrabCost(){
		$user_id = $this->input->post('user_id');
		$phone = $this->input->post('phone');

	}

	// wechat callback
	public function acceptCallBack(){
		$state = $this->input->get('state');
		if ($state == 'openId') {  //获取用户openId
			
		}

		if ($state == 'userinfo'){//获取用户信息

		}

	}

}
