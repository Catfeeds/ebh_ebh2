<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title>欢迎来到贵州省遵义市播州区空中课堂在线学习平台！</title>
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
.zybz {
	width:100%;
	height:768px;
	min-width:1000px;
	background:url(http://static.ebanhui.com/ebh/tpl/2016/images/quyibgtu.jpg) no-repeat center;
	font-family:微软雅黑;
}
.nisrtd {
	width:1000px;
	margin:0 auto;
}
.topler {
	color:#fff;
	font-size:16px;
	letter-spacing:2px;
	height:40px;
	line-height:40px;
	width:100%;
	position:relative;
}
.topler a {
	color:#fff;
}
.frsre {
	position:absolute;
	top:0px;
	right:0px;
	display:inline;
}
.naisrs {
	height:670px;
	width:1000px;
}
.naisrs a {
	width:269px;
	height:399px;
	float:left;
	display:block;
	margin:260px 0 0 50px;
	transition: all 0.65s ease-out 0s;
	opacity:0;
}
.naisrs a:hover {
	background:url(http://static.ebanhui.com/ebh/tpl/2016/images/husor.png) no-repeat;
	opacity:1;
}
.fldty {
	color:#fff;
	font-size:16px;
}
</style>
<body>
<?php $this->display('common/up_header'); ?>
<div class="zybz">
	<div class="nisrtd">
    	<div class="topler">
			<span>欢迎来到贵州省遵义市播州区空中课堂在线学习平台！</span>
            <div class="frsre">
                <a href="javascript:void(0);" onclick="SetHome(this,window.location);" style="margin-left:15px;">设为主页</a>
                <a href="javascript:void(0);" onclick="AddFavorite(window.location, document.title);">收藏</a>
            </div>
        </div>
        <div class="naisrs">
        	<a href="http://bzxx.ebh.net/"></a>
        	<a href="http://bzcz.ebh.net/"></a>
        	<a href="http://bzgz.ebh.net/"></a>
        </div>      
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