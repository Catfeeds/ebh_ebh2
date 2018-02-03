<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" rel="stylesheet" />	
<script type="text/javascript">
<!--
	var sitecpurl ='#getsitecpurl()#';
//-->
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<style type="text/css">
.xiatop {
	width:960px;
	margin:10px auto;
	height:210px;
}
.rigsse {
	width:950px;
	display:inline;
	float:left;
}
.wensize {
	color:#2AA0E6;
	text-indent:25px;
	line-height:1.8;
	margin-top:5px;
	font-size:18px;
	font-weight:bold;
}
.botlink {
    background: none repeat scroll 0 0 #f7f7f7;
    border-bottom: 1px solid #e2e2e2;
    border-top: 1px solid #e2e2e2;
    height: 357px;
    margin:0 auto;
    position: relative;
	text-align:center;
}
.rigsse .kichtss {
    color: #107AC0;
    font-size: 50px;
    font-weight: bold;
}
.fourcs {
	width:960px;
	background:url(http://static.ebanhui.com/ebh/tpl/2012/images/botlink0923.jpg) no-repeat;
	height:357px;
	margin:0 auto;
	position: relative;
}
.fourcs a {
	width:175px;
	height:316px;
	display:block inline;
	margin-top:25px;
	float:left;
}
.neifour {
	background:url(http://static.ebanhui.com/ebh/tpl/2012/images/botlink0923.jpg) no-repeat;
	position:absolute;
	width:960px;
	height:357px;
	left:-12px;
}
</style>
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>

<title>宁夏石嘴山市教育体育局人人通教育平台</title>
</head>
<?php $this->display('common/public_header'); ?>
<body>
<div class="xiatop">

<div class="rigsse">
<h2 class="kichtss">宁夏石嘴山市教育体育局人人通教育平台</h2>
<p class="wensize"><?= $room['summary']?></p>
</div>
</div>
<div class="botlink">
<div class="fourcs" style="background:none;">
<div class="neifour">
<a href="http://szssz.ebanhui.com" style="margin-left:11px;"></a>
<a href="http://szswk.ebanhui.com/" style="margin-left:94px;"></a>
<a href="http://szshn.ebanhui.com/" style="margin-left:81px;"></a>
<a href="http://szspl.ebanhui.com/" style="margin-left:71px;"></a>
</div>
</div>
</div>
   <?php
    $this->display('common/footer');
    ?>