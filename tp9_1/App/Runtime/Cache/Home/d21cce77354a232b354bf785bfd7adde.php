<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo (C("sitename")); ?> - 用户注册</title>
<!-- Set render engine for 360 browser -->
<meta name="renderer" content="webkit">
<!-- No Baidu Siteapp-->
  <meta http-equiv="Cache-Control" content="no-siteapp"/>
  <link rel="stylesheet" href="/tp9_1/Public/Home/assets/css/amazeui.min.css">
  <link rel="stylesheet" href="/tp9_1/Public/Home/assets/css/app.css">
  <script src="/tp9_1/Public/Home/js/jquery-1.9.1.js"></script>
  <script src="/tp9_1/Public/Home/Layer/layer.js"></script>
<script>
$(function () {
	$('#btn').click(function () {
		var user = $('#user').val();
		var password = $('#password').val();
		var myreg = /^(((13[0-9]{1})|(14[0-9]{1})|(17[0]{1})|(15[0-3]{1})|(15[5-9]{1})|(18[0-9]{1}))+\d{8})$/;
		if (!myreg.test(user)) {
			layer.msg('请输入有效的手机号码');
		}else{
			$.post("<?php echo U('Reg/sms_code');?>", { "user": user,"password": password},function(data){
				//alert(data);
				if(data == 1){
					layer.msg('验证码发送成功');
				}else{
					layer.msg('手机号码或者密码不能为空'); 
				}
			}, "json");
			//layer.msg('验证码发送成功')
			if(user && password ){
				var count = 60;
				var countdown = setInterval(CountDown, 1000);;
				function CountDown() {
					$("#btn").attr("disabled", true);
					$("#btn").val(+ count + " 秒后重新获取");
					if (count == 0) {
						$("#btn").val("获取验证码").removeAttr("disabled");
						clearInterval(countdown);
					}
					count--;
				}
			}
		}


	})

});
</script>
</head>
<body>

<div class="am-reg cl">  
    <h2>会员注册<span><a href="<?php echo U('login/index');?>">已有账号</a>&nbsp;&nbsp;&nbsp;<a href="#">忘记密码?</a></span></h2>

<form name="loginform" id="loginform" method="post" action="<?php echo U('Reg/reg');?>" data-am-validator>

<fieldset>

<div class="am-btn-group doc-js-btn-1" data-am-button>

<label class="am-btn am-btn-primary am-disabled">
    <input type="radio" name="options" value="0" id="option4"> 我属于
  </label>
  
  <label class="am-btn am-btn-primary">
    <input type="radio" name="group_id" value="3" checked> 学员团体
  </label>
  <label class="am-btn am-btn-primary">
    <input type="radio" name="group_id" value="8" > 公司企业
  </label>
  
  <label class="am-btn am-btn-primary">
    <input type="radio" name="group_id" value="9" > 相当老师
  </label>
  
</div>

    <div class="am-input-group">
      <span class="am-input-group-label"><i class="am-icon-user am-icon-fw"></i></span>
      <input type="text" class="am-form-field" id="user" name="user" placeholder="输入手机号码" maxlength="11" required/>
    </div>
    
    <div class="am-input-group">
      <span class="am-input-group-label"><i class="am-icon-lock am-icon-fw"></i></span>
      <input type="password" class="am-form-field" name="password" id="password" placeholder="输入您的密码" required/>
    </div>
    
    <div class="am-input-group am-code">
      <span class="am-input-group-label"><i class="am-icon-lock am-icon-fw"></i></span>
      <input type="text" name="verify" id="code" class="am-form-field" placeholder="输入短信验证码" required/>
      	<div id="am-code_img">
	      <input type="button" id="btn" value="获取验证码" /> 
          	      <img style=" display:none" src="<?php echo U('reg/verify');?>" onclick="this.src = '<?php echo U('reg/verify');?>?'+new Date().getTime()" />

	      </div>
    </div>
    
    <center><input type="submit" class="am-btn am-btn-success am-round" value=" 提交注册 "/></center>
</fieldset>    
</form>

</div>
<footer class="am-footer">
<?php echo (C("footer")); ?>
</footer>
<!--[if (gte IE 9)|!(IE)]><!-->
<script src="/tp9_1/Public/Home/assets/js/jquery.min.js"></script>
<!--<![endif]-->
<!--[if lte IE 8 ]>
<script src="http://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="/tp9_1/Public/Home/assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->
<script src="/tp9_1/Public/Home/assets/js/amazeui.min.js"></script>

</body>
</html>