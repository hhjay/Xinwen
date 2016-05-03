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
		$sql = "SELECT distinct a_label FROM article WHERE a_label LIKE '%$label%'";
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
			
			$newsId = $row ->a_id;
			// 找到评论人数
			$pinglun = $this ->db ->query("SELECT c_user_account FROM comment WHERE c_news_id = '$newsId'");

			$row ->u_name = $u_name_q["u_name"];
			$row ->u_head = $u_name_q["u_head"];
			$row ->pinglun = $pinglun ->result();
			$row->u_account = $u_name_q["u_account"];

			array_push($res, $row);
		}
		return $res;
	}
	// 拉取出所有的label
	public function selectFenleiNews(){
		$sql = ("SELECT distinct a_label FROM article"); // 拉取出所以话题HAVING count(*) >= 1)
		$label = $this ->db ->query($sql);
		return $label->result();
	}
	// 拉取所有的label下面的新闻
	public function selectFenleiList($label){
		if ( empty($label) ) {
			$sql = "SELECT * FROM article ORDER BY a_time";
		}else{
			$sql = "SELECT * FROM article WHERE a_label = '$label' ORDER BY a_time";
		}
		$res = array();
		$fenlei = $this ->db ->query( $sql );
		$fenlei = $fenlei ->result();
		foreach ($fenlei as $row) {
			$u_id = $row ->a_author_id;

			$sql = "SELECT * FROM user WHERE u_id = '$u_id' LIMIT 1";
			$query = $this ->db ->query($sql);
			$u_name_q = $query ->row_array();
			
			$newsId = $row ->a_id;
			// 找到评论人数
			$pinglun = $this ->db ->query("SELECT c_user_account FROM comment WHERE c_news_id = '$newsId'");

			$row ->u_name = $u_name_q["u_name"];
			$row ->u_head = $u_name_q["u_head"];
			$row ->pinglun = $pinglun ->result();
			$row->u_account = $u_name_q["u_account"];
			array_push($res, $row);
		}
		return $res;
	}
	// 关键字搜索
	public function selectKeyWordNews($key){
		$sql = "SELECT * FROM article WHERE a_content LIKE '%$key%' ORDER BY a_time";
		$res = array();
		$fenlei = $this ->db ->query( $sql );
		$fenlei = $fenlei ->result();
		foreach ($fenlei as $row) {
			$u_id = $row ->a_author_id;

			$sql = "SELECT * FROM user WHERE u_id = '$u_id' LIMIT 1";
			$query = $this ->db ->query($sql);
			$u_name_q = $query ->row_array();
			
			$newsId = $row ->a_id;
			// 找到评论人数
			$pinglun = $this ->db ->query("SELECT c_user_account FROM comment WHERE c_news_id = '$newsId'");

			$row ->u_name = $u_name_q["u_name"];
			$row ->u_head = $u_name_q["u_head"];
			$row ->pinglun = $pinglun ->result();
			$row->u_account = $u_name_q["u_account"];
			array_push($res, $row);
		}
		return $res;
	}
	// 拉取出新闻内容 该新闻对应的相关新闻 及该新闻的pv
	public function selectNewsContain($newsId){
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
	// 保存收藏的新闻
	public function addKeep($keep) {
		$a_id = $keep["k_news_id"];
		$u_account = $keep["k_user_accound"];

		$query = $this ->db ->query("SELECT * FROM article WHERE a_id = '$a_id' LIMIT 1");
		$sqlKeep = $query ->row_array();
		$keepStr = $sqlKeep["a_keep_user"];
		if ( !empty($keepStr) ) {
			$keepStr = $keepStr . "," . $u_account;
		}else{
			$keepStr = $u_account;
		}
		$a_keep_count = $sqlKeep["a_keep_count"] + 1;
		$sql = "UPDATE article SET a_keep_user = '$keepStr',a_keep_count = '$a_keep_count' WHERE a_id = '$a_id'";
		$this ->db ->query($sql);
	}
	// 判断该用户是否已经收藏过该新闻
	public function judgeNewsIsKeep($a_id){
		$query = $this ->db ->query("SELECT * FROM article WHERE a_id = '$a_id' LIMIT 1");
		return $query ->row_array();
	}
	// 做多的五条收藏的新闻
	public function selectHotKeep(){
		$mes_data = $this ->db ->query("SELECT * FROM article ORDER BY a_keep_count DESC LIMIT 9");
		return $mes_data->result();
	}
	// 自己收藏的新闻
	public function selectMyKeep($u_account){
		$mes_data = $this ->db ->query("SELECT * FROM 
			article WHERE 
			a_keep_count > 0 ORDER BY a_time DESC");
		$keep = $mes_data->result();
		$return = array();
		foreach ($keep as $row) {
			$strLen = strpos($row->a_keep_user, $u_account);
			if ( is_numeric($strLen) ) {
				array_push($return, $row);
			}
		}
		return $return;
	}
	// 反馈内容保存
	public function addFeedback($data){
		$this ->db ->insert('feedback', $data);
	}
}
?>