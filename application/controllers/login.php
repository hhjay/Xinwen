<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this ->load ->helper('url');
        $this ->load ->model('m_login');
        $this ->load ->library('session');
    }
	public function index(){
		$data = array(
			"jsData" =>array()
		);
		// // 登录验证所用的session
		// $loginSession = array(
		// 	// "userId" =>
		// 	"loginImgStr" =>
		// 	"registerImgStr" =>
		// );


		$this ->load ->view('header');
		$this ->load ->view('v_login', $data);
		$this ->load ->view('footer');
	}
	// 登录时候的验证图片显示
	public function imgLoginShow(){
		$imgStrTemp = $this ->loginImgStrRes(4);
		$this->session->set_userdata("loginImgStr", $imgStrTemp);
		$data = array(
			'imgStr' => $imgStrTemp
		);
		$this ->load ->view('v_img', $data);
	}
	// 注册时候的验证图片显示
	public function imgRegisterShow(){
		$imgStrTemp = $this ->loginImgStrRes(4);
		$this->session->set_userdata("registerImgStr", $imgStrTemp);
		$data = array(
			'imgStr' => $imgStrTemp
		);
		$this ->load ->view('v_img', $data);
	}
	// 返回随机的的字符串(包含数字和小写字符)
	// @pram $resLength...返回的字符的长度
	public function loginImgStrRes($resLength){
		$str = "abcdefghijkmnpqrstuvwxyz1234567890";//所有的字母和数字
		$len = strlen($str);
		$imgStr = "";
		for ($i=0; $i < $resLength; $i++) { 
			$num = rand( 0, $len-1 );
			$imgStr = $imgStr . $str[$num];
		};
		return $imgStr;
	}
	// ajax匹配字符串是否一致
	public function loginAjax($ajax){
		$imgStrTemp = $this ->loginImgStrRes(4);

		$ajax = preg_replace('/\s(?=)/', '', $ajax);// 清除空白

		if ( preg_match("/^[a-z0-9]\w{3,5}$/", $ajax, $matches) ) {
			if ( $ajax == $imgStrTemp ) {
				return true;
			}
		}else{
			return false;
		}
	}
	
	/* 将输入的(已加密)字符解密
	 * @parm $encrypted已加密的字符串
	 */
	public function fnAESdecrypte($encrypted){
		$privateKey = "1234567812345678";
		$iv         = "1234567812345678";
		//解密
		$encryptedData = base64_decode( $encrypted );
		$decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $privateKey, $encryptedData, MCRYPT_MODE_CBC, $iv);
		// 清除空白字符串 很重要
		$res = preg_replace('/\s(?=)/', '', $decrypted);
		return $res;
	}

	/* 添加用户
	 * @parm $_POST 注册按钮的ajax响应事件
	 * return (100/101->图片验证失败, 300->用户名存在, 200->注册成功)
	 */
	public function addRegister(){
		$ajaxData = $_POST;
		$registerImg = $this ->fnAESdecrypte( $ajaxData["registerImgStr"] );//接收传过来的图片验证码
		$sessionImg = $this ->session ->userdata('registerImgStr');//保存在session里面的验证码
		
		if ( empty($registerImg) ) {
			echo "100";
		}else{
			$flag = strcmp($registerImg, trim($sessionImg));
			if ( $flag == 0 ) {
				$u_name = $this ->security ->xss_clean( $ajaxData["userName"] );
				$u_account = $this ->security ->xss_clean( $ajaxData["userAccount"] );
				$u_password = $this ->fnAESdecrypte( $ajaxData["userPassword"] );
				$u_time = time();

				$user = array(
					"u_name"    =>$u_name,
					"u_account" =>$u_account,
					"u_password"=>$u_password,
					"u_time"    =>$u_time
				);
				// 判断用户名(账号名)是否重复
				$now_user = $this ->m_login ->nowRepeatUser( $user["u_account"] );
				if( $now_user ){
					echo "300";//该用户已存在
				}else{
					$this ->m_login ->addAdminUser($user);
					echo "200";
                	$this ->load ->view("v_RegisterSuccess.php");
				}
			}else{
				echo "101";
			}
		}

		
	}
}