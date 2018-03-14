<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title>中国浙江网上技术市场</title>
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
<style>
.wrap-1 {
    background:url(http://static.ebanhui.com/ebh/tpl/2016/images/zjwsjsscbg.jpg) no-repeat center center;
    height: 675px;
    margin: 0 auto;
    width: 100%;
}
.wrapdenglu {
    background:url(http://static.ebanhui.com/ebh/tpl/2016/images/denglukbjzjwssc.png) no-repeat;
    height: 372px;
    position: absolute;
    right: -15px;
    top: 120px;
    width: 390px;
}
.wrapdenglu h2{
	color:#1a1a1a;
}
.lijidenglu{
	background:url(http://static.ebanhui.com/ebh/tpl/2016/images/loginbtn.jpg) no-repeat;
	margin-top:40px;
	width:300px;
}
.zhanghao-1.on, .mima-1.on{
	border:1px solid #4186E5;
	box-shadow: 0 0 5px #4186E5;
}
.zhanghao-1 span{
	background:url(http://static.ebanhui.com/ebh/tpl/2016/images/dengluico.png) no-repeat 10px 10px;
	width:31px;
	height:43px;
	padding-left:10px;
}
.zhanghao-1.on  span{
	background:url(http://static.ebanhui.com/ebh/tpl/2016/images/dengluico1.png) no-repeat 10px 10px;
}
.zhanghao-1 input, .mima-1 input{
	width:251px;
	height:23px;
	line-height:23px;
	border:none;
	padding:10px 8px;
}
.zhanghao-1,.mima-1{
	width:308px;
	height:43px;
	border:1px solid #c6c6c6;
	background:#fff;
	margin:0 auto;
	margin-top:30px;
}
.mima-1 span{
	background:url(http://static.ebanhui.com/ebh/tpl/2016/images/dengluico.png) no-repeat 10px -64px;
	width:31px;
	height:43px;
	padding-left:10px;
}
.mima-1.on span{
	background:url(http://static.ebanhui.com/ebh/tpl/2016/images/dengluico1.png) no-repeat 10px -64px;
}
.wrapdenglu .rights p{
	color:#333;
}
.tuichu{
	background:url(http://static.ebanhui.com/ebh/tpl/2016/images/tuichu.jpg) no-repeat left center;
	margin-top:30px;
}
.masjr {
	background:url(http://static.ebanhui.com/ebh/tpl/2016/images/mashangjinru.jpg) no-repeat right center;
	margin-top:30px;
}
</style>
<script>
$(function(){  
	$("input[type='text']").focus(function(){  
		$(".zhanghao-1").addClass("on");  
	}).blur(function(){  
		$(".zhanghao-1").removeClass("on");  
	});  
});  
$(function(){  
	$("input[type='password']").focus(function(){  
		$(".mima-1").addClass("on");  
	}).blur(function(){  
		$(".mima-1").removeClass("on");  
	});  
});  
</script>
<body>
<?php $this->display('common/up_header'); ?>
    <div class="wrap-1">
    	<div class="wrapson">
            <div class="wraptop">
                <div class="fl">
                    
					<?php if(empty($user)) { ?>
						<span>欢迎来到中国浙江网上技术市场！</span>
						<a href="javascript:tologin('/login.html?returnurl=__url__');">登录</a>
						<a href="javascript:toregister('/register.html?returnurl=__url__');">注册</a>
					<?php }else{ ?>
						 <span style="width:170px; ">您好 <?= $user['username']?> 欢迎来到中国浙江网上技术市场！</span>
						  <a href="/logout.html">安全退出</a>
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
				<div class="wrapdenglu wrapdenglu-1" >
					<h2>用户登录</h2>
					<div class="zhanghao-1 mt30"><span class="fl"></span>
						<input id="username" name="username" type="text" value="" maxlength="16"/>
					</div>
					<div class="clear"></div>
					<div class="mima-1 mt30"><span class="fl"></span>
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
                    	<p><?=shortstr( $user['username'],16 )?></p>
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

</body>
</html>