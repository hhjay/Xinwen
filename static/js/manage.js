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
	$(".contain-main-item").hover(function() {
		$(this).children('a').removeClass('hide');
	}, function() {
		$(this).children('a').addClass('hide');
	});

	// 
	$("#newsNewBtn").click(function(event) {
		$(".ask-news-edit").removeClass('hide');
	});

	$(".ask-news-edit").delegate('.fa-close', 'click', function(event) {
		event.preventDefault();
		$(".ask-news-edit").addClass('hide');
	});
	/* 确定按钮和取消按钮的事件绑定
	 * 阻止默认事件
	 */
	$(".edit-contain-btn").delegate('input', 'click', function(event) {
		event.preventDefault();
		var _this = $(this),
			btnType = _this.attr("type");
		if ( btnType == "reset" ) {
			_this.parents(".ask-news-edit").addClass('hide');
		}else if( btnType == "submit" ){
			var newsContain = UE.getEditor('myEditor').getContent();
			if ( newsContain.replace(/\s(?=)/g, "") == "" ) {// 空的字符串
				alert("请输入内容！");
			}else{
				$("#editForm").submit();
			}
		}
	});
	$(".news-editor-title").delegate('#newsLabel', 'keyup', function(e) {
		e.preventDefault();
		var keyNum   = e.keyCode,
			labelVal = "";
		var valTime = setTimeout(function(){
			labelVal = $("#newsLabel").val();
		}, 1500);
		if ( keyNum == 32 || keyNum == 13 ) {
			clearTimeout(valTime);
		};
		// $.ajax({
		// 	url: '/path/to/file',
		// 	type: 'default GET (Other values: POST)',
		// 	dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
		// 	data: {param1: 'value1'},
		// });
		
	});
	
});