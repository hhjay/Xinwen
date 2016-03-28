<script type="text/javascript" src="<?php echo base_url(); ?>static/js/jquery-1.12.2.js"></script>
<script src="http://crypto-js.googlecode.com/svn/tags/3.1/build/rollups/aes.js"></script>
<script>
   
</script>



<script type="text/javascript" src="<?php echo base_url(); ?>static/js/login.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/login.css" />
<div class="head-bg">

<!-- 
<script type="text/javascript" src="http://requirejs.org/docs/release/2.1.11/comments/require.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>static/js/crypto-js.js"></script>


 -->
	<div class="head-main">
		<div class="head-main-logo">logo</div>
		<div class="head-main-contain">
			<div class="head-contain-ad">
				<!-- 这里是一张图片 -->
				<a href="<?php echo base_url(); ?>" target="_blank">
					<img src="<?php echo base_url(); ?>static/img/ad.jpg" alt="广告位" title="广告位招租" />
				</a>
			</div>
			<div class="head-contain-login">
				<ul>
					<li class="active" href="login">账号登录</li>
					<li href="register">新增管理员</li>
				</ul>
				<div class="head-login-tab">
					<div class="head-tab active" id="login">
						<!-- action="<?php echo base_url(); ?>login.php/loginDeal" -->
						<form  method="post">
							<div class="login-input">
								<span></span>
								<input type="text" name="adminUsername" id="adminUsername" placeholder="邮箱/手机号/账号" required />
							</div>
							<div class="login-input">
								<span class="password-icon"></span>
								<input type="password" name="adminPassword" id="adminPassword" placeholder="请输入密码" required />
							</div>
							<div class="login-accept">
								<div class="img-check">
									<img src="<?php echo site_url('/login/imgShow') ?>" onClick="this.src='<?php echo site_url('/login/imgShow?nocache=') ?>'+ Math.random()" />
								</div>
								<input type="text" name="imgCheckStr" id="imgCheckStr" class="img-input" placeholder="验证码" required />
							</div>
							<!-- margin-top-20px -->
							<div class="login-input">
								<input type="button" class="btn-submit" id="loginBtn" value="登录" />
							</div>
						</form>
					</div>
					<div class="head-tab" id="register">
						<form action="<?php echo base_url(); ?>login.php/registerDeal" method="post">
							<div class="login-input">
								<span></span>
								<input type="text" name="registerUsername" id="registerUsername" placeholder="姓名" required />
							</div>
							<div class="login-input">
								<span></span>
								<input type="text" name="registerUsername" id="registerUsername" placeholder="输入你想要注册的账号/邮箱/手机号" required />
							</div>
							<div class="login-input">
								<span class="password-icon"></span>
								<input type="password" name="registerPassword" id="registerPassword" placeholder="请输入密码" required />
							</div>
							<div class="login-accept reg-accept">
								<div class="img-check">
									<img src="<?php base_url() ?>index.php/login/imgShow" />
								</div>
								<input type="text" name="imgCheckStr" id="imgCheckStr" class="img-input" placeholder="验证码" required />
							</div>
							<!-- margin-top-20px -->
							<div class="login-input">
								<input type="submit" class="btn-submit" nama="sub" value="新增管理员" />
							</div>
						</form>
					</div>
				</div>		
				<!-- 登录或者注册 tab页 -->
			</div>
		</div>
	</div>
</div>