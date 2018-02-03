<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
<script type="text/javascript">
function pliushFun(){//刷新
location.href=location.href;
}
</script>
</head>
<body>
<?php
	$domain=$this->uri->uri_domain();
	$uid=$user['uid'];
	$url=urlencode('http://static.ebanhui.com/ebh/flash/xml/photoOnLine.xml');
	$returnurl=urlencode('http://'.$domain.'.ebanhui.com/member/setting/profile.html');
	$resurl=urlencode('http://static.ebanhui.com/ebh/flash/avatarRES.swf');
	$picurl = urlencode('http://'.$domain.'.ebanhui.com/avatar.html?uid='.$uid);
?>
<object type="application/x-shockwave-flash" data="http://static.ebanhui.com/ebh/flash/photoOnline.swf" width="747"
		height="510" id="blog_index_flash_ff">
		<param name="quality" value="high" />
		<param name="FlashVars" value="url=<?=$url?>&returnurl=<?=$returnurl?>&uid=<?=$uid?>&resurl=<?=$resurl?>&picurl=<?=$picurl?>" />
		<param name="wmode" value="transparent" />
		<param name="menu" value="false">
		<param name="allowScriptAccess" value="sameDomain" />
		<param name="allowFullScreen" value="true" />
		<param name="movie" value="http://static.ebanhui.com/ebh/flash/photoOnline.swf" /><!--兼容ie6-->
</object>
</body>
</html>