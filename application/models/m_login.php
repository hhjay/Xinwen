<?php 
date_default_timezone_set('Asia/Shanghai');
/**
* 登录和注册的后台交互
*/
class M_login extends CI_Model {
	
	public function __construct(){
		parent::__construct();
	}
	public function index() {

	}
	public function addAdminUser($user) {
		// $data = array(
		// 	'u_name'    =>$user['u_name'],
		// 	'u_password'=>$user['u_password'],
		// 	'u_account' =>$user['u_account'],
		// 	'u_time'    =>$user['u_time']
		// );
		$this ->db ->insert('user', $user);
	}
	public function nowRepeatUser($user_account){
		$sql = "SELECT * FROM user WHERE u_account='$user_account' LIMIT 1";
		$query = $this ->db ->query($sql);
		return $query ->num_rows();
	}
}
?>