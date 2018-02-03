<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		
		<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/sns/css/ftroomv3.css?v=20171017001" />
		<script type="text/javascript" src="http://static.ebanhui.com/snsv2/js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/sns/js/showmessage/jquery.showmessage.js"></script>
		<script src="http://static.ebanhui.com/sns/js/artDialog/dialog-min.js"></script>	
		<script type="text/javascript" src="http://static.ebanhui.com/sns/js/lazyload/jquery.lazyload.js"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/snsv2/js/common.sns.js?v=20171025003"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/snsv2/js/photo.js?v=20171027001"></script>
		<title></title>
	</head>
	<body>
		<div id="snsBox" style="overflow: hidden;">
			<?php echo $this->display('sns/feeds_view_top');?>
			<input type="hidden" id = "_curuid" name="curuid" value="<?=$snsUser['uid']?>" />
			<input type="hidden" id= "_loginuid" name="loginuid" value="<?=$user['uid']?>" />
			<input type="hidden" id= "_photonum" name="photonum" value="<?=$snsUser['photo_count']?>" />
			<div class="weaktils">
				<ul>
					<li class=""><a href="/sns/feeds/<?=$snsUser['uid']?>.html"><span>新鲜事</span></a></li>
					<li class="datek"><a href="/sns/photo/<?=$snsUser['uid']?>.html"><span>他的照片</span></a></li>
					<li class=""><a href="/sns/blog/<?=$snsUser['uid']?>.html"><span>他的日志</span></a></li>
				</ul>
			</div>
			<div class="liert" id="liert">
				<div class="image_box">
					<ul class="photolist" id="photolist">
					
					</ul>
				</div>
			</div>
			<div class="weidgjr" id="notice_loading" style="_padding-top:10px;_height:23px;">
				<span class="notice_loading"> <i class="loading_i"></i>正在加载中</span>
			</div>
			<div class="weidgjr" id="data_null" style="_padding-top:10px;_height:23px;">
				<span class="notice_loading">无更多内容</span>
			</div>
		</div>	
	</body>
</html>
