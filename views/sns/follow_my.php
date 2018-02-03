<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/sns/css/ftroomv3.css?v=20171025001" />
		<script type="text/javascript" src="http://static.ebanhui.com/snsv2/js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/snsv2/js/common.sns.js?v=20171027001"></script>
		<title></title>
	</head>
	<body>
		<div class="weaktils">
			<ul>
				<li class=""><a href="/sns/feeds.html"><span>新鲜事</span></a></li>
				<li class=""><a href="/sns/photo.html"><span>照片(<em class="reds"><?=$snsUser['photo_count']?></em>)</span></a></li>
				<li class=""><a href="/sns/blog.html"><span>日志(<em class="reds"><?=$snsUser['blogsnum']?></em>)</span></a></li>
				<li><a href="/sns/blacklist.html"><span>我的</span></a></li>
	    		<li class="" style="float: right;"><a href="/sns/follow/fans.html"><span>粉丝<em class="ebhlan"> <?=$snsUser['fansnum']?></em></span></a></li>
	            <li class="datek" style="float: right;"><a href="/sns/follow.html"><span>关注<em class="ebhlan"> <?=$snsUser['followsnum']?></em></span></a></li>
			</ul>
		</div>
		<div class="liert">
			<ul>
				<?php if($follows){foreach($follows as $follow){?>
				<li class="gergdty">
				<div class="fewghv">
				
				<?php if(!empty($follow['together'])){?>
				<span href="javascript:;" class="husgfen"></span>
				<?php }?>
				<?php if($snsUser['uid'] != $user['uid']){?>
					<?php if(($user['uid']!=$follow['fuid'])&&$follow['followed']){?>
					<a href="javascript:;"  class="followed" ></a>
					<a href="javascript:;" class="qferut cancel" data="<?=$follow['fuid']?>" type="follow">取消</a>
					<?php }elseif(($user['uid']!=$follow['fuid'])&&($follow['followed']==false)){?>
					<a href="javascript:;" data="<?=$follow['fuid']?>" class="guanzhu" ></a>
					<a href="javascript:;" class="qferut cancel" style="display:none" data="<?=$follow['fuid']?>" type="follow">取消</a>
					<?php }?>
				<?php }else{?>
				<a href="javascript:;" class="qferut cancel" data="<?=$follow['fuid']?>" type="follow">取消</a>
				<?php }?>
				
				<a href="/sns/feeds/<?=$follow['fuid']?>.html" class="regewgr">
				<img style="width:50px;height:50px;" src="<?=getavater($follow,'50_50')?>" />
				</a>
				<p class="<?=($follow['sex']==1)?"nvtud":"lgryd"?>">
				<a href="/sns/feeds/<?=$follow['fuid']?>.html" style="color:#098dcb"><?=!empty($follow['realname'])?$follow['realname']:$follow['username']?></a></p>
				<p class="sfejt">
				关注 <span class="fetyrt" style="margin-right:20px;"><?=!empty($follow['followsnum'])?$follow['followsnum']:"0"?></span>
				粉丝 <span class="fetyrt"><?=!empty($follow['fansnum'])?$follow['fansnum']:"0"?></span></p>
				<div class="fwegt">
				简介：<?=empty($follow['profile'])?"太懒了,还没有填写个人简介":$follow['profile']?>
				</div>
				</div>
				</li>
				<?php }}else{?>
				<li style="text-align:center;margin-top:50px"><div class="nofollow"></div></li>
				<?php }?>
			</ul>
			<div class="pages">
			<?=@$pagebar?>
			</div>
		</div>
	</body>
</html>
