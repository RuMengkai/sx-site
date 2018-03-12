<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=0.6,user-scalable=0">
<title>提交信息</title>
<link rel="stylesheet" type="text/css" href="/tp9_1/Public/Home/css/weui.min.css"/>
<link rel="stylesheet" type="text/css" href="/tp9_1/Public/Home/css/binding.css"/>
<link rel="stylesheet" type="text/css" href="/tp9_1/Public/Home/css/common.css"/>
</head>

<body>
<div class="top">
	<a class="return" href="<?php echo U('mobile/view');?>?id=<?php echo ($id); ?>"></a>
	<p>
		<img src="/tp9_1/Public/Home/images/top_05.png"/>
		提交信息
		<img src="/tp9_1/Public/Home/images/top_07.png"/>
	</p>
	<a class="menu" href=""></a>
</div>

<div id="toast" style="display:none;">
<div class="weui_dialog_alert">
    <div class="weui_mask"></div>
    <div  class="weui_dialog">
        <div class="weui_dialog_hd"><strong style="font-size: 30px;" class="weui_dialog_title" id="msn"></strong></div>
        <div class="weui_dialog_ft">
            <a href="#" style="font-size: 30px;"class="weui_btn_dialog primary" onClick="closewin()">确定</a>
        </div>
    </div>
</div>
</div>  
<div class="form">
	<form action="<?php echo U('mobile/add');?>" method="post"  enctype="multipart/form-data" onsubmit="return testContent()">
		<div class="alert">报名信息</div>
		<div class="input">
			<img src="/tp9_1/Public/Home/images/binding_24.png"/>
			<span>
				学号
			</span>
			
			<input class="in" type="text" placeholder="请输入您的学号" name="stunumber" id="stunumber" value="<?php echo ($list[0]['stunumber']); ?>" />
	   		
		</div>
		<div class="input">
			<img src="/tp9_1/Public/Home/images/binding_31.png"/>
			<span>
				手机
			</span>
			<input class="in" type="text"placeholder="请输入手机号码" name="tels" maxLength="11" id="tels" value="<?php echo ($list[0]['phone']); ?>" />
		</div>
		<input type="submit" name="into_mail" value="确认提交"/>
	</form>
</div>
<div class="footer">
&copy;2016 山西大学就业指导中心 版权所有
</div>
</div>
<script type="text/javascript">
function testContent(){
	if(!/^[1][34578][0-9]{9}$/gi.test(document.getElementById('tels').value)){
		document.getElementById('toast').style.display='';
	   	document.getElementById('msn').innerHTML='手机号格式不正确';
		return false;
	}
}
function closewin(){
	document.getElementById('toast').style.display='none';
}
</script>

</body>
</html>