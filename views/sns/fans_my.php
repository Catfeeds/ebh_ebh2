<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		
		<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/sns/css/ftroomv3.css?v=20171026001" />
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
	    		<li class="datek" style="float: right;"><a href="/sns/follow/fans.html"><span>粉丝<em class="ebhlan"><?=$snsUser['fansnum']?></em></span></a></li>
	            <li class="" style="float: right;"><a href="/sns/follow.html"><span>关注<em class="ebhlan"> <?=$snsUser['followsnum']?></em></span></a></li>
			</ul>
		</div>
		<div class="liert">
			<ul>
				<?php if($fans){foreach($fans as $fan){?>

				<li class="gergdty">
				<div class="fewghv">
				<?php if($uid>0&&$uid!=$user['uid']){?>
					<?php if($fan['uid']!=$user['uid']){?>	
					<?php if($fan['followed']){?>
					<a class="followed" href="javascript:;"></a>
					<?php }else{?>
					<a class="guanzhu" data="<?=$fan['uid']?>" href="javascript:;"></a>
					<?php }?>
					<?php }?>
				<?php }else{?>
					<?php if(!empty($fan['together'])){?>
					<span href="javascript:;" class="husgfen"></span>
					<?php }else{?>
					<a href="javascript:;" class="guanzhu" data="<?=$fan['uid']?>"></a>
					<?php }?>
					<a href="javascript:;" class="qferut cancel" data="<?=$fan['uid']?>" type="fans">移除</a>
				<?php }?>

				<a href="/sns/feeds/<?=$fan['uid']?>.html" class="regewgr">
				<img style="width:50px;height:50px;" src="<?=getavater($fan,'50_50')?>" />
				</a>
				<p class="<?=($fan['sex']==1)?"nvtud":"lgryd"?>">
				<a href="/sns/feeds/<?=$fan['uid']?>.html" style="color:#098dcb"><?=!empty($fan['realname'])?$fan['realname']:$fan['username']?></a></p>
				<p class="sfejt">
				关注 <span class="fetyrt" style="margin-right:20px;"><?=!empty($fan['followsnum'])?$fan['followsnum']:"0"?></span>
				粉丝 <span class="fetyrt"><?=!empty($fan['fansnum'])?$fan['fansnum']:"0"?></span></p>
				<div class="fwegt">
				简介：<?=empty($fan['profile'])?"太懒了,还没有填写个人简介":$fan['profile']?>
				</div>
				</div>
				</li>
				<?php }}else{?>
				<li style="text-align:center;margin-top:50px"><div <?if($uid>0&&$uid!=$user['uid']){?> class="noofans" <? } else{ ?> class="nofans" <? } ?>></div></li>
				<?php }?>
			</ul>
			<div class="pages">
			<?=@$pagebar?>
			</div>
		</div>
	</body>
</html>
