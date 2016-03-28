<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this ->load ->helper('url');
        $this ->load ->model('m_login');
        $this ->load ->library('session');
        $this->load->library('encryption');
    }

	public function index(){
		$data = array(
			"pubKey" =>$this ->publicKey(),
			"jsData" =>array()
		);
		$this ->load ->view('header');
		$this ->load ->view('v_login', $data);
		$this ->load ->view('footer');
	}
	// 生成随机数字和字母的图片
	public function imgShow(){
		$imgStrTemp = $this ->loginImgStrRes();
		$data = array(
			'imgStr' => $imgStrTemp
		);
		$this ->load ->view('v_img', $data);
	}
	// 登录返回的字符串
	public function loginImgStrRes(){
		$str = "abcdefghijkmnpqrstuvwxyz1234567890";//所有的字母和数字
		$len = strlen($str);
		$imgStr = "";
		for ($i=0; $i < 4; $i++) { 
			$num = rand( 0, $len-1 );
			$imgStr = $imgStr . $str[$num];
		};
		return $imgStr;
	}
	// ajax匹配字符串是否一致
	public function loginAjax($ajax){
		$imgStrTemp = $this ->loginImgStrRes();

		$ajax = preg_replace('/\s(?=)/', '', $ajax);// 清除空白

		if ( preg_match("/^[a-z0-9]\w{3,5}$/", $ajax, $matches) ) {
			if ( $ajax == $imgStrTemp ) {
				return true;
			}
		}else{
			return false;
		}
	}
	// 从.cnf中获取相应的key
	public function resKey(){
		ini_set('display_errors', 1);
    	header("Content-type: text/html; charset=utf-8");
	    $config = array(
	        "config" => "D:\wamp\bin\apache\apache2.4.9\conf\openssl.cnf",
	        "private_key_bits" => 2048,
	        "private_key_type" => OPENSSL_KEYTYPE_RSA,
	    );
	    $res = openssl_pkey_new($config);// 创建公钥和私钥
	    if ($res === false) die('创建公钥和私钥失败。'."\n");

	    $returnData = array(
	    	"res"    =>$res,
	    	"config" =>$config
	    );
	    return $returnData;
	}
	// 生成公钥
	public function publicKey(){
		$resTemp = $this ->resKey();
	    $public_key = openssl_pkey_get_details($resTemp["res"]);
    	$public_key = $public_key["key"];
		return $public_key;
	}
	// 生成私钥
	public function hhjApachePrivateKey(){
		$resTemp = $this ->resKey();
	    if (!openssl_pkey_export($resTemp["res"], $private_key, "phrase", $resTemp["config"])) die('私钥检索失败.'."\n");
	    
	    openssl_pkey_export($resTemp["res"], $private_key, "phrase", $resTemp["config"]);

		return $private_key;
	}

	public function fnAESdecrypte(){
		$ajaxData = $_POST;
		// echo( $ajaxData["username"] );	

		$privateKey = "1234567812345678";
		$iv     = "1234567812345678";
		// $data   = "Test String";
		 
		//加密
		// $encrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $privateKey, $data, MCRYPT_MODE_CBC, $iv);
		// echo(base64_encode($encrypted));
		// echo '<br/>';
		 
		//解密
		$encryptedData = base64_decode($ajaxData["username"]);
		$decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $privateKey, $encryptedData, MCRYPT_MODE_CBC, $iv);
		echo $decrypted;
	}

	// encodeJSEncrypt
	public function loginEncode(){
		// 接收客户端发送过来的经过加密的登录信息
		// $input = $_POST;
		$input = $_GET;

		var_dump($input);
		// 私钥是放在服务器端的，用以验证和解密客户端经过公钥加密后的信息
		$private_key = $this ->hhjApachePrivateKey();

		// 公钥一般存放在登录页面中的一个隐藏域中，但是请注意：公钥和私钥一定要配对，且必须保证私钥的安全
		// $public_key = $this ->publicKey();

		 
		/**
		 * 使用PHP OpenSSL时，最好先看看手册，了解如何开启OpenSSL 和 其中的一些方法的使用
		 *  具体如何使用这里不做赘述，大家去看看PHP手册，什么都就解决了
		 */
		
		// $pu_key = openssl_pkey_get_public($public_key);// 判断公钥是否是可用的
		// $pi_key =  openssl_pkey_get_private($private_key, "phrase");// 判断私钥是否是可用的，可用返回资源id Resource id 
		$pi_key = openssl_get_privatekey($private_key, "phrase");
		// $decrypted = "";  
		// if ( ! ) die("数据解密失败！");//私钥解密 
		// echo $input['username'];
		openssl_private_decrypt(base64_decode($input['username']), $decrypted, $pi_key);
		var_dump( openssl_private_decrypt($input['username'], $decrypted, $pi_key) );
		// 这里的这个 $decrypted就是解密客户端发送过来的用户名，至于后续连接数据库验证登录信息的代码，这里也就省略了
		var_dump( json_encode( $decrypted ) );
		// return json_encode( $decrypted );
	}

}