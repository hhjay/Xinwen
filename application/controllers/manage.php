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
        $this ->load ->model('m_news');
        $this ->load ->library('session');
    }
	// 默认是进到个人主页的
	public function index(){
        redirect('/');
	}
	// 提交表单 新闻存储的
	public function saveNews(){
		$this ->load ->library("form_validation");
		$this ->form_validation ->set_rules("newsTitle","newsTitle","required");
		$this ->form_validation ->set_rules("newsContainEdit","newsContainEdit","required");
		$this ->form_validation ->set_rules("newsLabel","newsLabel","required");
		$session_data = $this ->session ->userdata("admin");

		$a_author_id = $this ->m_login ->accountToUserId( $session_data["u_account"] );

		$a_name = $this ->security ->xss_clean( $this->input->post("newsTitle") );
		$a_content = $this ->security ->xss_clean( $this->input->post("newsContainEdit") );
		$a_label = $this ->security ->xss_clean( $this->input->post("newsLabel") );

		$data = array(
			"a_name"    =>$a_name,
			"a_content" =>$a_content,
			"a_label"   =>$a_label,
			"a_pv" 	    =>0,
			"a_author_id"=>$a_author_id["u_id"],
			"a_time"    =>time()
		);
		$this ->m_news ->addNews( $data );
        redirect('/');
	}
	// 新闻修改
	public function uptateNews(){
		$this ->load ->library("form_validation");
		$this ->form_validation ->set_rules("newsTitle","newsTitle","required");
		$this ->form_validation ->set_rules("newsContainEdit","newsContainEdit","required");
		$this ->form_validation ->set_rules("newsLabel","newsLabel","required");
		$session_data = $this ->session ->userdata("admin");

		$a_name = $this ->security ->xss_clean( $this->input->post("newsTitle") );
		$a_content = $this ->security ->xss_clean( $this->input->post("newsContainEdit") );
		$a_label = $this ->security ->xss_clean( $this->input->post("newsLabel") );

		$newsId = $this ->uri ->segment(3);
		$data = array(
			"a_name"    =>$a_name,
			"a_content" =>$a_content,
			"a_label"   =>$a_label,
			"a_time"    =>time()
		);
		$this ->m_news ->updateNewsFromId($data, $newsId);
        $url = base_url()."index.php/manage/showNews/".$newsId;
        redirect( $url );
	}
	// 点击来改变新闻的pv
	public function updatePv(){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$data = $_POST;
			$this ->m_news ->uptatePvFromId($data["id"]);
		}else{
			echo 404;
		}
	}

	/* 通过接收ajax的数据 处理对收藏标签的拉取
	 * 返回给一些json数据( 100->空字符串，404请求不正确，400返回无结果 )
	 */
	public function labelAjaxList(){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$label = $_POST;
			$labelStr = $this ->security ->xss_clean( $label["label"] );
			if ( empty($labelStr) ) {
				echo 100;
			}else{
				$list = $this ->m_news ->inputLabelList( $labelStr );
				if ( $list ) {
					for ($i=0; $i < count($list); $i++) {
						foreach ( $list[$i] as $row ) {
							echo $row.",";
						}
					}
				}else{
					echo 400;
				}
			}
		}else{
			echo 404;			
		}
	}
	/* 显示新闻的具体页面
	 * 理论上传入一个当前新闻的id
	 */
	public function showNews(){
    	$newsId = $this ->uri ->segment(3);// 类似从get参数里面获取
		if ( is_numeric($newsId) ) {
			$newContain = $this ->m_news ->selectNewsContain($newsId);
			$newsList =  $this ->m_news ->selectXgNewsList($newsId);
			$userMsg = $this ->m_news ->selectNewsUser($newsId);

			$isSameUser = false;
			$session_data = $this ->session ->userdata("admin");
			if ( !!$session_data ) {
				if ( $session_data["u_account"] == $userMsg["u_account"] ) {
					$isSameUser = true;
				}
			}
			// 评论的信息
			$commentNews = $this ->m_news ->selectCommentList($newsId);
			$v_data = array(
		    	"news_contain"=>$newContain,// 新闻内容
		    	"news_list"   =>$newsList, // 新闻列表
		    	"userMsg"     =>$userMsg, // 发布新的用户信息
		    	"isSameUser"  =>$isSameUser, // 登录的是否同一用户 如果是同一用户可评论
		    	"session"     =>$session_data, // 登录的用户
		    	"comment"     =>$commentNews
		    );
			// 新闻内容 相关十条新闻 被收藏的人数
			$this ->load ->view('header');
			$this ->load ->view('manage/v_mhead');
			$this ->load ->view('manage/v_news_show', $v_data);
			$this ->load ->view('footer');
    		return $newsId;
		}else{
        	redirect('/');
		}
	}
	/* 评论新闻
	 * 可以匿名评论
	 */
	public function commentNews(){
		$session_data = $this ->session ->userdata("admin");
		$comment = $this ->security ->xss_clean( $this->input->post("commentContain") );
		$newsId = $this ->security ->xss_clean( $this->input->post("newsId") );

    	if ( isset($session_data) ) {
    		$c_user_account = $session_data["u_account"];
    	}else{
    		$c_user_account = 0;// 如果c_user_id为0 那么直接是匿名用户
    	}
    	$data = array(
			"c_user_account" =>$c_user_account,
			"c_news_id" =>$newsId,
			"c_contain" =>$comment,
			"c_time"    =>time()
		);
		$this ->m_news ->addComment($data);
        redirect('/');
	}
}