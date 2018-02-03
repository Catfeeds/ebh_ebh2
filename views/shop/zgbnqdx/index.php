<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
	<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
	<?php }?>
<title>中共巴南区党校在线学习平台</title>
</head>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2014/css/zzbnqdx.css?v=20160505002"/>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>

<body>
    <div class="wrap">
    	<div class="wrapson">
            <div class="wraptop">
                <div class="fl">
                    
					<?php if(empty($user)) { ?>
						<span>欢迎来到中共巴南区党校在线学习平台！</span>
						<a href="javascript:tologin('/login.html?returnurl=__url__');">登录</a>
						<a href="javascript:toregister('/register.html?returnurl=__url__');">注册</a>
					<?php }else{ ?>
						 <span style="width:170px; ">您好 <?= $user['username']?> 欢迎来到中共巴南区党校在线学习平台！</span>
						 <a href="http://www.ebh.net/">返回首页</a>  <a href="/logout.html">安全退出</a>
					<?php } ?>
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
					<div class="zhanghao mt35"><span class="fl">账号&nbsp;</span>
						<input id="username" name="username" type="text" value="" maxlength="16"/>
					</div>
					<div class="clear"></div>
					<div class="mima mt35"><span class="fl">密码&nbsp;</span>
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
                <div class="mt40">
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
                    	<p><?= $user['username'] ?></p>
                        <p>上次登录时间</p>
                        <p><?= $user['lastlogintime']?></p>
                    </div>
                </div>
                <div class="clear"></div>
                <div style="width:260px; margin-left:45px;">
					<a href="/logout.html" class="tuichu fl">退出</a>
					<?php if($user['groupid'] == 6){ ?>
					<a href="<?= geturl('myroom')?>" class="masjr fr">马上进入</a>
					<? }else{ ?>
					<a href="<?= geturl('troom')?>" class="masjr fr">马上进入</a>
					<? } ?>
				</div>
            </div>
			<?php } ?>
			<div class="fusrer">
				<img src="http://static.ebanhui.com/ebh/tpl/2014/images/bndxer.png" />
			</div>
        </div>
    </div>
	<div class="footer"><p>浙B2-20160787  Copyright © 2011-<?=date('Y')?> 技术支持:浙江新盛蓝科技有限公司 电话：0571-87757303  </p></div>
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
</body>
</html>
