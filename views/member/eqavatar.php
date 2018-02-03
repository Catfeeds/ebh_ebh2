<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
<script src="http://static.ebanhui.com/js/jquery-1.11.0.min.js" type="text/javascript"></script>
<script type="text/javascript">
function pliushFun(){//刷新
location.href=location.href;
}
function pclosed(){//
		var url = "http://www.ebanhui.com/member/setting/getavatar.html";
		$.ajax({
		   type: "POST",
		   url: url,
		   success: function(msg){
			 var aurl = "closeform://" + msg;
			 document.location.href = aurl;
		   }
		}); 
	}
</script>
</head>
<body>
<?php
	$domain=$this->uri->uri_domain();
	$uid=$user['uid'];
	$url=urlencode('/static/flash/xml/photoOnLine.xml');
	$resurl=urlencode('/static/flash/avatarRES.swf');
	$picurl = urlencode('http://'.$domain.'.ebanhui.com/avatar.html?uid='.$uid);
?>
<object type="application/x-shockwave-flash" data="/static/flash/photoOnline.swf" width="747"
		height="510" id="blog_index_flash_ff">
		<param name="quality" value="high" />
		<param name="FlashVars" value="url=<?=$url?>&uid=<?=$uid?>&resurl=<?=$resurl?>&picurl=<?=$picurl?>" />
		<param name="wmode" value="transparent" />
		<param name="menu" value="false">
		<param name="allowScriptAccess" value="sameDomain" />
		<param name="allowFullScreen" value="true" />
		<param name="movie" value="/static/flash/photoOnline.swf" /><!--兼容ie6-->
</object>
</body>
</html>