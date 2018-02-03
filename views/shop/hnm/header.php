<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>

<link href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/hncss.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" rel="stylesheet" />	
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/cloudlist.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/zzys.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<style>
body{
	background:#fff;
}
html{
	background:#fff;
}
</style>
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
	<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
	<?php }?>
<title><?=$room['crname']?></title>
</head>

<body>
<div class="topbar">
            <div class="top-bd clearfix">
                <?php 
                if(empty($user)) {
                    $reurl="javascript:tologinn('".'/login.html?returnurl=__url__'."');";
                ?>    
                <div class="login-info">
                    <span style="width:100px; float:left;">欢迎来到e板会！</span>
                    <a href="http://www.ebanhui.com">e板会首页</a><a href="<?= $reurl ?>">登录</a><a href="/register.html">注册</a>
                <?php
					$Uproom = Ebh::app()->lib('Uproom');
					echo $Uproom->getUproom();
				?>
				</div>
                <?php
                } else {
                ?>
                <div class="login-info">
                    <span style="width:170px; ">您好 <?= $user['username']?> 欢迎来到e板会！</span>
                    <?php
                    if($user['groupid'] == 6) {
                    ?>
                    <a href="<?= geturl('member')?>">个人中心</a>
                    <?php
                    } else {
                    ?>
                    <a href="<?= geturl('teacher/choose')?>">个人中心</a>
                    <?php
                    }
                    ?>
                    <a href="http://www.ebanhui.com/">返回首页</a><a href="/logout.html">安全退出</a>
					<?php
					$Uproom = Ebh::app()->lib('Uproom');
					echo $Uproom->getUproom();
					?>
                </div>
                <?php
                }
                ?>
				
                <ul class="quick-menu">
                    <li><a href="javascript:void(0);" onclick="SetHome(this, window.location);" class="cent">设为主页</a></li>
                    <li><a href="javascript:void(0);" onclick="AddFavorite(window.location, document.title)" class="cent" >加入收藏</a></li>
                    <li style="width:60px;"><a target="_blank" href="<?= geturl('down'); ?>">播放器下载</a></li>
                    <li><a target="_blank" href="<?= geturl('help'); ?>">帮助中心</a></li>
                    <li><a target="_blank" href="<?= geturl('open'); ?>">开放接口</a></li>
                    <li class="last"><a href="http://weibo.com/ebanhui" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/sina.png" style="float:right; margin-top:1px" />关注e板会微博</a></li>
                </ul>
            </div>
        </div>
<div class="tophnjie">
<div class="hnlog">
<?php $logo=empty($room['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$room['cface']?>
<img src="<?=$logo?>" />
</div>
<div class="hnxiang">
<div class="hnname" style="width:300px;"><?=$room['crname']?></div>

<ul>
<?php
if(preg_match('/^[a-zA-Z0-9_\-]{1,}@[a-zA-Z0-9_\-]{1,}\.[a-zA-Z0-9_\-.]{1,}$/',$room['cremail'])){
	$pre = 'mailto:';
}elseif(substr($room['cremail'],0,7)!='http://'){
	$pre = 'http://';
}else{
	$pre = '';
}
?>
<li class="xiaoname"><?=$room['crname']?></li>
<li class="hndianhua"><?=$room['crphone']?></li>
<li class="hnwangzhi"><?=$pre.$room['cremail']?></li>
<li class="hndizhi"><?=$room['craddress']?></li>
</ul>
</div>
<div class="hnsou">
<input class="hnsoutxt" id="skey" type="text" value="<?=!empty($q)?$q:''?>" /><a href="javascript:void(0)" onclick="_search()" class="hnsoubtn">搜 索</a>
</div>
</div>
<div class="hntaoh">
<div class="hnwitot">
<ul>
<?php
$zizhantitle = '学习子站';
if($room['crid']=='10506')
	$zizhantitle = '企业子站';
elseif($room['crid']=='10427' || $room['crid']=='10426')
	$zizhantitle = '网校子站';
?>
<li><a class="daoten" href="/">首页</a></li>
<li><a class="daoten" href="/dyinformation.html">动态资讯</a></li>
<li><a class="daoten" href="/platform.html"><?=$zizhantitle?></a></li>
<li><a class="daoten" href="/contacts.html">联系方式</a></li>
</ul>
</div>
</div>
<script>
function _search(){
	var key = $('#skey').val();
	location.href = '/platform.html?q='+key;
}
</script>