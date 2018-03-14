<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title>浙江省国土资源网络课堂在线学习平台</title>
</head>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2016/css/guotuzyt.css<?=getv()?>"/>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js<?=getv()?>"></script>
<script type="text/javascript">
	if (self != top) {
		top.location.href = "/";
	}
</script>
<body>
<?php $this->display('common/up_header'); ?>
    <div class="wrap">
    	<div class="wrapson">
			<div style="position:absolute;top:430px;left:-190px;width:200px;height:235px;">
				<img src="http://static.ebanhui.com/ebh/tpl/2016/images/guotudiqiu.gif?v=01" />
			</div>
            <div class="wraptop">
                <div class="fl">
					<span>欢迎来到浙江省国土资源网络课堂在线学习平台！</span>
                </div>
                <div class="fr">
                    <a href="javascript:void(0);" onclick="SetHome(this,window.location);">设为主页</a>
                    <a href="javascript:void(0);" onclick="AddFavorite(window.location, document.title);">收藏</a>
                </div>
            </div>
			<?php if(empty($user)) { ?>
			<form id="form1" name="form1" action="/login.html?inajax=1&login_from=classroom" onsubmit="form_submit();return false;">
			<input type="hidden" name="loginsubmit" value="1" />
				<div class="wrapdenglu" >
					<h2>用户登录</h2>
					<div class="zhanghao mt30"><span class="fl">账号&nbsp;</span>
						<input id="username" name="username" type="text" value="" maxlength="16"/>
					</div>
					<div class="clear"></div>
					<div class="mima mt30"><span class="fl">密码&nbsp;</span>
						<input id="password" name="password" type="password" value="" maxlength="16"/>
					</div>
					<div class="clear"></div>
					<div>
						<input class="lijidenglu" style=" border:none;" type="submit" name="" value=""/>
					</div>
				</div>
			</form>
			<?php }else{ ?>
            <div class="wrapdenglu">
            	<h2>用户登录</h2>
                <div class="mt30 ml10 disinline">
					<?php 
						$sex = empty($user['sex']) ? 'man' : 'woman';
						$type = $user['groupid'] == 5 ? 't' : 'm';
						$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$type.'_'.$sex.'.jpg';
						$face = empty($user['face']) ? $defaulturl : $user['face'];
						$facethumb = getthumb($face,'78_78');
						$url = $user['groupid'] == 5 ? geturl('troom') : geturl('myroom');
					?>
                	<div class="fl lefts ml45"><img src="<?= $facethumb ?>" /></div>
                    <div class="fl rights ">
                    	<p><?=shortstr($user['username'],16 ) ?></p>
                        <p>上次登录时间：</p>
                        <p><?= $user['lastlogintime']?></p>
                    </div>
                </div>
                <div class="clear"></div>
                <div style="width:305px; margin-left:45px;">
					<a href="/logout.html" class="tuichu fl"></a>
					<?php if($user['groupid'] == 6){ ?>
					<a href="<?= geturl('myroom')?>" class="masjr fr"></a>
					<?php }else{ ?>
					<a href="<?= geturl('troomv2')?>" class="masjr fr"></a>
					<?php } ?>
				</div>
            </div>
			<?php } ?>
        </div>
    </div>
	<script type="text/JavaScript">
		var tologin = function(url){
			url = url.replace('__url__',encodeURIComponent(location.href));
			location.href=url;
		}
		var toregister = function(url){
			url = url.replace('__url__',encodeURIComponent(location.href));
			location.href=url;
		}

	</script>
<?php if(isApp()==false){?>
<?php
$icp = '<a href="http://www.miibeian.gov.cn/" style="color: #666666;" target="_blank">  浙B2-20160787</a> Copyright &copy; 2011-' . date('Y') . ' ebh.net All Rights Reserved';
if (!empty($room) && !empty($room['icp']))
    $icp = $room['icp'];
?>
<div class="footer">
    <P style="color: #666666"></P><?= $icp ?></P></div>
<?php }?>
<!-- 统计代码开始 -->
<?php
if (!empty($systemsetting['analytics']) && !IS_DEBUG) {
	echo $systemsetting['analytics'];
} else {
	EBH::app()->lib('Analytics')->get('baidu');
}
?>
<!-- 统计代码结束 -->
</body>
</html>