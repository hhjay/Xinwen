<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/news_index.css" />
<div class="news-bg">
	<div class="news-list-main">
		<div class="news-main pull-left">
			<?php if ( isset($fenlei_label) ) { ?>
			<div class="fenlei-title">
				<h3>
					<b class="pull-left"><i class="fa fa-navicon"></i>所有标签</b>
					<span class="pull-right">共26个标签</span>
				</h3>
				<div class="fenlei-list">
					<?php $thisUrlStr = urldecode( $this ->uri ->segment(3) ); ?>
					<ul>
						<?php foreach ($fenlei_label as $labelRow){ ?>
							<?php 
								$label = $labelRow ->a_label;
								$fenlei_url = base_url().'index.php/manage/fenleiNews/'.$label;
							?>
							<li
							 <?php if ( $thisUrlStr == $label ) { ?>
							 	class="active"
							 <?php } ?>
							 ><a href="<?php echo $fenlei_url ?>"><?php echo $label; ?></a></li>
						<?php } ?>
					</ul>
				</div>
			</div>
			<?php } ?>
			<div class="fenlei-hr"></div>
			<?php
				$all = array();
				if ( isset($fenlei_news) ) {// 分类的列表
					foreach ($fenlei_news as $row) {
						array_push($all, $row);
					}
				}
				if ( isset($search_list) ) {// 分类的列表
					foreach ($search_list as $row) {
						array_push($all, $row);
					}
				}
				if ( isset($all_news) ) {// 所有文章的列表
					foreach ($all_news as $row) {
						array_push($all, $row);
					}
				}
				foreach ($all as $row) {
			?>
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
						<li><a href="javascript:;" data-url="keep">收藏</a></li>
						<li class="left-border">
							<?php 
								$plCount = count($row ->pinglun);
								if ( $plCount > 1000 && $plCount <= 99999999 ) {
									$plCount = number_format($plCount/1000, 2, ".", "");
								}else if( $plCount > 99999999 ){
									$plCount = number_format($plCount/100000000, 2, ".", "");
									$plCount = $plCount . "亿";
								}
							?>
							<a href="<?php echo base_url().'index.php/manage/showNews/'.$row ->a_id.'#commentContain' ?>"
							 target="_blank" data-id="<?php echo $row ->a_id; ?>">
								<span>评论&nbsp;<?php echo $plCount; ?></span>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<?php } ?>

			<?php if ( !isset($fenlei_news) && !isset($search_list) ) { ?>
			<div class="news-page">
				<?php echo $page; ?>
			</div>
			<?php } ?>
		</div>
		<?php if ( !isset($fenlei_news) && !isset($search_list) ) {//有分类的时候就不显示右边的热门那些东西 ?>
		<div class="label-main pull-right">
			<div class="pv-list pull-right">
				<!-- 前十个 浏览量 -->
				<h3>热门新闻</h3>
				<ul>
				<?php foreach ($hotNews as $hotRow) { ?>
					<li>
						<a href="<?php echo base_url().'index.php/manage/showNews/'.$hotRow ->a_id ?>"
						 target="_blank" data-id="<?php echo $hotRow ->a_id; ?>">
							<?php echo $hotRow->a_name; ?>
						</a>
						<span><?php 
							$pv = $hotRow->a_pv;
							if ( $pv > 1000 && $pv <= 99999999 ) {
								$pv = number_format($pv/1000, 2, ".", "");
								$pv = $pv . "K";
							}else if( $pv > 99999999 ){
								$pv = number_format($pv/100000000, 2, ".", "");
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
					<?php foreach ($hotKeep as $keepRow) { ?>
						<li><a href="<?php echo base_url().'index.php/manage/showNews/'.$keepRow ->a_id ?>"
						 target="_blank" data-id="<?php echo $keepRow ->a_id; ?>">
							<?php echo mb_substr($keepRow ->a_name, 0, 5, "utf-8"); ?>
						</a></li>
					<?php } ?>
				</ul>	
			</div>
		</div>
		<?php } ?>
	</div>
</div>
<div class="bottom-20px"></div>
<script type="text/javascript">
$(document).ready(function() {
	$(".label-contain a").click(function(event) {
		event.preventDefault();
		var _this = $(this),
			url   = _this.attr("data-url"),
			a_id  = _this.parent().siblings('li').find('a').attr("data-id");
		if ( url == "keep" ) {
			$.ajax({
				url: base_url+'index.php/manage/ajaxKeepSave',
				type: 'POST',
				dataType: 'text',
				data: {a_id: a_id},
				success: function(res) {
					if(  res == "100" ){
						alert("字符为空!");$("#adminUsername").focus();
					}else if( res == "404" ){
						alert("请求方式出错！");window.location.assign(base_url);
					}else if( res == "101" ) {
						alert("请先登录之后，再收藏该新闻！");$("#adminUsername").focus();
					}else if( res == "202" ){
                        alert("你已经收藏过该新闻。");
                    }else{
						alert("收藏成功!");
					}
				},
				error: function(err){
					console.error(err);
				}
			})
		};
	});
	$(".fenlei-list li").hover(function() {
		$(this).addClass('hover');
	}, function() {
		$(this).removeClass('hover');
	});
});
</script>