<!-- 个人主页 -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/font-awesome/font-awesome.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/manage.css" />
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
				<a href=""><li class="active">首页</li></a>
				<!-- 给你n多表签的选择 -->
				<a href=""><li>分类</li></a>
				<!-- 推荐给你看的新闻 -->
				<a href=""><li>发现</li></a>
				<!-- 别人评论你的 -->
				<a href=""><li>消息</li></a>
			</ul>
		</div>
		<!-- 个人信息的下拉菜单 -->
		<div class="self-tab pull-right">
			<div class="self-tab-name">
				<a href="">
					<img src="<?php echo base_url(); ?>static/upload/head.jpg" alt="新闻" />
					<span>haung</span>
				</a>
			</div>
			<div class="self-tab-main hide">
				<ul>
					<a href="<?php echo base_url() ?>index.php/manage"><li>我的主页</li></a>
					<a href=""><li>管理</li></a>
					<a href="<?php echo base_url() ?>index.php/login/logout"><li>退出</li></a>
				</ul>
			</div>
		</div>
		<!-- 编辑新的新闻 -->
		<div class="manage-new pull-right"><button>编&nbsp;辑</button></div>
	</div>
</div>
<div class="manage-contain">
	<div class="manage-contain-left pull-left">
		<!-- 个人信息的展示 border包含的地方 -->
		<div class="contain-self-message">
			<h2>黄小杰<span> , 这是你的个人一句话介绍</span></h2>
			<!-- 个人头像 -->
			<div class="contain-self-headImg pull-left">
				<img src="<?php echo base_url(); ?>static/upload/head.jpg" alt="新闻" />
			</div>
			<div class="contain-self-main pull-left">
				<div class="contain-main-item item-first">
					<span class="boder-right"><i class="fa fa-map-marker"></i>云南省</span>
					<span class="boder-right">计算机软件行业</span>
					<span><i class="fa fa-mars"><!-- 男 --></i><!-- <i class="fa fa-venus">女</i> --></span>
				</div>
				<div class="contain-main-item">
					<span class="boder-right"><i class="fa fa-building"></i>百度</span>
					<span>java高级工程师</span>
				</div>
				<div class="contain-main-item">
					<span class="boder-right"><i class="fa fa-mortar-board"></i>中南民族大学</span>
					<span>文学与新闻传播</span>
				</div>
				<div class="contain-main-item">
					<span><i class="fa fa-hand-o-right"></i>你还想说点什么</span>
				</div>
			</div>

			<div class="clear-fix"><!-- 清除浮动 --></div>
			<!-- 点击可以查看下面的具体内容 -->
			<div class="contain-nav">
				<ul>
					<li>所有</li>
					<li>发布<!-- 自己发布的新闻 --></li>
					<li>评论<!-- 自己评论的新闻 --></li>
					<li>收藏<!-- 自己评论的收藏 --></li>
				</ul>
			</div>
		</div>
		<div class="news-contain">
			<h3>发布的新闻</h3>
			<div class="news-contain-main">
				<div class="news-contain-comment">
					<span>0</span>
					<span>评论</span>
				</div>
				<div class="news-contaiin-title">
					<a href="">这是新闻标题</a>
					<p>新闻前200字...</p>
				</div>
			</div>
		</div>
		<div class="news-contain">
			<h3>被评论的新闻</h3>
			<div class="news-contain-main">
				<div class="news-contain-comment">xx评论了该新闻</div>
				<div class="news-contaiin-title">
					<a href="">这是新闻标题</a>
					<p>新闻前200字...</p>
				</div>
				<div class="new-comment-time">这是评论新闻的时间(5天前)</div>
			</div>
		</div>
		<div class="news-contain">
			<h3>你自己收藏的新闻</h3>
			<div class="news-contain-main">
				<div class="news-contaiin-title">
					<a href="">这是新闻标题</a>
					<p>新闻前200字...</p>
				</div>
			</div>
		</div>
	</div>
	<div class="manage-contain-right pull-right">
		<!-- 你收藏别人的表签 -->
		<div class="news-label-keep">
			<span>收藏了</span>
			<span>多少标签</span>
		</div>
		<!-- 别人收藏了多少你的标签 -->
		<div class="news-label-keep">
			<span>收藏了</span>
			<span>多少标签</span>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/lib/jquery-1.12.2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/manage.js"></script>