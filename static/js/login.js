/*
 *登录页面的js
 */
$(document).ready(function() {
    /*
     * 登录和注册的tab点击事件
     */
	$(".head-contain-login li").click(function() {
		var _this = $(this),
			url   = _this.attr("href"),
			active= _this.attr("class");//判断是否是当前选项
		var id_str= "#" + url;

		_this.siblings().removeClass('active');
		_this.addClass('active');
		$(id_str).siblings().removeClass('active');
		$(id_str).addClass('active');
	});

    /*
     * 加密函数
     * @parm data 要加密的字符串
     * @parm key 加密的key
     * @parm iv 位移量
     */
    function fnEncrypt(data, key, iv) {
        return CryptoJS.AES.encrypt(data, key, {iv: iv}).toString();
    }
    // 登录的
	$("#loginBtn").click(function(event) {
        event.preventDefault();
        var formFlag = false;
        var adminUsername = $("#adminUsername").val(),
            adminPassword  = $("#adminPassword").val(),
            imgCheckStr = $("#imgCheckStr").val();
        
        formFlag = fnCheckInputIsNot(adminUsername, "adminUsername", 0);
        if ( formFlag ) {
            formFlag = fnCheckInputIsNot(adminPassword, "adminPassword", 1);
            if ( formFlag ) {
                formFlag = fnCheckInputIsNot(imgCheckStr, "imgCheckStr", 2);
            };
        };
        var key = CryptoJS.enc.Utf8.parse( "1234567812345678" );
        var iv  = CryptoJS.enc.Utf8.parse('1234567812345678');
        var data = {};
        data = {
            "userName": adminUsername,
            "userPassword": fnEncrypt(adminPassword, key, iv),
            "imgCheckStr": fnEncrypt(imgCheckStr, key, iv)
        };
        if ( formFlag ) {
            $.ajax({
                url: base_url + "index.php/login/adminLogin",
                type: 'POST',
                dataType: 'text',
                data: data,
                success: function(res) {
                    if ( res == "100" || res == "101" ) {
                        alert("图片验证失败！");
                        var img = $("#imgCheckStr").parent().find("img");
                        img.attr("src", base_url + "index.php/login/imgLoginShow?nocache="+Math.random() );
                        $("#imgCheckStr").focus();
                    }else if ( res == "300" ) {
                        alert("查无此账号。");
                        $("#userName").focus();
                    }else if( res == "303"){
                        alert("密码错误！");
                        $("#userPassword").focus();
                    }else if( res == "404"){
                        alert("404 not found！");
                        window.location.assign(base_url);
                    }else{// 200 登录成功
                        window.location.assign(base_url);
                    }
                },
                error: function(err) {
                    console.error(err);
                }
            });
        };
	});
    
    // input获得焦点
    $("input").focus(function() {
        if ( $(this).attr("class") == "img-input" ) {
            $(this).addClass('input-active');
        }else{
            $(this).parent().addClass('input-active');
        }
    });
    
    // input失去焦点
    $("input").blur(function() {
        $("input").parent().removeClass('input-active');
        $("input").removeClass('input-active');
    });

    // 注册的
    $("#registerBtn").click(function(event) {
        event.preventDefault();
        var formFlag = false;
        var registerUsername = $("#registerUsername").val(),
            registerAccount  = $("#registerAccount").val(),
            registerPassword = $("#registerPassword").val(),
            registerImgStr   = $("#registerImgStr").val();
        
        formFlag = fnCheckInputIsNot(registerUsername, "registerUsername", 0);
        if ( formFlag ) {
            formFlag = fnCheckInputIsNot(registerAccount, "registerAccount", 0);
            if ( formFlag ) {
                formFlag = fnCheckInputIsNot(registerPassword, "registerPassword", 1);
                if ( formFlag ) {
                    formFlag = fnCheckInputIsNot(registerImgStr, "registerImgStr", 2);
                };
            };
        };
        var key = CryptoJS.enc.Utf8.parse( "1234567812345678" );
        var iv  = CryptoJS.enc.Utf8.parse('1234567812345678');
        var data = {};
        data = {
            "userName": registerUsername,
            "userAccount": registerAccount,
            "userPassword": fnEncrypt(registerPassword, key, iv),
            "registerImgStr": fnEncrypt(registerImgStr, key, iv),
        };
        if ( formFlag ) {
            $.ajax({
                url: base_url + "index.php/login/addRegister",
                type: 'POST',
                dataType: 'text',
                data: data,
                success: function(res) {
                    if ( res == "100" || res == "101" ) {
                        alert("图片验证失败！");
                        // 改变验证图片
                        var img = $("#registerImgStr").parent().find("img");
                        img.attr("src", base_url + "index.php/login/imgRegisterShow?nocache="+Math.random() );

                        $("#registerImgStr").focus();
                    }else if ( res == "300" ) {
                        alert("改账号名已存在,请注意姓名和账号名的区别！");
                        $("#userAccount").focus();
                    }else if( res == "404"){
                        alert("404 not found！");
                        window.location.assign(base_url);
                    }else{
                        window.location.assign(base_url);
                    }
                },
                error: function(err) {
                    console.error(err);
                }
            });
        };
    });

    /* 判断是否合法
     * @parm str 传入的字符
     * @parm idName 传入的id名
     * @parm password 是否密码(1-密码 2-图片验证码 0-用户名和账号)
     */
    function fnCheckInputIsNot(str, idName, password){
        if ( str.length == 0 ) {
            alert("请填写内容!");
            $("#"+idName).focus(); return false;
        };
        var regExp;
        switch(password){
            case 0:
                regExp = new RegExp(/^[a-zA-Z0-9_\u4e00-\u9fa5]+$/g);
                break;
            case 1:
                regExp = new RegExp(/^[a-zA-Z0-9]+$/g);
                break;
            default:
                regExp = new RegExp(/^[a-z0-9]+$/g);
        }
        if ( !regExp.test(str) ) {
            alert("含非法字符!");
            $("#"+idName).focus(); return false;
        };
        return true;
    }
});