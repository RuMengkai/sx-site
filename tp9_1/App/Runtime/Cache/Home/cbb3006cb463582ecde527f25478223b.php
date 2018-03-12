<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8"/>
<meta http-equiv="Cache-control" content="no-cache" />
<meta name="viewport" content="width=device-width, initial-scale=0.6, minimum-scale=0.6, maximum-scale=0.6"/>
<meta name="MobileOptimized" content="240"/>
<meta name="Iphone-content" content="320"/>
<meta name="format-detection" content="telephone=no" />
<title>通过审核名单</title>
<link rel="stylesheet" type="text/css" href="/tp9_1/Public/Home/css/common.css"/>
<link rel="stylesheet" type="text/css" href="/tp9_1/Public/Home/css/signPass.css"/>

</head>

<body style="position:relative">
<div class="top">
	<a class="return" href="<?php echo U('mobile/result');?>?uid=<?php echo ($uid); ?>"></a>
	<p>
		<img src="/tp9_1/Public/Home/images/top_05.png"/>
		审核通过名单
		<img src="/tp9_1/Public/Home/images/top_07.png"/>
	</p>
	<a class="menu" href="#"></a>
</div>

	
<p class="title">&nbsp;&nbsp;请以下审核通过的同学按时参加。</p>
<div class="applylist">
	<ul>
   		<?php if($count != 0): if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li>
				<img src="/tp9_1/Public/Home/images/view_41.png"/>
				<span class="name">
					<?php echo ($val["name"]); ?>
				</span>
				<span><?php echo ($val["stunumber"]); ?></span>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
	    <?php else: ?>
	        <li>正在审核，请耐心等待。。。</li><?php endif; ?>
	</ul>
</div>
<div class="footer">
	&copy;2016 山西大学就业指导中心 版权所有
</div>
</body>
</html>