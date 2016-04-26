<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/manage_self.css" />
<div class="manage-contain">
	<div class="manage-contain-left pull-left">
		<!-- 个人信息的展示 border包含的地方 -->
		<div class="contain-self-message">
			<h2><?php echo $user["u_name"]; ?>
				<span>，
					<?php if ( empty($user["u_introduce"]) ) {  ?>
						<a href="javascript:;" class="introduce-btn">这是你的个人一句话介绍</a>
					<?php }else{ 
						echo $user["u_introduce"];
					} ?>
					<?php if ( $isSameUser ) { ?>
						<a href="javascript:;" class="introduce-btn hide"><i class="fa fa-edit"></i><span>修改</span></a>
					<?php } ?>
				</span>
				<span class="introduce-span hide">
					<input type="text" id="userIntroduce" value='<?php echo $user["u_introduce"]; ?>' placeholder="这是你的个人一句话介绍" />
					<button class="save-btn">确定</button>
				</span>
			</h2>
			<!-- 个人头像 -->
			<div class="contain-self-headImg pull-left">
				<?php 
					$u_head = $user["u_head"];
					if ( !$u_head ) {
						$u_head = "head.jpg";
					}
				 ?>
				<img src="<?php echo base_url(); ?>static/upload/<?php echo $u_head; ?>" alt="新闻" />
				<?php if ( isset($session) ) { ?>
				<span id="upfileSpan" class="hide">上传头像</span>
					<?php echo form_open_multipart('login/upfileAjax'); ?>
						<input type="file" name="userFile" id="userFile" size="20" />
		        		<input type="submit" value="上传" />
					</form>
				<?php } ?>
			</div>
			<div class="contain-self-main pull-left">
				<div class="contain-main-item item-first">
					<span class="pull-left"><i class="fa fa-map-marker"></i></span>
					<div class="contain-item-show pull-left">
						<span class="boder-right">
							<span>
								<?php if ( empty($user["u_address"]) ) {  ?>
									<a href="javascript:;" class="edit-btn">填写居住地</a>
								<?php }else{ 
									echo $user["u_address"];
								} ?>
							</span>
						</span>
						<span class="boder-right">
							<span>
								<?php if ( empty($user["u_industry"]) ) {  ?>
									<a href="javascript:;" class="edit-btn">填写所从事的行业</a>
								<?php }else{ 
									echo $user["u_industry"];
								} ?>
							</span>
						</span>
						<span>
							<?php if ( $user["u_sex"]==0 ) {// 男  ?>
								<i class="fa fa-mars"></i>
							<?php }else{ ?>
								<i class="fa fa-venus"></i>
							<?php } ?>
						</span>
						<?php if ( $isSameUser ) { ?>
						<a href="javascript:;" class="edit-btn hide"><i class="fa fa-edit"></i><span>修改</span></a>
						<?php } ?>
					</div>
					<?php if ( $isSameUser ) { ?>
					<div class="contain-item-edit pull-left hide">
						<input type="text" id="userAddress" value='<?php echo $user["u_address"]; ?>' placeholder="你的地址" />
						<input type="text" id="userIndustry" value='<?php echo $user["u_industry"]; ?>' placeholder="你所从事行业" />
						<select id="userSex">
							<?php if ( $user["u_sex"]==0 ) {// 男  ?>
								<option value ="0" selected>男</option>
						  		<option value ="1">女</option>
							<?php }else{ ?>
								<option value ="0">男</option>
						  		<option value ="1" selected>女</option>
							<?php } ?>
						</select>
						<button class="save-btn">确定</button>
					</div>
					<?php } ?>
				</div>
				<div class="contain-main-item">
					<span class="pull-left"><i class="fa fa-building"></i></span>
					<div class="contain-item-show pull-left">
						<span class="boder-right">
							<?php if ( empty($user["u_company"]) ) {  ?>
								<a href="javascript:;" class="edit-btn">填写所在公司</a>
							<?php }else{ 
								echo $user["u_company"];
							} ?>
						</span>
						<span>
							<?php if ( empty($user["u_occupation"]) ) {  ?>
								<a href="javascript:;" class="edit-btn">填写职位</a>
							<?php }else{ 
								echo $user["u_occupation"];
							} ?>
						</span>
						<?php if ( $isSameUser ) { ?>
						<a href="javascript:;" class="edit-btn hide"><i class="fa fa-edit"></i><span>修改</span></a>
						<?php } ?>
					</div>
					<div class="contain-item-edit pull-left hide">
						<input type="text" id="userCompany" value='<?php echo $user["u_company"]; ?>' placeholder="你的公司" />
						<input type="text" id="userOccupation" value='<?php echo $user["u_occupation"]; ?>' placeholder="你的职业" />
						<button class="save-btn">确定</button>
					</div>
				</div>
				<div class="contain-main-item">
					<span class="pull-left"><i class="fa fa-mortar-board"></i></span>
					<div class="contain-item-show pull-left">
						<span class="boder-right">
							<?php if ( empty($user["u_school"]) ) {  ?>
								<a href="javascript:;" class="edit-btn">填写学校</a>
							<?php }else{ 
								echo $user["u_school"];
							} ?>
						</span>
						<span>
							<?php if ( empty($user["u_major"]) ) {  ?>
								<a href="javascript:;" class="edit-btn">填写专业</a>
							<?php }else{ 
								echo $user["u_major"];
							} ?>
						</span>
						<?php if ( $isSameUser ) { ?>
						<a href="javascript:;" class="edit-btn hide"><i class="fa fa-edit"></i><span>修改</span></a>
						<?php } ?>
					</div>
					<?php if ( $isSameUser ) { ?>
					<div class="contain-item-edit pull-left hide">
						<input type="text" id="userSchool" value='<?php echo $user["u_school"]; ?>' placeholder="你的学校" />
						<input type="text" id="userMajor" value='<?php echo $user["u_major"]; ?>' placeholder="你的专业" />
						<button class="save-btn">确定</button>
					</div>
					<?php } ?>
				</div>
				<div class="contain-main-item">
					<span class="pull-left"><i class="fa fa-hand-o-right"></i></span>
					<div class="contain-item-show pull-left">
						<span>
							<?php if ( empty($user["u_talk"]) ) {  ?>
								<a href="javascript:;" class="edit-btn">你还想说点什么</a>
							<?php }else{ 
								echo $user["u_talk"];
							} ?>
						</span>
						<?php if ( $isSameUser ) { ?>
						<a href="javascript:;" class="edit-btn hide"><i class="fa fa-edit"></i><span>修改</span></a>
						<?php } ?>
					</div>
					<?php if ( $isSameUser ) { ?>
					<div class="contain-item-edit pull-left hide">
						<input type="text" id="userTalk" value='<?php echo $user["u_talk"]; ?>' placeholder="你还想说些什么" />
						<button class="save-btn">确定</button>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="clear-fix"><!-- 清除浮动 --></div>
		<!-- 点击可以查看下面的具体内容 -->
		<div class="contain-nav pull-left">
			<ul>
				<li class="active" href="#selfHome"><i class="fa fa-home"></i></li>
				<li href="#selfFabu">发布<span>&nbsp;<?php echo count($fabuMsg); ?></span><!-- 自己发布的新闻 --></li>
				<li href="#selfPinglun">评论<span>&nbsp;<?php echo count($pinglunMsg); ?></span><!-- 自己评论的新闻 --></li>
				<li href="#selfShoucang">收藏<span>&nbsp;0</span><!-- 自己评论的收藏 --></li>
			</ul>
		</div>

		<div class="clear-fix"><!-- 清除浮动 --></div>
		<div class="news-contain" id="selfFabu">
			<h3>发布的新闻 <a href=""><i class="fa fa-chevron-right pull-right"></i></a></h3>
			<?php foreach ($fabuMsg as $row) { ?>
				<div class="news-contain-main">
					<?php $fabuCount = $row ->fabuCount;// 发布的新闻被评论的人数 ?>
					<div class="news-contain-comment">
						<b><?php echo $fabuCount["commentCount"]; ?></b><br/>
						<span>评论</span>
					</div>
					<div class="news-contaiin-title">
						<a href="<?php echo base_url().'index.php/manage/showNews/'.$row ->a_id ?>"
						 target="_blank" data-id="<?php echo $row ->a_id ?>">
							<?php echo $row ->a_name; ?>
						</a>
						<?php 
							$a_content = $row ->a_content;
							$exp = '/<[^a][^<>]*>/';// 所有非a链接的文字
							$showStr = preg_replace($exp, "", $a_content);
							if ( mb_strlen($showStr) > 43 ) {
								$showStr = mb_substr($showStr, 0, 46, "utf-8") . "......";
							}
						 ?>
						<p><?php echo $showStr; ?></p>
					</div>
				</div>
			<?php } ?>
		</div>
		<div class="news-contain" id="selfPinglun">
			<h3>被评论的新闻</h3>
			<div class="news-contain-main no-border-top">
				<?php foreach ($pinglunMsg as $plRow) { ?>
				<div class="news-contain-who">
					<span><?php echo $plRow ->u_name; ?>评论了该新闻</span>
					<?php 
						$now = time();
						$timeDiff = $now - $plRow->a_time;

						$timeDiff = $timeDiff / 60;// 分钟
						if ( $timeDiff >= 60 && $timeDiff < 1440 ) {// 小于一天
							$timeDiff = $timeDiff / 60;
							$timeDiff = floor($timeDiff) . "小时";
						}else if( $timeDiff >= 1440 && $timeDiff < 43200 ){
							$timeDiff = $timeDiff / 1440;
							$timeDiff = floor($timeDiff) . "天";
						}else if( $timeDiff >= 43200 && $timeDiff < 525600 ){
							$timeDiff = $timeDiff / 43200;
							$timeDiff = $timeDiff / 30;
							$timeDiff = floor($timeDiff) . "月";
						}else{// 小于一个小时 即60min
							$timeDiff = floor($timeDiff) . "分钟";
						}
					?>
					<span class="pull-right"><?php echo $timeDiff; ?>前</span>
				</div>
				<div class="news-contaiin-title margin-left">
					<a href="<?php echo base_url().'index.php/manage/showNews/'.$plRow ->a_id ?>"
					 target="_blank" data-id="<?php echo $plRow ->a_id ?>">
						<?php echo $plRow ->a_name; ?>
					</a>
				</div>
				<div class="hr-border"></div>
				<?php } ?>
			</div>
		</div>
		<div class="news-contain" id="selfShoucang">
			<h3>你自己收藏的新闻</h3>
			<div class="news-contain-main">
				<div class="news-contaiin-title margin-left">
					<a href="">这是新闻标题</a>
					<p>新闻前200字...</p>
				</div>
			</div>
		</div>
	</div>
	<div class="manage-contain-right pull-right">
		<div class="new-label">
			<!-- 你收藏别人的表签 -->
			<div class="news-label-keep pull-left">
				<span>收藏了</span><br/>
				<b>8</b><span>个</span><br/>
				<span>标签</span>
			</div>
			<!-- 别人收藏了多少你的标签 -->
			<div class="news-label-keep pull-right news-lebal-left-border">
				<span>收藏了</span><br/>
				<b>9</b><span>个</span><br/>
				<span>标签</span>
			</div>
		</div>
		<div class="footer-copyright">
			<ul>
				<li><a href="http://www.scuec.edu.cn/" target="_blank">中南民族大学</a></li>
				<li><a href="<?php echo base_url().'index.php/login/personShow/hhj' ?>" target="_blank">黄会杰</a></li>
				<li><a href="" target="_blank">建议反馈</a></li>
				<li><a href="" target="_blank">商务合作&copy;2016新闻</a></li>
			</ul>
		</div>
	</div>
</div>

<?php if ( isset($session)) {// 判断是否登录 如果没有登录那么直接不加载该编辑框 ?>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>static/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>static/ueditor/editor_api.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>static/ueditor/lang/zh-cn/zh-cn.js"></script>
<div class="ask-news-edit hide">
	<div class="bg-opacity"></div>
	<div class="edit-news-main">
		<div class="edit-news-head">
			<h2>编辑新闻 <i class="fa fa-close pull-right"></i></h2>
		</div>
		<form id="editForm" method="post" action="<?php echo base_url() ?>index.php/manage/saveNews">
	        <div class="news-editor-title">
	        	<input type="text" name="newsTitle" id="newsTitle" placeholder="新闻标题" />
	        </div>
	        <script type="text/plain" id="newsContainEdit" name="newsContainEdit">
	            <p>这是新闻具体内容</p>
	        </script>
	        <div class="news-editor-title">
	        	<input type="text" name="newsLabel" id="newsLabel" placeholder="新闻标签" />
	        	<div class="news-label-return-list">
	        		<ul>
	        		</ul>
	        	</div>
	        </div>
	        <div class="edit-contain-btn">
	        	<input type="submit" value="提交" />
	        	<input type="reset" class="reset-btn" value="取消" />
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