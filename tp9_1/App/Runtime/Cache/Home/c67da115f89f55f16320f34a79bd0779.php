<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=0.6,  minimum-scale=0.6, maximum-scale=0.6,user-scalable=0">
<title>证件绑定</title>
<link rel="stylesheet" type="text/css" href="/project/tp9_1/Public/Home/css/weui.min.css"/>
<link rel="stylesheet" type="text/css" href="/project/tp9_1/Public/Home/css/binding.css"/>
<link rel="stylesheet" type="text/css" href="/project/tp9_1/Public/Home/css/common.css"/>
</head>
<body>
<div class="top">
	<a class="return" href="#"></a>
	<p>
		<img src="/project/tp9_1/Public/Home/images/top_05.png"/>
		证件绑定
		<img src="/project/tp9_1/Public/Home/images/top_07.png"/>
	</p>
	<a class="menu" href=""></a>
</div>
<div id="toast" style="display:none;">
	<div class="weui_dialog_alert">
	    <div class="weui_mask"></div>
	    <div class="weui_dialog">
	        <div class="weui_dialog_hd"><strong class="weui_dialog_title" id="msn"></strong></div>
	        <div class="weui_dialog_ft">
	            <a href="#" class="weui_btn_dialog primary" onClick="closewin()">确定</a>
	        </div>
	    </div>
	</div>
</div>  
<div class="form">
	<form action="<?php echo U('binding/binding_add');?>" method="post"  enctype="multipart/form-data" onsubmit="return testContent()">
		<input type="hidden" name="openid" value="<?php echo ($user_info["openid"]); ?>">
		<input type="hidden" name="headimgurl" value="<?php echo ($user_info["headimgurl"]); ?>">
		<div class="alert">请填写信息（仅限山西大学学生）</div>
		<div class="input">
			<img src="/project/tp9_1/Public/Home/images/binding_24.png"/>
			<span>
				学号
			</span>
			<input class="in" type="text" name="stunumber" maxLength="10" id="stunumber"placeholder="请输入您的学号" value="" />
		</div>
		<div class="input">
			<img src="/project/tp9_1/Public/Home/images/binding_29.png"/>
			<span>
				邮箱
			</span>
			<input class="in" type="email" placeholder="请输入邮箱" name="email" id="email"value=""  />
		</div>
		<div class="input">
			<img src="/project/tp9_1/Public/Home/images/binding_31.png"/>
			<span>
				手机
			</span>
			<input class="in" type="text" placeholder="请输入手机号码" value="" name="tels" maxLength="11" id="tels" />
		</div>
		<input type="submit" name="into_mail" value="提交绑定"/>
	</form>
</div>
       
<div class="footer">
	@2016 山西大学就业指导中心 版权所有
</div>
</div>
<script type="text/javascript">
function testContent(){
	if(document.getElementById('stunumber').value==''){
	   document.getElementById('toast').style.display='';
	   document.getElementById('msn').innerHTML='学号不能为空';
	   return false;
	}
	if(document.getElementById('tels').value==''){
	   document.getElementById('toast').style.display='';
	   document.getElementById('msn').innerHTML='手机号不能为空';
	   return false;
	}
	if(!/^[1][358][0-9]{9}$/gi.test(document.getElementById('tels').value)){
	   document.getElementById('toast').style.display='';
	   document.getElementById('msn').innerHTML='手机号格式不正确';
	   return false;
	}
	if(document.getElementById('email').value==''){
	   document.getElementById('toast').style.display='';
	   document.getElementById('msn').innerHTML='邮箱不能为空';
	   return false;
	}
	if(!/^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/gi.test(document.getElementById('email').value)){
	   document.getElementById('toast').style.display='';
	   document.getElementById('msn').innerHTML='邮箱格式不正确';
	   return false;
	}
}
function closewin(){
	document.getElementById('toast').style.display='none';
}

</script>
</body>
</html>