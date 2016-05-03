<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/manage_self.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/manage_news.css" />
<div class="manage-contain">
	<div class="manage-contain-left pull-left">
		<div class="news-head">
			<span><?php echo $news_contain["a_name"]; ?></span>
			<?php if ( $isSameUser ) { ?>
			<a href="javascript:;" class="edit-btn hide"><i class="fa fa-edit"></i><span>修改</span></a>
			<?php } ?>
		</div>
		<div class="news-time"><?php echo date('Y-m-d H:i:s',$news_contain["a_time"]); ?></div>
		<div class="news-contain">
			<?php echo $news_contain["a_content"]; ?>
		</div>
		<div class="news-author">作者：<?php echo $userMsg["u_name"]; ?></div>
		<div class="news-comment comment-form">
			<h2>我来说两句 (<span><?php echo count($comment) ?></span>人参与)</h2>
			<!-- 评论区 -->
			<?php if ( !isset($session) ) { ?>
			<?php 
				$u_head = $session["u_head"];
				if ( !$u_head ) {
					$u_head = "head.jpg";
				}
			?>
			<?php 
				}else{
					$u_head = "head.jpg";
				} 
			?>
			<div class="pull-left">
				<img src='<?php echo base_url(); ?>static/upload/<?php echo $u_head; ?>' />
			</div>
			<div class="pull-right">
				<form id="cmmentForm" method="post" action="<?php echo base_url() ?>index.php/manage/commentNews">
					<textarea name="commentContain" id="commentContain" class="text-input no-focus">这里是你的评论区(没有登录默认匿名评论)</textarea>
					<input type="text" name="newsId" value="<?php echo $news_contain['a_id']; ?>" class="hide" />
					<input type="submit" class="comment-submit" />
				</form>
			</div>
		</div>
		<div class="comment-list">
			<div class="comment-li">
				<!-- 用户头像 -->
				<?php foreach ($comment as $commentRow) { ?>
					<?php 
						$userUrl = base_url().'index.php/login/personShow/'.$commentRow->c_user_account;
						if ( $commentRow->c_user_account == "0" ) {
							$u_head = "head.jpg";
							$u_name = "匿名用户";
						}else{
							$u_head = $commentRow ->u_head;
							$u_name = $commentRow ->u_name;

							if ( !isset($u_head) ) {
								$u_head = "head.jpg";
							}
						}
					?>
					<a href="<?php echo $userUrl; ?>" target="_blank">
						<img src='<?php echo base_url(); ?>static/upload/<?php echo $u_head; ?>' class="pull-left" />
					</a>
					<div class="pull-left list-right">
						<div class="list-user-msg">
							<?php if ( $commentRow->c_user_account != "0" ) { ?>
								<a href="<?php echo $userUrl ?>" target="_blank">
							<?php } ?>
								<?php echo $u_name; ?>
							<?php if ( $commentRow->c_user_account != "0" ) { ?>
								</a>
							<?php } ?>
							<span class="list-time"><?php echo date('Y-m-d H:i:s',$commentRow ->c_time); ?></span>
						</div>
						<div class="list-contain"><?php echo $commentRow ->c_contain; ?></div>
					</div>
				<?php } ?>
			</div>
		</div>
		<div class="bottom-20px"></div>
	</div>
	<div class="manage-contain-right pull-right">
		<div class="new-label">
			<!-- 你收藏别人的表签 -->
			<div class="news-label-keep pull-left">
				<span>该新闻已被</span> <b><?php echo $news_contain["a_pv"] ?></b> <span>人浏览</span>
			</div>
		</div>
		<div class="news-recommend">
			<!-- 相关推荐 十条 -->
			<h3>本文相关推荐</h3>
			<ul>
			<?php for ($i=0; $i < count($news_list); $i++) { ?>
				<li>
					<a href="<?php echo base_url().'index.php/manage/showNews/'.$news_list[$i]->a_id; ?>"
					 data-id="<?php echo $news_list[$i]->a_id; ?>">
						<?php echo $news_list[$i]->a_name; ?>
					</a>
				</li>
			<?php } ?>
			</ul>
		</div>
		<div class="bottom-20px"></div>
		<div class="footer-copyright">
			<ul>
				<li><a href="http://www.scuec.edu.cn/" target="_blank">中南民族大学</a></li>
				<li><a href="">黄会杰</a></li>
				<li><a href="javascript:;" id="feedbackButton">建议反馈</a></li>
				<li><a href="">商务合作&copy;2016新闻</a></li>
			</ul>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		// 评论框的
		$("#commentContain").focus(function(event) {
			$(this).val("");
			$(this).removeClass('no-focus');
		});
		$("#commentContain").blur(function(event) {
			$(this).addClass('no-focus');
		});
		$(".news-head").hover(function() {
			$(this).children('a').removeClass('hide');
		}, function() {
			$(this).children('a').addClass('hide');
		});
		$(".edit-btn").click(function() {
			$(".ask-news-edit").removeClass('hide');
		});
	});
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/manage.js"></script>