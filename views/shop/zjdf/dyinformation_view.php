<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>

<title>动态资讯</title>
</head>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2014/css/zjdfysxy.css"/>
<style>
.see{ background: #fff;border: 1px solid #e2e2e2;display: inline-block;left: 10px;padding: 10px 20px 20px;position: relative;top: -10px;width: 908px;}
.see .title{ font-size:24px; color:#333; text-align:center;}
.see .p1s{ font-size:14px; line-height:24px; padding-top:15px; text-indent:24px;}
.title1{  background: url("http://static.ebanhui.com/ebh/tpl/2014/images/dtzx.png") no-repeat left center;height: 40px;margin-top: 10px;width: 182px;}
</style>

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
	<div style="width:960px; margin:0 auto;">
		<div class="title1"></div>
		<div class="see">
			<div class="title"><?=$itemview['subject']?></div>
			<div><p class="p1s"><?=stripslashes($itemview['message'])?></p></div>
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
