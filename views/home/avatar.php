<?php $this->display('home/page_header'); ?>
<script type="text/javascript">
<!--
	function pliushFun(){//刷新
		window.top.location.reload(); 
	}
//-->
</script>
<div class="topbaad">
<div class="user-main clearfix">

	<div class="ter_tit" style="position: relative;">
	当前位置 > 个人信息 > 修改头像
	</div>
	<div class="lefrig" style="background:#fff;<?=(empty($room['iscollege'])||$user['groupid']!=6)?'border:solid 1px #cdcdcd;':''?>margin-top:15px;">
	<?php
	$this->assign('type','setting');
	$this->display('home/simplate_menu');
	?>
	<?php
	$domain=$this->uri->uri_domain();
	$uid=$user['uid'];
	$url=urlencode('/static/flash/xml/photoOnLine.xml');
	$returnurl=urlencode('http://'.$domain.'.ebanhui.com/home/profile/profile.html');
	$resurl=urlencode('/static/flash/avatarRES.swf');
	// $picurl = urlencode('http://'.$domain.'.ebanhui.com/avatar.html?uid='.$uid);
	$picurl = urlencode($picurl);
	if(empty($user['face'])){
		 if($user['sex']==1){
			if($user['groupid']==5){
				$initpicurl=urlencode('http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg');
			}else{
				$initpicurl=urlencode('http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg');
			}
		}else{
			if($user['groupid']==5){
				$initpicurl=urlencode('http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg');
			}else{
				$initpicurl=urlencode('http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg');
			}
		 }
	}else{
		$initpicurl=urlencode($user['face']);
	}
	?>
	<object type="application/x-shockwave-flash" data="/static/flash/photoOnline.swf" width="747"
			height="510" id="blog_index_flash_ff">
			<param name="quality" value="high" />
			<param name="FlashVars" value="url=<?=$url?>&returnurl=<?=$returnurl?>&uid=<?=$uid?>&resurl=<?=$resurl?>&picurl=<?=$picurl?>&initpicurl=<?=$initpicurl?>" />
			<param name="wmode" value="transparent" />
			<param name="menu" value="false">
			<param name="allowScriptAccess" value="sameDomain" />
			<param name="allowFullScreen" value="true" />
			<param name="movie" value="/static/flash/photoOnline.swf" /><!--兼容ie6-->
	</object>
		</div>
	</div>
</div>