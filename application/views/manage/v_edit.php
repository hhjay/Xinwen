<?php if ( !empty($session) ) {// 判断是否登录 如果没有登录那么直接不加载该编辑框 ?>
<style type="text/css">
/*编辑器的*/
.ask-news-edit{
	position: relative;
	width: 100%;height: 100%;
}
.bg-opacity{
	width: 100%;height: 100%;
	position: fixed;top: 0;
	background: #000;opacity: 0.8;
}
.edit-news-main{
	width: 600px;
	height: 600px;
	position: fixed;
	background: #fff;border-radius: 4px;
	top:20px;left: 50%;margin-left: -300px;
}
.edit-news-head{
	background: #EFF6FE;
	border-top-right-radius: 4px;
	border-top-left-radius: 4px;
}
.edit-news-head h2{
	padding: 10px;
}
.edit-news-head h2 i{
	cursor: pointer;
}
.news-editor-title{
	position: relative;
	padding: 10px;
}
.news-editor-title input{
	width: 100%; height: 30px;
	border: 1px solid #ddd;border-radius: 4px;
}
.news-label-return-list{
	position: absolute;
	width: 97%;
    color: #fff;
}
.news-label-return-list ul{ width: 97%;height: 100%; }
.news-label-return-list li{
	width: 100%;height: 30px;
	background: #000;
    opacity: 0.8;cursor: pointer;
	line-height: 30px;padding-left: 15px;
}
.news-label-return-list li:hover{
	background: #e5e5e5;color: #003399;
	opacity: 1;
}
.edit-contain-btn{
	padding: 10px;
}
.edit-contain-btn input, .edit-contain-btn button{
	background: #ddd;
	padding: 5px 15px;
	float: right;margin-right: 10px;border: 1px solid #fff;
	cursor: pointer;
}
.edit-contain-btn .reset-btn{
	background: #fff;color: #003399;
}
.edit-contain-btn input:hover{
	border: 1px solid #ddd;
}
/*
 * 自定义 ueditor
 */
#edui1_elementpath{ display: none; }
.view{ overflow: auto !important;height: 390px !important; }
</style>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>static/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>static/ueditor/editor_api.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>static/ueditor/lang/zh-cn/zh-cn.js"></script>
<div class="ask-news-edit hide">
	<div class="bg-opacity"></div>
	<div class="edit-news-main">
		<div class="edit-news-head">
			<h2>编辑新闻 <i class="fa fa-close pull-right"></i></h2>
		</div>
		<?php 
			$name = "";
			$label = "";
			$url = base_url() . "index.php/manage/saveNews";
			if ( isset($news_contain) ) {
				$a_id = $news_contain["a_id"];
				$url = base_url()."index.php/manage/uptateNews/".$a_id;// 修改新闻链接 
				$name = $news_contain["a_name"];
				$label = $news_contain['a_label'];
			}
		?>
		<form id="editForm" method="post" action="<?php echo base_url() ?>index.php/manage/saveNews">
	        <div class="news-editor-title">
	        	<input type="text" name="newsTitle" id="newsTitle" placeholder="新闻标题" value="<?php echo $name; ?>" />
	        </div>
	        <script type="text/plain" id="newsContainEdit" name="newsContainEdit">
	            <?php if ( isset($news_contain) ) {
	            	echo $news_contain["a_content"];
	            }else{ ?>
	            	<p>这是新闻具体内容</p>
	            <?php } ?>
	        </script>
	        <div class="news-editor-title">
	        	<input type="text" name="newsLabel" id="newsLabel" placeholder="新闻标签" value="<?php echo $label ?>" />
	        	<div class="news-label-return-list">
	        		<ul>
	        		</ul>
	        	</div>
	        </div>
	        <div class="edit-contain-btn">
	        	<button type="submit">提交</button>
	        	<button type="reset" class="reset-btn">取消</button>
	        </div>
	    </form>
		<script type="text/javascript">
			UE.getEditor('newsContainEdit',{
		        initialFrameWidth : 598,
		        initialFrameHeight: 200
		    });
		</script>
	</div>
</div>
<?php } ?>