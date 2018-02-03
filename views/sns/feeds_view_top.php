<div class="toplie">
	<img class="imgbie" src="<?=getavater($snsUser)?>">
	<p class="namebie"><?=$snsUser['realname']?>的空间</p>
	<span class="dtwzlls"><?=$snsUser['feedsnum']?></span>
	<span class="dtwzll">个动态</span>
	<span class="dtwzlls"><?=$snsUser['blogsnum']?></span>
	<span class="dtwzll">篇文章</span>
	<span class="dtwzlls"><?=$snsUser['viewsnum']?></span>
	<span class="dtwzll">次浏览</span>
	
	<?php if($snsUser['uid'] != $user['uid']){ 
		
	?>
		<?php if($snsUser['followed']){ ?>
			<?php if($snsUser['allfollowed']){ ?>
			<div class="hwgz">	
				<a href="javascript:;" data="3835604" class=" dofollow followed">互为关注</a>
			</div>
			<?php }else{ ?>
			<div class="followed_box">	
				<a href="javascript:;" data="3835604" class=" dofollow followed">已关注</a>
			</div>	
			<?php } ?>
		<?php }else{ ?>
			<div class="jwhy">
				<a href="javascript:;" data="<?=$snsUser['uid']?>" class=" dofollow _addfollow">添加关注</a>
			</div>
		<?php } ?>
		
		
	
	<div class="rgygs showfollow" style="height: 60px;">
		<?php if($snsUser['followed']){ ?>
		<a href="javascript:;" class="quxiao qxguanzhu">取消关注</a>
		<?php }else{ ?>
		<a href="javascript:;" class="quxiao" onclick="$('._addfollow').trigger('click');" style="display:block">添加关注</a>
		<?php } ?>
		<?php if($snsUser['is_black']){ ?>
		<a href="javascript:;" class="quxiao cancelblacklist">移除黑名单</a>
		<?php }else{ ?>
		<a href="javascript:;" class="quxiao addblacklist">添加黑名单</a>
		<?php } ?>
	</div>
	<?php } ?>
</div>