<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * 文章管理相关页面
 */
class Manage extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this ->load ->helper('url');
        $this ->load ->model('m_login');
        $this ->load ->model('m_login');
        $this ->load ->library('session');
    }

	/* 判断是否登录并返回不同的页面 
	 * 成功跳到个人的信息页面 失败返回重新登录
	 */
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
	// 默认是进到个人主页的
	public function index(){
		$this ->checkLogin();
	}
	// 提交表单 新闻存储的
	public function saveNews(){
		echo "sss";
	}
	/* 通过接收ajax的数据 处理对收藏标签的拉取
	 * 返回给一些json数据
	 */
	public function labelAjaxList(){
		
		echo "some json";
	}
}