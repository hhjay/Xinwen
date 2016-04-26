<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/news_index.css" />
<?php #var_dump($all_news); ?>
<div class="news-bg">
	<div class="news-list-main">
		<div class="news-main pull-left">
			<?php foreach ($all_news as $row) { ?>
			<div class="news-and-author">
				<div class="news-author">
					<!-- 头像 -->
					<?php 
						$u_account = $row->u_account;
						$url = base_url().'index.php/login/personShow/'.$u_account;
					?>
					<a href="<?php echo $url; ?>" class="pull-left" target="_blank">
						<img src="<?php echo base_url().'static/upload/'.$row ->u_head; ?>" />
					</a>
					<div class="author-name pull-left">
						<a href="<?php echo $url; ?>"><h3><?php echo $row ->u_name ?></h3></a>
						<div class="news-time"><?php echo date('Y-m-d H:i:s',$row ->a_time); ?>   </div>
					</div>
				</div>
				<div class="news-contain">
					<span class="news-title">
						<span>———— </span>
						<a href="<?php echo base_url().'index.php/manage/showNews/'.$row ->a_id ?>"
						 data-id="<?php echo $row ->a_id; ?>">
							<?php echo $row ->a_name ?>
						</a>
						<span> ————</span>
					</span>
					<div class="news-show">
						<a href="<?php echo base_url().'index.php/manage/showNews/'.$row ->a_id ?>"
						 target="_blank" data-id="<?php echo $row ->a_id; ?>">
						<?php 
							$a_content = $row ->a_content;
							$exp = '/<[^a][^<>]*>/';// 所有非a链接的文字

							$showStr = preg_replace($exp, "", $a_content);
							$showStr = mb_substr($showStr, 0, 250, "utf-8");
							$show = "";
							if( preg_match_all('/<img.*?>/', $a_content, $imgMatch) ){// 判断当前图片
								$imgArr = $imgMatch[0];
								$len = count($imgArr);
							    if( count($imgArr) > 0 ){
							    	if( count($imgArr) > 3 ){
							    		$len = 3;
							    	}
							    	for ($i=0; $i < $len; $i++) { 
							    		$show = $show.$imgArr[$i];
							    	}
							    }
							}
						?>
						<p><?php echo $showStr; ?></p>
						</a>
						<a href="<?php echo base_url().'index.php/manage/showNews/'.$row ->a_id; ?>"
						 target="_blank" data-id="<?php echo $row ->a_id; ?>">
							<?php echo $show; ?>
						</a>
					</div>
					<!-- 判断有没有图片并输出有图片(第一章图片)的 -->
				</div>
				<!-- 收藏标签 -->
				<div class="label-contain">
					<ul>
						<li><a href="">收藏</a></li>
						<li class="left-border">
							<a href="<?php echo base_url().'index.php/manage/showNews/'.$row ->a_id.'#commentContain' ?>"
							 target="_blank" data-id="<?php echo $row ->a_id; ?>">
								<span>评论&nbsp;5k</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<?php } ?>
			<div class="news-page">
				<?php echo $page; ?>
			</div>
		</div>
		<div class="label-main pull-right">
			<div class="pv-list pull-right">
				<!-- 前十个 浏览量 -->
				<h3>热门新闻</h3>
				<ul>
				<?php foreach ($hotNews as $hotRow) { ?>
					<li>
						<a href="echo base_url().'index.php/manage/showNews/'.$hotRow ->a_id">
							<?php echo $hotRow->a_name; ?>
						</a>
						<span><?php 
							$pv = $hotRow->a_pv;
							if ( $pv > 1000 && $pv <= 99999999 ) {
								$pv = $pv / 1000;
								$pv = $pv . "K";
							}else if( $pv > 99999999 ){
								$pv = $pv / 100000000;
								$pv = $pv . "亿";
							}
							echo $pv;
						?></span>
					</li>
				<?php } ?>
				</ul>	
			</div>
			<div class="label-list pull-right">
				<!-- 发表最多的标签 前九个 -->
				<h3>热门收藏</h3>
				<ul>
					<li><a href="">热门收藏1</a></li>
					<li><a href="">政治</a></li>
					<li><a href="">视频</a></li>
					<li><a href="">图片</a></li>
					<li><a href="">图片</a></li>
					<li><a href="">图片</a></li>
					<li><a href="">图片</a></li>
					<li><a href="">图片</a></li>
					<li><a href="">图片</a></li>
				</ul>	
			</div>
		</div>
	</div>
</div>
<div class="bottom-20px"></div>