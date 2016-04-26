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
		<div class="manage-label pull-left">
			<ul>
				<a href="<?php echo base_url(); ?>"><li class="active">首页</li></a>
				<!-- 给你n多表签的选择 -->
				<a href=""><li>分类</li></a>
				<!-- 推荐给你看的新闻 -->
				<a href=""><li>发现</li></a>
				<!-- 别人评论你的 -->
				<?php if ( isset($session)) { ?>
				<a href=""><li>消息</li></a>
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
					<a href=""><li>管理</li></a>
					<a href="<?php echo base_url() ?>index.php/login/logout"><li>退出</li></a>
				</ul>
			</div>
		</div>
		<!-- 编辑新的新闻 -->
		<div class="manage-new pull-right"><button id="newsNewBtn">编&nbsp;辑</button></div>
		<?php } ?>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/lib/jquery-1.12.2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/manage.js"></script>