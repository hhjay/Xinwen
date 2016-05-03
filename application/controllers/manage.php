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
			$this ->load ->view('manage/v_mhead', $v_data);
			$this ->load ->view('manage/v_news_show', $v_data);
			$this ->load ->view('manage/v_edit', $v_data);
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
	/* ajax请求 收藏 的保存
	 * @newsId新闻id @user-account用户账号 不可以匿名收藏
	 * requrst(404-请求方式出错, 100-空字符, 101-没有登录, 202已经保存过该新闻)
	 */
	public function ajaxKeepSave(){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$news = $_POST;
			$k_news_id = $this ->security ->xss_clean( $news["a_id"] );

			// 判断字符是否合法
			if ( empty($k_news_id) ) {
				echo 100;
			}else{
				// 判断是否登录
				$session_data = $this ->session ->userdata("admin");
				if ( empty($session_data) ) {
					echo 101;
				}else{
					$loginUser = $this ->m_login ->sessionCheck( $session_data );
					if ( !$loginUser ) {
						echo 101;
					}else{
						$data = array(
							"k_news_id"     =>$k_news_id,
							"k_user_accound"=>$loginUser["u_account"]
						);
						$isKeep = $this ->m_news ->judgeNewsIsKeep($data["k_news_id"]);
						$keepStr = $isKeep["a_keep_user"];
						$keepArr = explode(",", $keepStr);
						$flag = false;
						for ($i=0; $i < count($keepArr); $i++) { 
							if ( $keepArr[$i] == $data["k_user_accound"] ) {
								echo 202; break;
							}else{
								$flag = true;
							}
						}
						if ( $flag ) {
							echo 200; $this ->m_news ->addKeep($data);
						}
					}
				}
			}
		}else{
			echo 404;		
		}
	}
	/* 分类的 直接拉取出来所以分类
	 * 然后再把分类的内容展示(直接不分页)
	 */
	public function fenleiNews(){
		// 真的url是不是类似 fenleiNews/政治/1
    	$label = $this ->uri ->segment(3);// 类似从get参数里面获取
    	$label = urldecode($label);
    	$fenlei_label = $this ->m_news ->selectFenleiNews();// 所有的标签
	    $session_data = $this ->session ->userdata("admin");
	    $fenlei_list  = $this ->m_news ->selectFenleiList($label);
	    $v_data = array(
	    	"fenlei_news"=>$fenlei_list, // 所有的新闻
	    	"fenlei_label" =>$fenlei_label,
	    	"session" =>$session_data // 登录信息
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
	/* 用户反馈 保存反馈内容和账号
	 */
	public function feedBack(){
		$this ->load ->library("form_validation");
		$this ->form_validation ->set_rules("textFeedback","textFeedback","required");
		$f_contain = $this ->security ->xss_clean( $this->input->post("textFeedback") );
		$session_data = $this ->session ->userdata("admin");
		$data = array(
			"f_user_account" =>$session_data["u_account"],
			"f_contain" =>$f_contain,
			"f_time"    =>time()
		);
		$this ->m_news ->addFeedback( $data );
        redirect('/');
	}
	/* 搜索结果展示
	 */
	public function searchShow(){
		$this ->load ->library("form_validation");
		$this ->form_validation ->set_rules("keySearch","keySearch","required");
		$keySearch = $this ->security ->xss_clean( $this->input->post("keySearch") );//从内容搜索

		$keySearchList = $this ->m_news ->selectKeyWordNews($keySearch);
	    $session_data = $this ->session ->userdata("admin");
	    $v_data = array(
	    	"search_list"=>$keySearchList, // 所有的新闻
	    	"session" =>$session_data // 登录信息
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
}