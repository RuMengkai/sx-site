<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo (C("sitename")); ?> - 用户登录</title>
<!-- Set render engine for 360 browser -->
<meta name="renderer" content="webkit">
<!-- No Baidu Siteapp-->
  <meta http-equiv="Cache-Control" content="no-siteapp"/>
  <link rel="stylesheet" href="/tp9_1/Public/Home/assets/css/amazeui.min.css">
  <link rel="stylesheet" href="/tp9_1/Public/Home/assets/css/app.css">
</head>
<body>

<div class="am-login">
    <h2>山西大学就业指导中心<!--<span><a href="<?php echo U('Reg/reg');?>">没有账号?</a>&nbsp;&nbsp;&nbsp;<a href="#" onclick="ale()">忘记密码?</a></span>--></h2>
    <form name="loginform" id="loginform" method="post" action="<?php echo U('login/login');?>" >
<fieldset>

    <div class="am-input-group">
      <span class="am-input-group-label"><i class="am-icon-user am-icon-fw"></i></span>
      <input type="text" name="user" id="user" class="am-form-field" id="doc-vld-name-2" maxlength="20" placeholder="输入您的账户名" required/>
    </div>
    
    <div class="am-input-group">
      <span class="am-input-group-label"><i class="am-icon-lock am-icon-fw"></i></span>
      <input type="password" name="password" id="password" class="am-form-field" placeholder="请输入您的密码" required/>
    </div>
    
        <div class="am-input-group am-code">
      <span class="am-input-group-label"><i class="am-icon-lock am-icon-fw"></i></span>
      <input type="text" name="verify" id="code" class="am-form-field" placeholder="输入右边验证码" required/>
      	<div id="am-code_img">
	      <img style=" cursor:pointer;" title="点我刷新哦！" src="<?php echo U('login/verify');?>" onclick="this.src = '<?php echo U('login/verify');?>?'+new Date().getTime()" />
	    </div>
    </div>

    <center><input type="submit" name="submit"  class="am-btn am-btn-success am-round" value=" 登 录 "/></center>
    
    <label class="inline">
															<input type="checkbox" class="ace" name="remember"/>
															<span class="lbl"> 记住我</span>
														</label>
</fieldset>    
</form>
</div>
<footer class="am-footer">  
<?php echo (C("footer")); ?>
</footer>

</body>
</html>