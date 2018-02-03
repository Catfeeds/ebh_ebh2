<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>启动中</title>
	<?php 
		$systemsetting = Ebh::app()->room->getSystemSetting();
	?>
	<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
	<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
	<style>
	.zb_tip{text-align:center;font-size:14px; font-family:Microsoft Yahei,STHeiti,Arial; color:#555;}
	.zb_tip img{ vertical-align:middle; margin-right:8px;}

	</style>
</head>
<body>
<div class="zb_tip"><img src="http://static.ebanhui.com/chatroom/img/xubox_loading2.gif" id="s1" />正在打开直播课堂，请稍后...</div>
<script>
	$(document).ready(function(){
		$("#s1").attr("src","http://static.ebanhui.com/chatroom/img/xubox_loading2.gif?"+Math.random());
		window.location.href = 'ebhlauncher://<?=$key?>';
	});
</script>
</body>
</html>