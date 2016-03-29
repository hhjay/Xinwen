/*
 *登录页面的tab 事件
 */
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

    function fnEncrypt(data, key, iv) {
        return CryptoJS.AES.encrypt(data, key, {iv: iv}).toString();
    }
	$("#loginBtn").click(function(event) {
		var formFlag = false,
		    data     = [];

        data['username']= $.trim( $("#adminUsername").val() );
        data['passwd']= $.trim( $("#adminPassword").val() );
 		
        var time = new Date();
        var utcTime = parseInt( time.getTime() / 1000 ),
            rand    = Math.random();

        var key = CryptoJS.enc.Utf8.parse( "1234567812345678" );
        var iv  = CryptoJS.enc.Utf8.parse('1234567812345678');
    	var encrypted = fnEncrypt(data['username'], key, iv);
        $.ajax({
        	url: base_url + "index.php/login/fnAESdecrypte",
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

    // 注册的
    $("#registerBtn").click(function(event) {
        var formFlag = false;
        var username = $("#registerUsername").val(),
            Account  = $("#registerAccount").val(),
            password = $("#registerPassword").val(),
            imgStr   = $("#imgCheckStr").val();
        var regExp = new RegExp(/^\s*$/);
        if ( regExp.test(username) ) {
            console.log("sss");
        };
        // 我们会帮你清除空格 所以请注意你输入的字符中有没有空格
        // $ajax = preg_replace('/\s(?=)/', '', $ajax);// 清除空白

        // if ( username == ) {};
    });

    // 通过form来判断表单是否合法
    function checkInput(formName) {
        var formFlag = false;
        var form = $("form");// 所有的(form)表单
        var _thisForm;
        for (var i = 0; i < form.length; i++) {
            if ( $("form:eq("+i+")").attr("name") == formName ) {
                _thisForm = form[i];
                break;
            };
        };
        // console.log( $(_thisForm).find("input") );
        if ( $(_thisForm).find("input").val() == "" ) {
            console.log("sss");
        };
    }
    checkInput("registerForm");

});