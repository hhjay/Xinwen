/*
 * 新闻管理页面的js
 */
$(document).ready(function() {
	// 下拉菜单 注意mouseout和mouseleave的区别
	$(".self-tab-name").mouseenter(function() {
		$(this).addClass('active');
		$(this).parent().find(".self-tab-main").removeClass('hide');
	}); 
	$(".self-tab-main").mouseleave(function(event) {
		$(this).parent().find('.self-tab-name').removeClass('active');
		$(this).addClass('hide');
	});

	// 信息修改 显示修改按钮与否
	$(".contain-item-show").hover(function() {
		$(this).children('a').removeClass('hide');
	}, function() {
		$(this).children('a').addClass('hide');
	});
	$(".contain-self-message h2").hover(function() {
		$(this).children().children('.introduce-btn').removeClass('hide');
	}, function() {
		$(this).children().children('.introduce-btn').addClass('hide');
	});
	// 修改按钮点击之后
	$(".edit-btn").click(function(event) {
		$(this).parents(".contain-item-show").addClass('hide');
		$(this).parents(".contain-item-show").siblings(".contain-item-edit").removeClass('hide');
	});
	$(".introduce-btn").click(function() {
		$(this).parent().addClass('hide');
		$(this).parent().siblings('.introduce-span').removeClass('hide');
	});
	// 修改按钮之后的确定按钮 触发ajax事件给后台传数据 保存修改的
	$(".save-btn").click(function(event) {
		var data = {
			"u_address": $("#userAddress").val(),
			"u_industry": $("#userIndustry").val(),
			"u_school": $("#userSchool").val(),
			"u_company": $("#userCompany").val(),
			"u_occupation": $("#userOccupation").val(),
			"u_major": $("#userMajor").val(),
			"u_sex": $("#userSex").val(),
			"u_talk": $("#userTalk").val(),
			"u_introduce": $("#userIntroduce").val()
		};
		$.ajax({
			url: base_url+'index.php/login/updateUserMsg',
			type: 'POST',
			data: data,
			success: function(){
                window.location.assign(base_url);
			},
			error: function(err){
				console.error(err);
			}
		});
	});

	// 编辑按钮的点击事件 使当前的新闻编辑出现
	$("#newsNewBtn").click(function(event) {
		event.preventDefault();
		// $(".ask-news-edit input").val("");
		// $("#newsContainEdit #ueditor_0 body").html("<p>这是新闻具体内容</p>");
		$(".ask-news-edit").removeClass('hide');
	});
	$(".ask-news-edit").delegate('.fa-close', 'click', function(event) {
		event.preventDefault();
		$(".ask-news-edit").addClass('hide');
	});
	/* 确定按钮和取消按钮的事件绑定
	 * 阻止默认事件
	 */
	$(".edit-contain-btn").delegate('button', 'click', function(event) {
		event.preventDefault();
		var _this = $(this),
			btnType = _this.attr("type");
		if ( btnType == "reset" ) {
			_this.parents(".ask-news-edit").addClass('hide');
		}else if( btnType == "submit" ){
			var title = $("#newsTitle").val(),
				label = $("#newsLabel").val();
			if ( title.replace(/\s(?=)/g, "") == "" ) {// 空的字符串
				$("#newsTitle").focus(); alert("请输入内容！");
			}else if( label.replace(/\s(?=)/g, "") == "" ){
				$("#newsLabel").focus(); alert("请输入内容！");
			}else{
				$("#editForm").submit();
			}
		}
	});
	// 标签输入时候返回的列表li
	$(".news-editor-title").delegate('#newsLabel', 'keyup', function(e) {
		e.preventDefault();
		var keyNum   = e.keyCode,
			labelVal = "";
		var valTime = setTimeout(function(){
			labelVal = $("#newsLabel").val();
		}, 1500);
		if ( keyNum == 32 || keyNum == 13 || keyNum == 8 || (keyNum >=48 && keyNum<= 57) ) {
			clearTimeout(valTime);
			labelVal = $("#newsLabel").val();
			$(".news-label-return-list ul").html();
			$.ajax({
				url: base_url + "/index.php/manage/labelAjaxList",
				type: 'POST',
				dataType: 'text',
				data: { label: labelVal },
				success: function(res){
					if ( res == 100 ) {
						alert("空字符串！");
					}else if( res == 404 ){
						alert("错误的方式！");
					}else if( res == 400 ){
						alert( "没有返回结果" );
					}else{
						var labelArr = res.split(","),
							listHtml = "",
							len      = 10;
						if ( labelArr.length <= 10 ) {
							len = labelArr.length - 1;
						}
						for (var i = 0; i < len; i++) {
							listHtml += "<li>"+ labelArr[i] +"</li>";
						};
						$(".news-label-return-list").removeClass('hide');
						$(".news-label-return-list ul").append( listHtml );
					}
				},
				error: function(err){
					console.error( "error"+err );
				}
			});
		};
	});
	$(".news-label-return-list").delegate('li', 'click', function() {
		$("#newsLabel").val( $(this).text() );
		$(".news-label-return-list").addClass('hide');
	});	
	

	// 头像上传的按钮 显示与消失
	$(".contain-self-headImg img").mouseenter(function() {
		$(this).siblings('span').removeClass('hide');
	}); 
	$("#upfileSpan").mouseleave(function(event) {
		$(this).addClass('hide');
	});

	// 上传头像的选择
	$("#upfileSpan").click(function(event) {
		$("#userFile").click();
	});
	// 上传头像 选中
	$("#userFile").change(function(event) {
		$(this).parent().submit();
	});

	$(".contain-nav li").click(function(event) {
		// event.preventDefault();
		var _this   = $(this)
			_thisId = _this.attr("href");

		_this.siblings().removeClass('active');_this.addClass('active');
		if ( _thisId != "#selfHome" ) {
			$(".news-contain").addClass('hide');
			$( _thisId ).removeClass('hide');
		}else{
			$(".news-contain").removeClass('hide');
		}
		
	});
    
});