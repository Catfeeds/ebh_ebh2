<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/lond.css" type="text/css" rel="stylesheet">
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>

<title><?=$room['crname']?></title>
</head>

<body>
<?php $this->display('common/up_header'); ?>
<div class="topbar">
	<div class="top-bd clearfix">
    	<div class="login-info">
		<?php if(empty($user)){?>
		<span style="width:100px;margin-left:50px"> 欢迎来到<?=$room['crname']?> </span>
        <a href="javascript:tologin('/login.html?returnurl=__url__');">登录</a>
        <a href="javascript:toregister('/register.html?returnurl=__url__');">注册</a>
		<?php }else{?>
		<span style="width:100px;margin-left:50px"> <?=empty($user['realname'])?$user['username']:$user['realname']?> </span>
		<span style="width:100px; "> 欢迎来到<?=$room['crname']?> </span>
		<a href="/logout.html">退出</a>
		<?php }?>
        </div>	
         <ul class="quick-menu">
            <li><a class="cent" onclick="SetHome(this,window.location);" href="javascript:void(0);">设为主页</a></li>
            <li><a class="cent" onclick="AddFavorite(window.location,document.title)" href="javascript:void(0);">加入收藏</a></li>
        </ul>
	</div>
</div>
<div class="egrtes">
<div class="geirug">
<div class="righbog">
<?php if(empty($user)){?>
<form id="form1" name="form1" action="/login.html?inajax=1&login_from=classroom" onsubmit="form_submit();return false;">
<input type="hidden" name="loginsubmit" value="1" />

<div class="fewgre">
<span class="fefus"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/zhntds.jpg" /></span>
<input class="txtists" name="username" type="text" id="textarea" value="" />
</div>
<div class="fewgre">
<span class="fefus"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/pasds.jpg" /></span>
<input class="txtists txterge" name="password" type="password" id="textarea" value="" />
</div>
<input class="dlfjbtn" type="submit" name="submit" id="button" value="" />

</form>
<?php }else{
	$sex = empty($user['sex']) ? 'man' : 'woman';
	$type = $user['groupid'] == 5 ? 't' : 'm';
	$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$type.'_'.$sex.'.jpg';
	$face = empty($user['face']) ? $defaulturl : $user['face'];
	$facethumb = getthumb($face,'78_78');
	$url = $user['groupid'] == 5 ? geturl('troom') : geturl('myroom');
	?>
<div class="usouter">
		<div class="figlef">
		<img src="<?= $facethumb ?>" />
		</div>
		<div class="showrig">
			<h2 style="font-weight:bold; font-size:14px; "><?= $user['username'] ?></h2>
			<p>上次登录时间：</p>
			<p><?= $user['lastlogintime']?></p>
		</div>
				
	</div>
	
	<input class="hxpslogoutbtn" type="button" onclick="location.href='/logout.html'"/>
	<?php if($user['groupid'] == 6)
			$enterurl = '/myroom.html';
		else
			$enterurl = '/troom.html';
	?>
	<input class="hxpsenterbtn" type="button" onclick="location.href='<?=$enterurl?>'"/>
	
<?php }?>
</div>
</div>
</div>
<div id="footer">
	        <p class="copyright"><a href="http://www.miibeian.gov.cn/" target="_blank">浙B2-20160787</a>&nbsp;&nbsp;Copyright &copy; 2011-<?=date('Y')?> ebh.net All Rights Reserved
            </p>
</div>
</body>
</html>
