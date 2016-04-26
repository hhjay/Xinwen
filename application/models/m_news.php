<?php 
date_default_timezone_set('Asia/Shanghai');
/**
* 新闻抓取和存储的
*/
class M_news extends CI_Model {
	public function __construct(){
		parent::__construct();
	}
	// 拉取所有类似的结果 标签列表
	public function inputLabelList($label){
		$sql = "SELECT a_label FROM article WHERE a_label LIKE '%$label%'";
		$resLabel = $this ->db ->query($sql);
		if ( $resLabel ->row_array() ) {
			return $resLabel ->result();
		}else{
			return false;
		}
	}
	// 保存新闻
	public function addNews($article) {
		$this ->db ->insert('article', $article);
	}
	// 拉取出所有新闻列表
	public function selectNewsList($num, $offset){
		$res = array();
		$mes_data = $this ->db ->query("SELECT * FROM article ORDER BY a_time DESC LIMIT $offset, $num");
		$mes_data = $mes_data->result();
		foreach ($mes_data as $row) {
			$u_id = $row ->a_author_id;
			$sql = "SELECT * FROM user WHERE u_id = '$u_id' LIMIT 1";
			$query = $this ->db ->query($sql);
			$u_name_q = $query ->row_array();
			
			$row->u_name = $u_name_q["u_name"];
			$row->u_head = $u_name_q["u_head"];
			$row->u_account = $u_name_q["u_account"];

			array_push($res, $row);
		}
		return $res;
	}
	// 拉取出新闻内容 该新闻对应的相关新闻 及该新闻的pv
	public function selectNewsContain($newsId){
		$res = array();
		$mes_data = $this ->db ->query("SELECT * FROM article WHERE a_id = '$newsId' LIMIT 1");
		$mes_data = $mes_data->row_array();
		return $mes_data;
	}
	// 通过newsId返回该新闻标签
	public function selectXgNewsList($newsId){
		$mes_data = $this ->db ->query("SELECT * FROM article WHERE a_id = '$newsId' LIMIT 1");
		$mes_data = $mes_data->row_array();

		$a_label = $mes_data["a_label"];
		$query = $this ->db ->query("SELECT * FROM article WHERE a_label = '$a_label' LIMIT 10");
		return $query ->result();
	}
	// 通过新闻id返回该用户的(信息)
	public function selectNewsUser($newsId){
		$mes_data = $this ->db ->query("SELECT * FROM article WHERE a_id = '$newsId' LIMIT 1");
		$mes_data = $mes_data->row_array();

		$u_id = $mes_data["a_author_id"];
		$query = $this ->db ->query("SELECT * FROM user WHERE u_id = '$u_id' LIMIT 1");
		return $query ->row_array();
	}
	// 修改新闻内容及那些东西
	public function updateNewsFromId($news, $newsId){
		$this->db->where('a_id', $newsId);
		$this ->db ->update("article", $news);
	}
	// 修改pv
	public function uptatePvFromId($id){
		$query = $this ->db ->query("SELECT * FROM article WHERE a_id = '$id' LIMIT 1");
		$pv = $query ->row_array();
		$a_pv = 0;
		$a_pv = $pv["a_pv"] + 1;

		$sql = "UPDATE article SET a_pv = '$a_pv' WHERE a_id = '$id'";
		$this ->db ->query($sql);
	}
	// 热门新闻 拉取出pv最高的前五条
	public function selectHotNews(){
		$mes_data = $this ->db ->query("SELECT * FROM article ORDER BY a_pv DESC LIMIT 5");
		return $mes_data->result();
	}
	// 保存评论
	public function addComment($data) {
		$this ->db ->insert('comment', $data);
	}
	// 拉取评论的
	public function selectCommentList($newsId){
		$query = $this ->db ->query("SELECT * FROM comment WHERE c_news_id = '$newsId'");
		$return = array();
		$res = $query ->result();
		foreach ($res as $row) {
			$u_account = $row ->c_user_account;
			if ( $u_account != "0" ) {
				$query = $this ->db ->query("SELECT * FROM user WHERE u_account = '$u_account' LIMIT 1");
				$user_msg = $query ->row_array();
				$row ->u_head = $user_msg["u_head"];
				$row ->u_name = $user_msg["u_name"];
			}
			array_push($return, $row);
		}
		return $return;
	}
	// 拉取该用户发布的新闻
	public function selectFabuNews($u_id, $u_account){
		$mes_data = $this ->db ->query("SELECT * FROM article WHERE a_author_id = $u_id ORDER BY a_time DESC");
		$return = array();
		$res = $mes_data ->result();
		foreach ($res as $row) {
			$newsId = $row ->a_id;

			$fabuCount = $this ->db ->query("SELECT COUNT(c_user_account) AS commentCount FROM comment WHERE c_news_id = '$newsId' AND c_user_account = '$u_account'");
			$fabuCount = $fabuCount ->row_array();
			$row ->fabuCount = $fabuCount;
			array_push($return, $row);
		}
		return $return;
	}
	// 被人评论的新闻 首先拉取文章 然后找到该文章被评论的
	public function selectPinglunNews($u_id){
		$a_id = $this ->db ->query("SELECT * FROM article WHERE a_author_id = '$u_id' ORDER BY a_time DESC");
		$return = array();
		$res = $a_id ->result();

		foreach ($res as $row) {
			$newsId = $row ->a_id;
			$pinglunList = $this ->db ->query("SELECT c_user_account FROM comment WHERE c_news_id = '$newsId' ORDER BY c_time DESC LIMIT 1");
			$pinglunList = $pinglunList ->row_array();

			$u_name = $pinglunList["c_user_account"];
			if ( isset($u_name) ) {
				if ( $u_name == "0" ){
					$u_name = "匿名用户";
				}else{
					$query = $this ->db ->query("SELECT * FROM user WHERE u_account = '$u_name' LIMIT 1");
					$user_msg = $query ->row_array();
					$u_name = $user_msg["u_name"];
				}
				$row ->u_name = $u_name;
				array_push($return, $row);
			}
		}
		return $return;
	}
}
?>