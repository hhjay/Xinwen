<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * 登录注册相关的
 */
class Login extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this ->load ->helper('url');
        $this ->load ->model('m_login');
        $this ->load ->library('session');
    }
	public function index(){
		$this ->checkLogin();
	}

	// 判断是否登录并返回不同的页面 
	public function checkLogin(){
		$session_data = $this ->session ->userdata("admin");
		if ( empty($session_data) ) {
			$this ->load ->view('header');
			$this ->load ->view('login/v_login');
			$this ->load ->view('footer');
		}else{
			// 通过session
			$loginUser = $this ->m_login ->sessionCheck( $session_data );
			if ( $loginUser ) {

				$this ->load ->view('header');
				$this ->load ->view('manage/v_manage');// 登录成功跳到个人管理页面
				$this ->load ->view('footer');
			}else{
				$this ->load ->view('header');
				$this ->load ->view('login/v_login');
				$this ->load ->view('footer');
			}
		}
	}
	// 注销登录
	public function logout(){
		$saveSession = array();// 置空该session 而不是unset的直接销毁该变量
		$this ->session ->set_userdata("admin", $saveSession);
		$this ->checkLogin();
	}

	// 登录时候的验证图片显示
	public function imgLoginShow(){
		$imgStrTemp = $this ->loginImgStrRes(4);
		$this->session->set_userdata("loginImgStr", $imgStrTemp);
		$data = array(
			'imgStr' => $imgStrTemp
		);
		$this ->load ->view('login/v_img', $data);
	}
	
	// 注册时候的验证图片显示
	public function imgRegisterShow(){
		$imgStrTemp = $this ->loginImgStrRes(4);
		$this->session->set_userdata("registerImgStr", $imgStrTemp);
		$data = array(
			'imgStr' => $imgStrTemp
		);
		$this ->load ->view('login/v_img', $data);
	}
	
	/* 返回随机的的字符串(包含数字和小写字符)
	 * @pram $resLength...返回的字符的长度
	 */
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

	/* 用户登录的ajax函数
	 * @parm $_POST 注册按钮的ajax响应事件
	 * return (100/101->图片验证失败, 200->登录成功, 404->验证的方式错误, 300->没有该用户, 303->密码错误)
	 */
	public function adminLogin(){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$ajaxData = $_POST;
			$loginImg = $this ->fnAESdecrypte( $ajaxData["imgCheckStr"] );// 接收传过来的图片验证码
			$sessionImg = $this ->session ->userdata('loginImgStr');
			if ( empty($loginImg) ) {
				echo "100";
			}else{// 非空
				if ( strcmp($loginImg, trim($sessionImg)) == 0 ) {
					$u_account = $this ->security ->xss_clean( $ajaxData["userName"] );
					$u_password = $this ->fnAESdecrypte( $ajaxData["userPassword"] );

					$user = array(
						"u_account" =>$u_account,
						"u_password"=>$u_password
					);
					// 判断该账号是否存在
					$now_user = $this ->m_login ->nowRepeatUser( $user["u_account"] );
					if( !$now_user ){
						echo "300";// 该账号不存在
					}else{
						$loginUser = $this ->m_login ->loginUserCheck( $user );
						if ( $loginUser ) {
							// 登录成功 保存session
							$saveSession = array(
								'u_name'    =>$loginUser["u_name"],
								'u_time'    =>$loginUser["u_time"],
								'u_account' =>$loginUser["u_account"]
							);
							$this ->session ->set_userdata("admin", $saveSession);
							echo "200";
						}else{
							echo "303"; // 密码错误
						}
					}
				}else{
					echo "101";
				}
			}
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
	 * return (100/101->图片验证失败, 300->用户名存在, 200->注册成功, 404->验证的方式错误)
	 */
	public function addRegister(){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$ajaxData = $_POST;
			$registerImg = $this ->fnAESdecrypte( $ajaxData["registerImgStr"] );// 接收传过来的图片验证码
			$sessionImg = $this ->session ->userdata('registerImgStr');// 保存在session里面的验证码
			
			if ( empty($registerImg) ) {
				echo "100";
			}else{
				$flag = strcmp($registerImg, trim($sessionImg));
				if ( $flag == 0 ) {
					$u_name = $this ->security ->xss_clean( $ajaxData["userName"] );
					$u_account = $this ->security ->xss_clean( $ajaxData["userAccount"] );
					$u_password = $this ->fnAESdecrypte( $ajaxData["userPassword"] );
					$u_time = time();
					// 给密码SHA1加密
					$u_password = SHA1($u_password.$u_time."hhj_xinwen");
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
						$saveSession = array(
							'u_name'    =>$user["u_name"],
							'u_time'    =>$user["u_time"],
							'u_account' =>$user["u_account"]
						);
						$this ->session ->set_userdata("admin", $saveSession);
						echo "200";
					}
				}else{
					echo "101";
				}
			}
		}else{
			echo "404";			
		}
	}
}