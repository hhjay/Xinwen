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

});