<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/citytpl/stores/css/wxind.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" />

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" rel="stylesheet" />	
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>

<title><?= $room['crname'] ?></title>
</head>

<body style="background:#fff;">
<div class="topbar">
<div class="top-bds">
<ul class="qmenu">
<li class="">
<a class="boifang" target="_blank" href="http://soft.ebh.net/mpc.exe">视频播放器下载</a>
</li>
<li class="lianxt">
</li>
<li class="">
<a class="weibos" target="_blank" href="http://weibo.com/ebanhui">关注e板会微博</a>
</li>
<li class="lianxt">
</li>
<li class="">
<a class="bzzx" target="_blank" href="/help.html">帮助中心</a>
</li>
</ul>
</div>
</div>
<div class="topdlte">
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/hz_toplog.jpg" />
<div style="margin-left:145px;float:left">
<span class="toltc">关于我们：</span><img style="margin-top:30px;" src="http://static.ebanhui.com/ebh/tpl/2014/images/hz_erweima.jpg" />
</div>
</div>
<div class="adsol">
<div class="recdirte">
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/hz_bgheix.jpg" />
<div class="reyed"> 
<h2 class="ewtkewt" title="123123123">公告：<?=!empty($announcementlist)?$announcementlist[0]['message']:''?></h2>
<div class="admyhe">
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/hz_adtu.jpg" />
</div>
</div>
<div class="recrigs">
<h2 class="titwen">用户登录</h2>
<?php if(!empty($user)) { ?>
	<?php 
			$sex = empty($user['sex']) ? 'man' : 'woman';
            $type = $user['groupid'] == 5 ? 't' : 'm';
            $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$type.'_'.$sex.'.jpg';
            $face = empty($user['face']) ? $defaulturl : $user['face'];
            $facethumb = getthumb($face,'78_78');
            $url = $user['groupid'] == 5 ? geturl('troom') : geturl('myroom');
		?>
	<div class="tuxiang">
	<div class="tukuang" style="margin-left:10px;margin-top:18px;display:inline;">
	<img src="<?= $facethumb ?>"/></div>
	<div style="float:left;margin-top:20px;"><p style="font-weight:bold;font-size:14px;"><?=empty($user['realname'])?$user['username']:$user['realname'] ?></p><p>上次登录时间:</p><p><?= $user['lastlogintime']?></p></div>
	</div>
	<?php if($user['groupid'] == 6){ ?>
	<input class="msjinr" type="submit" name="Submit" value="" onclick="window.location.href='<?= geturl('myroom')?>'" />
	<? }else{ ?>
	<input class="msjinr" type="submit" name="Submit" value="" onclick="window.location.href='<?= geturl('troom')?>'"/>
	<? } ?>
	<div class="fotlog">
	<?php if($user['groupid'] == 6){ ?>
	<a href="/logout.html" style="color:#808080;">退出</a>
	<? }else{ ?>
	<a href="/logout.html" style="color:#808080;">退出</a>
	<? } ?>
	</div>
<?php }else{ ?>
<form id="form1" name="form1" action="/login.html?inajax=1&login_from=classroom" onsubmit="form_submit();return false;">
<input type="hidden" name="loginsubmit" value="1" />
<div class="reyldiv">账号：</div>
<div class="reyldiv">
<input class="txtmsat zhangh" id="username" name="username" type="text" value="" />
</div>
<div class="reyldiv">密码：</div>
<div class="reyldiv">
<input class="txtmsat pass" id="password" name="password" type="password" value="" />
</div>
<div class="reyldiv">
<label >
<input class="intkuat" type="checkbox" checked="checked" value="1" name="cookietime">
下次自动登录</label>
<a target="_blank" href="/forget.html" class="ewlre">忘记密码？</a>
</div>
<div class="reyldiv" style="margin-top:8px;">
<input type="submit" class="dengbtn logobtn" name="Submit" value=""></a>
</div>
</form>
<?php }?>
</div>
</div>
</div>
<div id="footer">
	        <p class="copyright"><a target="_blank" href="http://www.miibeian.gov.cn/">浙B2-20160787</a>&nbsp;&nbsp;Copyright &copy; 2014 Ebanhui.com All Rights Reserved &nbsp;&nbsp;技术支持:浙江新盛蓝技术有限公司

            </p>
</div>


<script src="http://static.ebanhui.com/ebh/js/index.js" type="text/javascript"></script>
</body>
</html>

