<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		
		<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/sns/css/ftroomv3.css?v=20171025001" />
		<script type="text/javascript" src="http://static.ebanhui.com/snsv2/js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/snsv2/js/common.sns.js?v=20171027003"></script>
		<title></title>
	</head>
	<body>
		<div class="weaktils">
			<ul>
				<li class=""><a href="/sns/feeds.html"><span>新鲜事</span></a></li>
				<li class=""><a href="/sns/photo.html"><span>照片(<em class="reds"><?=$snsUser['photo_count']?></em>)</span></a></li>
				<li class=""><a href="/sns/blog.html"><span>日志(<em class="reds"><?=$snsUser['blogsnum']?></em>)</span></a></li>
				<li class="datek"><a href="/sns/blacklist.html"><span>我的</span></a></li>
	    		<li class="" style="float: right;"><a href="/sns/follow/fans.html"><span>粉丝<em class="ebhlan"> <?=$snsUser['fansnum']?></em></span></a></li>
	            <li class="" style="float: right;"><a href="/sns/follow.html"><span>关注<em class="ebhlan"> <?=$snsUser['followsnum']?></em></span></a></li>
			</ul>
		</div>
		<div class="liert">
			<div class="dtie">
				<a class="dislas" href="/sns/blacklist.html">黑名单(<span class="reds"><?=$snsUser['blacklist_count']?></span>)</a>
				<a href="/sns/feeds/mypublish.html">我的发表(<span class="reds"><?=$snsUser['feedsnum']?></span>)</a>
			</div>
			<ul>
				<?php if($blacklists){foreach($blacklists as $item){?>
				<li class="gergdty">
				<div class="fewghv">
				<a href="javascript:;" class="qferut cancel" data="<?=$item['touid']?>" type="blackList">解除</a>
				<a href="/sns/feeds/<?=$item['touid']?>.html" class="regewgr">
				<img style="width:50px;height:50px;" src="<?=getavater($item,'50_50')?>" />
				</a>
				<p class="<?=($item['sex']==1)?"nvtud":"lgryd"?>">
				<a href="/sns/feeds/<?=$item['touid']?>.html" style="color:#098dcb"><?=!empty($item['realname'])?$item['realname']:$item['username']?></a></p>
				<p class="sfejt">
				关注 <span class="fetyrt" style="margin-right:20px;"><?=!empty($item['followsnum'])?$item['followsnum']:"0"?></span>
				粉丝 <span class="fetyrt"><?=!empty($item['fansnum'])?$item['fansnum']:"0"?></span></p>
				<div class="fwegt">
				简介：<?=empty($item['profile'])?"太懒了,还没有填写个人简介":$item['profile']?>
				</div>
				</div>
				</li>
				<?php }}else{?>
				<li style="text-align:center;margin-top:50px"><div class="noblacklist"></div></li>
				<?php }?>
			</ul>
			<div class="pages">
			<?=@$pagebar?>
			</div>
		</div>
	</body>
</html>
