<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * 登录注册相关的
 */
class Login extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this ->load ->helper('url');
        $this->load->helper(array('form', 'url'));
        $this ->load ->model('m_login');
        $this ->load ->model('m_news');
        $this ->load ->library('session');
    }
	public function index(){
		$this ->checkLogin();
	}

	// 判断是否登录并返回不同的页面 
	public function checkLogin(){
		$session_data = $this ->session ->userdata("admin");
		if ( empty($session_data) ) {
			$this ->viewIndexNewsShow();
		}else{
			// 通过session
			$loginUser = $this ->m_login ->sessionCheck( $session_data );
			if ( !$loginUser ) {
				$this ->viewIndexNewsShow();
			}else{
				// 重新保存session 因为上传或者别的刷新页面会影响session的改变\
				$u_head = $loginUser["u_head"];
				if ( !$u_head ) {
					$u_head = "head.jpg";
				}
				$saveSession = array(
					'u_name'    =>$loginUser["u_name"],
					'u_time'    =>$loginUser["u_time"],
					'u_account' =>$loginUser["u_account"],
					"u_head"    =>$u_head
				);
				$this ->session ->set_userdata("admin", $saveSession);

				$this ->viewIndexNewsShow();
			}
		}
	}
	public function viewIndexNewsShow(){
		$this ->load ->library('pagination');
		$config['base_url'] = base_url().'index.php/login/viewIndexNewsShow/';
		$config['per_page'] = 5;
    	$config["total_rows"] = $this ->db ->count_all("article");

		$this->pagination->initialize( $config );
    	$num = $config["per_page"];
    	$offset = $this ->uri ->segment(3);// 类似从get参数里面获取
    	
    	$all_mes = $this ->m_news ->selectNewsList($num, ($offset && $offset >= 0 ? $offset : 0));
	    $this ->pagination ->initialize($config);
	    // 热门新闻 浏览量最多的五条新闻
	    $hotNews = $this ->m_news ->selectHotNews();
	    // 热门收藏 被收藏最多的五条标签
	    $hotKeep = $this ->m_news ->selectHotKeep();
	    // var_dump($hotKeep);
	    $session_data = $this ->session ->userdata("admin");
	    $v_data = array(
	    	"page"	  =>$this ->pagination ->create_links(),// 页码
	    	"all_news"=>$all_mes, // 所有的新闻
	    	"hotNews" =>$hotNews, // 热点新闻
	    	"session" =>$session_data, // 登录信息
	    	"hotKeep" =>$hotKeep //热门收藏
	    );
	    $this ->load ->view('header');
	    if ( !empty($session_data) ) {
			$this ->load ->view('manage/v_mhead', $v_data);
	    }else{
			$this ->load ->view('login/v_login');
	    }
		$this ->load ->view('v_index', $v_data);
		$this ->load ->view('manage/v_edit', $v_data);
		$this ->load ->view('footer');
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
								'u_account' =>$loginUser["u_account"],
								"u_head"    =>$loginUser["u_head"]
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
							'u_account' =>$user["u_account"],
							"u_head"    =>$user["u_head"]
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
	/* 上传用户头像的php
	 * ajax上传
	 */
	public function upfileAjax(){
		$str = "abcdefghijklmnopqrstuvwxyz";
		$file_name = "";
		for ($i=0; $i <= 5; $i++) { // 随机生成文件名 前五位
			$num = rand(0, 25);
			$file_name .= $str[$num];
		}
		$time = time();
		$file_name = $file_name."_".$time;//文件名
		$config['upload_path']   = './static/upload';
        $config['allowed_types'] = 'gif|jpg|png';
		$config['file_name']   = $file_name;
        $config['max_size']      = 1000;
        $config['max_width']     = 1024;
        $config['max_height']    = 768;

        $this->load->library('upload', $config);

		$session_data = $this ->session ->userdata("admin");

        if ( !$this->upload->do_upload('userFile') ) {
            $error = array('error' => $this->upload->display_errors());
            echo "error";
        } else {
            $upload_data = $this ->upload ->data();
			$this ->m_login ->updateUserHead( $upload_data['file_name'], $session_data["u_account"] );
        }
        redirect('/');
	}

	/*
	 * 用户头像点击进来的 个人页面(该用户可能没有登录)  通过用户账号而不是id
	 */
	public function personShow($userAccount){
		if ( !isset($userAccount) ) {
			$userAccount = $this ->uri ->segment(3);// 类似从get参数里面获取
		}
		if ( $userAccount ) {
			$session_data = $this ->session ->userdata("admin");
			$isSameUser = false;// 判断是否同一个人

			// 通过 账号 查找当前用户
			$userMsg = $this ->m_login ->selectUserFromAccount($userAccount);

			if ( !!$session_data ) {// 登录的
				$u_head = $session_data["u_head"];
				if ( !$u_head ) {
					$u_head = "head.jpg";
				}
				$saveSession = array(
					'u_name'    =>$session_data["u_name"],
					'u_time'    =>$session_data["u_time"],
					'u_account' =>$session_data["u_account"],
					"u_head"    =>$u_head
				);
				if ( $session_data["u_account"] == $userMsg["u_account"] ) {// 登录的和当前用户一致
					$isSameUser = true;
				}
				$user = $this ->m_login ->accountToUserId($session_data["u_account"]);
				// TODO 现在全部拉取出来 分页待定
				$fabuMsg = $this ->m_news ->selectFabuNews($user["u_id"], $session_data["u_account"]);
				// TODO 评论的
				$pinglunMsg = $this ->m_news ->selectPinglunNews($user["u_id"]);
				$pinglunArr = array();
				if ( isset($pinglunMsg) ) {
					foreach ($pinglunMsg as $row) {
						if ( isset($row ->u_name) ) {
							array_push($pinglunArr, $row);
						}
					}
				}
				$myKeep = $this ->m_news ->selectMyKeep( $session_data["u_account"] );

				$v_data = array(
					"session" =>$saveSession, // 是否登录
					"user"    =>$userMsg,
					"isSameUser" =>$isSameUser,
					"fabuMsg" =>$fabuMsg, //自己发布的信息
					"pinglunMsg" =>$pinglunArr, //评论的
					"keepMsg" =>$myKeep //自己收藏的东西
				);
			}else{
				$v_data = array(
					"user" =>$userMsg, // 用户信息
					"isSameUser" =>$isSameUser
				);
			}

			// 新闻内容 相关十条新闻 被收藏的人数
			$this ->load ->view('header');
			$this ->load ->view('manage/v_mhead', $v_data);
			$this ->load ->view('manage/v_manage', $v_data);
			$this ->load ->view('manage/v_edit', $v_data);
			$this ->load ->view('footer');
		}else{
        	redirect('/');
		}
	}
	// ajax更改用户的信息
	public function updateUserMsg(){
		$session_data = $this ->session ->userdata("admin");// 自己的session
		$userData = $_POST;
		$this ->m_login ->updateUserMsgFromId($userData, $session_data);
	}
}