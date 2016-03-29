<script type="text/javascript" src="<?php echo base_url(); ?>static/js/lib/jquery-1.12.2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/lib/crypto-js.aes.3.1.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>static/js/login.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/login.css" />
<div class="head-bg">
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
					<li href="login">账号登录</li>
					<li class="active" href="register">新增管理员</li>
				</ul>
				<div class="head-login-tab">
					<div class="head-tab" id="login">
						<!-- action="<?php echo base_url(); ?>login.php/loginDeal" -->
						<form  method="post" name="loginForm">
							<div class="login-input">
								<span></span>
								<input type="text" name="adminUsername" id="adminUsername" placeholder="手机号/账号" required />
							</div>
							<div class="login-input">
								<span class="password-icon"></span>
								<input type="password" name="adminPassword" id="adminPassword" placeholder="请输入密码" required />
							</div>
							<div class="login-accept">
								<div class="img-check">
									<img src="<?php echo site_url('/login/imgLoginShow') ?>" onClick="this.src='<?php echo site_url('/login/imgLoginShow?nocache=') ?>'+ Math.random()" />
								</div>
								<input type="text" name="imgCheckStr" id="imgCheckStr" class="img-input" placeholder="验证码" required />
							</div>
							<!-- margin-top-20px -->
							<div class="login-input">
								<button class="btn-submit" id="loginBtn">登录</button>
							</div>
						</form>
					</div>
					<!-- action="<?php echo base_url(); ?>login.php/registerDeal" -->
					<div class="head-tab active" id="register">
						<form method="post" name="registerForm">
							<div class="login-input">
								<span></span>
								<input type="text" name="registerUsername" id="registerUsername" placeholder="姓名" required />
							</div>
							<div class="login-input">
								<span></span>
								<input type="text" name="registerAccount" id="registerAccount" placeholder="输入你想要注册的账号/手机号" required />
							</div>
							<div class="login-input">
								<span class="password-icon"></span>
								<input type="password" name="registerPassword" id="registerPassword" placeholder="请输入密码" required />
							</div>
							<div class="login-accept reg-accept">
								<div class="img-check">
									<img src="<?php echo site_url('/login/imgRegisterShow') ?>" onClick="this.src='<?php echo site_url('/login/imgRegisterShow?nocache=') ?>'+ Math.random()" />
								</div>
								<input type="text" name="registerImgStr" id="registerImgStr" class="img-input" placeholder="验证码" required />
							</div>
							<!-- margin-top-20px -->
							<div class="login-input">
								<button class="btn-submit" id="registerBtn" nama="sub">新增管理员</button>
							</div>
						</form>
					</div>
				</div>		
				<!-- 登录或者注册 tab页 -->
			</div>
		</div>
	</div>
</div>