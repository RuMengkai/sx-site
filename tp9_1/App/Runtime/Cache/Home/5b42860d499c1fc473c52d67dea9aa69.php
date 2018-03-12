<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=0.5,user-scalable=0">
<title>证件绑定</title>
<link rel="stylesheet" type="text/css" href="/project/tp9_1/Public/Home/css/binding.css"/>
<link rel="stylesheet" type="text/css" href="/project/tp9_1/Public/Home/css/common.css"/>
</head>
<body>
	<div class="top">
		<a class="return" href="#"></a>
		<p>
			<img src="/project/tp9_1/Public/Home/images/top_05.png"/>
			绑定成功
			<img src="/project/tp9_1/Public/Home/images/top_07.png"/>
		</p>
		<a class="menu" href=""></a>
	</div>
	<div class="content">
		<img src="/project/tp9_1/Public/Home/images/success_05.jpg"/>
		<p class="p1">您已成功绑定</p>
		<p class="p2">内容详情，可根据实际需要安排</p>
		<a class="sure" href="<?php echo U('mobile/index');?>?uid=14&classes_id=2">确定</a>
		<a class="cancel" href="<?php echo U('binding/rebinding');?>" onclick="window.close();">重新绑定</a>
	</div>
</body>
</html>