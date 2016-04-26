<?php 
date_default_timezone_set('Asia/Shanghai');
/**
* 登录和注册的后台交互
*/
class M_login extends CI_Model {
	
	public function __construct(){
		parent::__construct();
	}
	// 注册用户成功 保存账号
	public function addAdminUser($user) {
		$this ->db ->insert('user', $user);
	}
	// 判断该账号是否存在 存在返回
	public function nowRepeatUser($user_account){
		$sql = "SELECT * FROM user WHERE u_account = '$user_account' LIMIT 1";
		$query = $this ->db ->query($sql);
		if ( $query ->row_array() ) {// 存在用户返回true
			return true;
		}else{
			return false;
		}
	}
	// 根据 账号名 返回对应的用户id
	public function accountToUserId($user_account){
		$sql = "SELECT u_id FROM user WHERE u_account = '$user_account' LIMIT 1";
		$query = $this ->db ->query($sql);
		if ( $query ->row_array() ) {// 存在用户返回true
			return $query ->row_array();
		}else{
			return false;
		}
	}
	// session里面的验证
	public function sessionCheck($session){
		$account = $session["u_account"];
		$u_time = $session["u_time"];
		$sql = "SELECT * FROM user WHERE u_account = '$account' AND u_time = '$u_time' LIMIT 1";
		$res = $this ->db ->query($sql)->row_array();
		if ( $res ) { //验证是否存在和密码正确
			return $res;
		}else {
			return false;
		}
	}
	// 登录时候的验证
	public function loginUserCheck($user){
		$account = $user["u_account"];
		$sql = "SELECT * FROM user WHERE u_account = '$account' LIMIT 1";
		$res = $this ->db ->query($sql)->row_array();
		if ($res) { //有这个用户
			if ( SHA1($user["u_password"].$res["u_time"]."hhj_xinwen") == $res["u_password"] ) {
				return $res;
			}else {
				return false;
			}
		}else {
			return false;
		}
	}
	// 更改用户头像的
	public function updateUserHead($fileName, $u_account){
		$sql = "UPDATE user SET u_head='$fileName' WHERE u_account='$u_account'";
		$this ->db ->query($sql);
	}
	// 通过id查找对应的用户信息
	public function selectUserFromAccount($user_account){
		$query = $this ->db ->query("SELECT * FROM user WHERE u_account = '$user_account' LIMIT 1");
		return $query ->row_array();
	}
	// 通过账号(在这里账号为唯一)修改用户的信息
	public function updateUserMsgFromId($user, $session){
		$u_account = $session["u_account"];
		$u_name = $session["u_name"];

		$this->db->where('u_account', $u_account);
		$this ->db ->update("user", $user);
	}
}
?>