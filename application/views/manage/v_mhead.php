<!-- 个人主页 -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/font-awesome/font-awesome.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/manage_head.css" />
<div class="manage-head-bg">
	<div class="manage-head">
		<div class="manage-logo pull-left">新闻</div>
		<div class="manage-search pull-left">
			<!-- 这里是搜索框 -->
			<form  method="post" name="keyWordSearch">
				<input type="text" name="keySearch" id="keySearch" class="key-input" placeholder="搜索你感兴趣的新闻" required />
				<button class="btn-submit" id="loginBtn"><i class="fa fa-search"></i></button>
			</form>
		</div>
		<!-- 标签 -->
		<?php 
			$all = array();
			// 首页
			if ( isset($all_news) ) {// 所有文章的列表
				foreach ($all_news as $row) {
					array_push($all, $row ->a_id);
				}
			}
			// 分类页面
			if ( isset($fenlei_news) ) {// 分类的列表
				foreach ($fenlei_news as $row) {
					array_push($all, $row ->a_id);
				}
			}
			// 文章显示页面
			if ( isset($news_list) ) {
				for ($i=0; $i < count($news_list); $i++) { 
					array_push($all, $news_list[$i]->a_id);
				}
			}
			// 个人页面
			if ( isset($pinglunMsg) && count($pinglunMsg) > 0 ) {
				for ($i=0; $i < count($pinglunMsg); $i++) { 
					array_push($all, $pinglunMsg[$i]->a_id);
				}
			}else if( isset($keepMsg) && count($keepMsg) > 0 ){
				for ($i=0; $i < count($keepMsg); $i++) { 
					array_push($all, $keepMsg[$i]->a_id);
				}
			}

			$rand = 1;
			if ( count($all) == 0 ) {
				$num = 1;
			}else{
				for ($i=0; $i < count($all); $i++) { 
					$rand = rand( 0, count($all)-1);
				};
				$num = $all[$rand];
			}
		?>
		<div class="manage-label pull-left">
			<ul>
				<a href="<?php echo base_url(); ?>"><li
				<?php if( isset($all_news) ){ ?> class="active" <?php } ?>
				 >首页</li></a>
				<!-- 给你n多表签的选择 -->
				<a href="<?php echo base_url().'index.php/manage/fenleiNews' ?>"><li
				<?php if ( isset($fenlei_news) ) { ?> class="active" <?php } ?>>分类</li></a>
				<!-- 推荐给你看的新闻 -->
				<a href="<?php echo base_url().'index.php/manage/showNews/'.$num ?>" data-id="<?php echo $num; ?>"><li
				<?php if ( isset($news_list) ) { ?> class="active" <?php } ?> >发现</li></a>
				<!-- 别人评论你的 -->
				<?php if ( isset($session)) {//该功能正在研发中 ?>
				<!-- <a href=""><li>消息</li></a> -->
				<?php } ?>
			</ul>
		</div>

		<!-- 个人信息的下拉菜单 -->
		<?php if ( isset($session) ) { ?>
		<div class="self-tab pull-right">
			<div class="self-tab-name">
				<a href="">
					<img src="<?php echo base_url(); ?>static/upload/<?php echo $session["u_head"]; ?>" alt="新闻" />
					<span><?php echo $session["u_name"]; ?></span>
				</a>
			</div>
			<div class="self-tab-main hide">
				<ul>
					<a href="<?php echo base_url() ?>index.php/login/personShow/<?php echo $session['u_account']; ?>"><li>我的主页</li></a>
					<a href="<?php echo base_url() ?>index.php/login/logout"><li>退出</li></a>
				</ul>
			</div>
		</div>
		<!-- 编辑新的新闻 -->
			<?php if ( !isset($news_contain) ) { ?>
				<div class="manage-new pull-right"><button id="newsNewBtn">编&nbsp;辑</button></div>
			<?php } ?>
		<?php } ?>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/lib/jquery-1.12.2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/manage.js"></script>