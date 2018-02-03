<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
        <link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" />
        <link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
	function pliushFun(){//刷新
		location.href=location.href;
	}
//-->
</script>
    </head>
    <body>
<div class="tmiddle" style="width:788px;">

	<div class="ter_tit" style="position: relative;">
	当前位置 > 个人信息 > 修改头像
	</div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
		<?php $this->display('teacher/simple_menu'); ?>
        <?php 
        $returlurl = urlencode('http://'.$this->uri->uri_domain().'.ebanhui.com/teacher/setting/rprofile.html');
        //$picurl = urlencode('http://'.$this->uri->uri_domain().'.ebanhui.com/avatar.html?uid='.$user['uid']);
		$picurl = urlencode($picurl);
		if(empty($user['face'])){
			if($user['sex']==1){
				$initpicurl=urlencode('http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg');
			}else{
				$initpicurl=urlencode('http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg');
			 }
		}else{
			$initpicurl=urlencode($user['face']);
		}
        ?>
	<object type="application/x-shockwave-flash" data="/static/flash/photoOnline.swf" width="757"
			height="510" id="blog_index_flash_ff">
			<param name="quality" value="high" />
			<param name="FlashVars" value="url=/static/flash/xml/photoOnLine.xml&returnurl=<?= $returlurl?>&picurl=<?= $picurl ?>&uid=<?=$user['uid']?>&resurl=/static/flash/avatarRES.swf&initpicurl=<?=$initpicurl?>" />
			<param name="wmode" value="transparent" />
			<param name="menu" value="false">
			<param name="allowScriptAccess" value="sameDomain" />
			<param name="allowFullScreen" value="true" />
			<param name="movie" value="/static/flash/photoOnline.swf" /><!--兼容ie6-->
	</object>
	</div>

	</div>
	</div>
</div>
<div class="clear"></div>
    </body>
</html>

