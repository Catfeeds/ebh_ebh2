<?php $this->display('myroom/page_header'); ?>
<script type="text/javascript">
<!--
	function pliushFun(){//刷新
		location.href=location.href;
	}
//-->
</script>
<div class="topbaad">
<div class="user-main clearfix">

	<div class="ter_tit" style="width:760px;position: relative;">
	当前位置 > 个人信息 > 修改头像
	</div>
	<div class="lefrig" style="background:#fff;border:solid 1px #cdcdcd;margin-top:15px;">
	<?php
	$this->assign('type','setting');
	$this->display('member/simplate_menu');
	?>
	<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
	<?php
	
	$domain=$this->uri->uri_domain();
	$uid=$user['uid'];
	$url=urlencode('/static/flash/xml/photoOnLine.xml');
	$returnurl=urlencode('http://'.$domain.'.ebanhui.com/myroom/settings/profile.html');
	$resurl=urlencode('/static/flash/avatarRES.swf');
	$picurl = urlencode('http://'.$domain.'.ebanhui.com/avatar.html?uid='.$uid);
	?>
	<object type="application/x-shockwave-flash" data="/static/flash/photoOnline.swf" width="747"
			height="510" id="blog_index_flash_ff">
			<param name="quality" value="high" />
			<param name="FlashVars" value="url=<?=$url?>&returnurl=<?=$returnurl?>&uid=<?=$uid?>&resurl=<?=$resurl?>&picurl=<?=$picurl?>" />
			<param name="wmode" value="transparent" />
			<param name="menu" value="false">
			<param name="allowScriptAccess" value="sameDomain" />
			<param name="allowFullScreen" value="true" />
			<param name="movie" value="/static/flash/photoOnline.swf" /><!--兼容ie6-->
	</object>

	<span style="margin-left:250px;">如果无法上传头像,请尝试使用<a  style="color:#49a0cb;" href="<?=geturl('myroom/settings/avatarold')?>">普通上传模式</a></span>
		</div>
	</div>
</div>
<?php
$this->display('common/footer');
?>