<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>

<title>平台简介</title>
</head>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2014/css/zjdfysxy.css"/>

<body>
<div class="topbar">
		<div class="top-bd clearfix">
            <div class="login-info">
			
			<?php if(empty($user)){?>
			<span style="width:170px; ">您好 欢迎来到e板会！ </span>
			<a href="javascript:tologin('/login.html?returnurl=__url__');">登录</a>
			<a href="javascript:toregister('/register.html?returnurl=__url__');">注册</a>
			<?php }else{?>
			<span style="width:170px; ">您好 <?=$user['username']?> 欢迎来到e板会！ </span><a href="/logout.html">安全退出</a><a href="http://www.ebh.net" >e板会首页</a>
			<?php }?>
			</div>
            <ul class="quick-menu">
                <li><a href="http://jiazhang.ebh.net/" target="_blank" class="cent">家长监控平台</a> | </li>
				<li><a target="_blank" class="cent" href="http://soft.ebh.net/ebhbrowser.exe">锁屏浏览器</a> | </li>
				<li><a href="javascript:void(0);" onclick="SetHome(this,window.location);" class="cent">设为主页</a></li>
            </ul>
		</div>
	</div>
	<div class="clear"></div>
    <div class="banner"></div>
<div class="ptjjs">
	
    <div class="title1"></div>
    <div class="ptjjs_son">
         <div class="fr"><a href="/"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/fhsy.jpg" /></a></div> 
         <div class="clear"></div>
         <div class="xxtits"></div>
         <div><p class="p2s" style=" margin-top:10px;"><?= shortstr($room['summary'],450)?></p></div> 
         <div class="xxjss mt20"></div>
         <div>
			<p class="p2s" style=" margin-top:10px;"> </p>
			</div> 
		
         <?= str_replace('\\"','"',$classroommess['message'])?>
    </div> 
</div>
<script>
var tologin = function(url){
		url = url.replace('__url__',encodeURIComponent(location.href));
		location.href=url;
	}
	var toregister = function(url){
		url = url.replace('__url__',encodeURIComponent(location.href));
		location.href=url;
	}
</script>
<?php $this->display('common/footer')?>
