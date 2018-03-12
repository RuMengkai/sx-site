<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8"/>
<meta http-equiv="Cache-control" content="no-cache" />
<meta name="viewport" content="width=device-width, initial-scale=0.6, minimum-scale=0.6, maximum-scale=0.6"/>
<meta name="MobileOptimized" content="240"/>
<meta name="Iphone-content" content="320"/>
<meta name="format-detection" content="telephone=no" />
<title><?php echo ($classInfo["title"]); ?></title>
<link rel="stylesheet" type="text/css" href="/tp9_1/Public/Home/css/common.css"/>
<link rel="stylesheet" type="text/css" href="/tp9_1/Public/Home/css/view.css"/>

</head>

<body style="position:relative">
<div class="top">
	<a class="return" href="<?php echo U('mobile/index');?>?uid=<?php echo ($uid); ?>"></a>
	<p>
		<img src="/tp9_1/Public/Home/images/top_05.png"/>
		课程内容
		<img src="/tp9_1/Public/Home/images/top_07.png"/>
	</p>
	<a class="menu" href="#"></a>
</div>
<div class="classinfo">
	<div class="p">
		<div class="fen"></div>
		<?php echo ($classInfo["title"]); ?>
	</div>
	<ul>
		<li>
			<p><?php echo ($classInfo["xdnum"]); ?></p>
			<p>限定名额</p>
		</li>
		<li>
			<p>
				<?php if($classInfo[xdnum]-$classInfo[ybnum] > 0): echo ($classInfo[xdnum]-$classInfo[ybnum]); ?>
				<?php else: ?>
				0<?php endif; ?>
			</p>
			<p>剩余名额</p>
		</li>
		<li>
			<p><?php echo ($classInfo[ybnum]); ?></p>
			<p>已报名额</p>
		</li>
	</ul>
</div>
<div class="content">
	<!--<h3 class="">主题：<?php echo ($classInfo["title"]); ?></h3>-->
	<p class=""><?php echo ($classInfo[content]); ?></p>
	<li>时间：<?php echo ($ktime); ?></li>
	<li>地址：<?php echo ($classInfo["address"]); ?></li>
</div>
<div class="submit">
    <?php if($ktimes >= $time): if($classInfo[ybnum] < $classInfo[xdnum]): ?><a class="button" href="<?php echo U('mobile/add');?>" >我要报名</a>
   		<?php else: ?>
		    <a class="button" href="<?php echo U('mobile/add');?>" >名额已满，进入备选</a><?php endif; ?>
    <?php else: ?>
   		<a class="button stop" href="#" >报名截止</a><?php endif; ?>
</div>
<p>&nbsp;&nbsp;已报名：</p>
<div class="applylist">
	
	<ul>
   		<?php if($classInfo[ybnum] != 0): if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li>
				<img src="/tp9_1/Public/Home/images/view_41.png"/>
				<span class="name">
					<?php echo ($val["name"]); ?>
				</span>
				<span><?php echo ($val["stunumber"]); ?></span>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
	    	<?php else: ?>
	        	<li>目前还没人报名，</li><?php endif; ?>
	</ul>
</div>
<div class="footer">
	&copy;2016 山西大学就业指导中心 版权所有
</div>
<script type="text/javascript" src="/tp9_1/Public/Home/js/jquery.min.js"></script> 
<script type="text/javascript" src="/tp9_1/Public/Home/js/jquery.downCount.js"></script> 
<script type="text/javascript">
	$('.countdown').downCount({
		date: '<?php echo (date("Y-m-d H:i:s",$classInfo["ktime"])); ?>',
		offset: +8
	}, function () {
		//alert('本期课程已结束!');
	});
	$(document).ready(function (){
		$(".btn_qx").click(function (){
		   window.location.href = '#bml';
		   $(ssuo).addClass("twinkling"); 
		});
	});
	
</script>
</body>
</html>