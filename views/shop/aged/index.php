<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>老年网络大学</title>
</head>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/newschoolindex/css/draglayout.css?v=2017062801" />
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
            <div class="wraptop">
                <div class="fr">
                	<a href="http://jiazhang.ebh.net/" target="_blank">亲属登录</a>
                    <a href="javascript:void(0);" onclick="SetHome(this,window.location);">设为主页</a>
                    <a href="javascript:void(0);" onclick="AddFavorite(window.location, document.title);">收藏</a>
                </div>
            </div>
			<?php if(empty($user)) { ?>
			<form id="form1" name="form1" action="/login.html?inajax=1&login_from=classroom" onsubmit="form_submit();return false;">
			<input type="hidden" name="loginsubmit" value="1" />
				<div class="wrapdenglu" >
					<h2>用户登录</h2>
					<div class="text mt30">
						<img class="zhanghao" src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/leblue_bg003.png" /><input id="username" name="username" type="text" value="" placeholder="账号" maxlength="16"/>
					</div>
					<div class="clear"></div>
					<div class="text mt30">
						<img class="zhanghao" src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/leblue_bg004.png" /><input class="mima" id="password" name="password" type="password" value="" placeholder="密码" maxlength="16"/>
					</div>
					<div class="clear"></div>
					<div>
						<input class="lijidenglu" type="submit" name="" value="登录"/>
					</div>
				</div>
			</form>
			<?php }else{ ?>
            <div class="wrapdenglu">
            	<h2>用户登录</h2>
                <div class="mt15 ml10 disinline">
					<?php 
						$sex = empty($user['sex']) ? 'man' : 'woman';
						$type = $user['groupid'] == 5 ? 't' : 'm';
						$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$type.'_'.$sex.'.jpg';
						$face = empty($user['face']) ? $defaulturl : $user['face'];
						$facethumb = getthumb($face,'78_78');
						$url = $user['groupid'] == 5 ? geturl('troom') : geturl('myroom');
					?>
                	<div class="fl lefts"><img src="<?= $facethumb ?>" /></div>
                    <div class="fl rights ">
                    	<p><?=shortstr($user['username'],16 ) ?></p>
                        <p>上次登录时间：</p>
                        <p><?= $user['lastlogintime']?></p>
                    </div>
                </div>
                
                <div class="clear"></div>
                <div>
					<?php if($user['groupid'] == 6){ ?>
					<a href="<?= geturl('myroom')?>" class="lijidenglu" style="margin-top:15px;">立即进入</a>
					<?php }else{ ?>
					<a href="<?= geturl('troomv2')?>" class="lijidenglu" style="margin-top:15px;">立即进入</a>
					<?php } ?>					
					<a href="/logout.html" class="tuibtn">退出</a>
				</div>
            </div>
			<?php } ?>
        </div>

<?php if(isApp()==false){?>
<?php
$icp = '<a href="http://www.miibeian.gov.cn/" style="color: #666666;" target="_blank">  浙B2-20160787</a> Copyright &copy; 2011-' . date('Y') . ' ebh.net All Rights Reserved';
if (!empty($room) && !empty($room['icp']))
    $icp = $room['icp'];
?>
<div class="footer">
    <P style="color: #666666"></P><?= $icp ?></P>
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
