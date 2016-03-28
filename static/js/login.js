/*
 *登录页面的tab 事件
 */
// require.config({
// 	baseUrl: "./static/js/",
// 	paths: {
//         'require-js': 'aes'
//     }
// });
// require( ["aes"],function(CryptoJS) {


jQuery(document).ready(function($) {

	$(".head-contain-login li").click(function(event) {
		var _this = $(this),
			url   = _this.attr("href"),
			active= _this.attr("class");//判断是否是当前选项
		var id_str= "#" + url;

		_this.siblings().removeClass('active');
		_this.addClass('active');
		$(id_str).siblings().removeClass('active');
		$(id_str).addClass('active');
	});


// login点击事件
	function fnEncrypt(data, key, iv) {
  	 	return CryptoJS.AES.encrypt(data, key, {iv: iv}).toString();
	}
	$("#loginBtn").click(function(event) {
		// var formFlag = false;
		var data = [];
        data['username']= $.trim( $("#adminUsername").val() );
        data['passwd']= $.trim( $("#adminPassword").val() );
 		var pkey = "";
 		
 		var key = CryptoJS.enc.Utf8.parse('1234567812345678');//CryptoJS.enc.Hex.parse
    	var iv  = CryptoJS.enc.Utf8.parse('1234567812345678');//CryptoJS.enc.Utf8.parse

    	// var encrypted = CryptoJS.AES.encrypt("Message", key, { iv: iv });
    	console.log( data['username'] );
    	var encrypted = fnEncrypt(data['username'], key, iv);
    	console.log( encrypted );

    	
        $.ajax({
        	url: base_url+"index.php/login/fnAESdecrypte",
        	type: 'POST',
        	dataType: 'text',
        	data: {username: encrypted},
        	success: function(res) {
        		console.log( res );
        	},
        	error: function(err) {
        		console.error(err);
        	}
        });
	});


});


// jQuery(document).ready(function($) {
	
	
// });