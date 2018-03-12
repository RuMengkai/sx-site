<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8"/>
<meta http-equiv="Cache-control" content="no-cache" />
<meta name="viewport" content="width=device-width,initial-scale=0.6, minimum-scale=0.6,maximum-scale=0.6"/>
<meta name="MobileOptimized" content="240"/>
<meta name="Iphone-content" content="320"/>
<meta name="format-detection" content="telephone=no" />
<title>课程列表</title>
<link rel='stylesheet' type='text/css' href='/tp9_1/Public/Home/css/index.css'>
<link rel='stylesheet' type='text/css' href='/tp9_1/Public/Home/css/common.css'>
<!--<script src="/tp9_1/Public/Home/js/jquery-1.9.1.js" type="text/javascript"></script>-->
</head>

<body>
	<div class="top">
		<a class="return" href="#"></a>
		<p>
			<img src="/tp9_1/Public/Home/images/top_05.png"/>
			课程列表
			<img src="/tp9_1/Public/Home/images/top_07.png"/>
		</p>
		<a class="menu" href=""></a>
	</div>
	<div class="title">
		<img src="/tp9_1/Public/Home/images/index_15.png"/>
		<span>课程</span>
	</div>
	<div class="classlist">
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><ul>
			<a href="<?php echo U('mobile/signPass');?>?id=<?php echo ($val["id"]); ?>">
				<img class="img1" src="/tp9_1/Public/Home/images/index_19.png"/>
				<p><?php echo ($val["title"]); ?></p>
				<ul>
					<li>限定<?php echo ($val["xdnum"]); ?>人</li>
					<li class="xian">|</li>
					<li>已报<?php echo ($val["ybnum"]); ?>人</li>
					<li class="xian">|</li>
					<li><?php echo ($val["ktime"]); ?></li>
				</ul>
				<img class="img2" src="/tp9_1/Public/Home/images/index_21.png"/>
			</a>
		</ul><?php endforeach; endif; else: echo "" ;endif; ?>
	</div>
<div class="footer">
&copy;2016 山西大学就业指导中心 版权所有
</div>
</body>
</html>