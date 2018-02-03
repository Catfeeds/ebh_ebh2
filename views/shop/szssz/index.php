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
	height:130px;
}
.rigsse {
	width:835px;
	margin-left:20px;
	display:inline;
	float:left;
}

.rigsse .kichtss {
    color: #107AC0;
    font-size: 20px;
    font-weight: bold;
}
.wensize {
	color:#2AA0E6;
	text-indent:25px;
	line-height:1.8;
	margin-top:5px;
	font-size:14px;
	font-weight:bold;
}
.botlink {
    background: none repeat scroll 0 0 #f7f7f7;
    border-bottom: 1px solid #e2e2e2;
    border-top: 1px solid #e2e2e2;
    height: 356px;
    margin:0 auto;
    position: relative;
	text-align:center;
}
.lilie {
	background:url(http://static.ebanhui.com/ebh/tpl/2012/images/bgdiy0923.jpg) no-repeat 20px 0px;
	width:965px;
	margin:0 auto;
	height:356px;
	padding-top:35px;
	position:relative;
}
.botlink li {
	width:100px;
	float:left;
	margin-right:100px;
	height:152px;
}
.botlink li img {
	float:left;
}
.wenxz {
	color:#9e9e9e;
	width:100px;
	margin-top:8px;
	word-wrap: break-word;
	text-align:left;
}
.titbiaot {
	color:#1b6ea6;
	width:80px;
	height:26px;
	text-align: left;
	position: absolute;
	top:5px;
	left:0px;
}
</style>
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>

<title><?= $room['crname'] ?></title>
</head>
<?php $this->display('common/public_header'); ?>
<body>
<div class="xiatop">
<?php $logo=empty($room['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$room['cface']?>
<img src="<?= $logo?>" width="102" height="102" style="float:left;"/>
<div class="rigsse">
<h2 class="kichtss"><?= $room['crname']?></h2>
<p class="wensize"><?= $room['summary']?></p>
</div>
</div>
<div class="botlink">
<div class="lilie">
<div class="titbiaot">市直学校:</div>
<ul class="list1">
<li>
<a href="http://szssy.ebanhui.com" class="img-shadow" style="margin-left: 0px;"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/xuexiaotu0923.jpg" /></a>
<p class="wenxz">石嘴山市实验中学</p>
</li>
<li>
<a href="http://szssyxx.ebanhui.com" class="img-shadow" style="margin-left: 0px;"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/shiyanxiaoxue.jpg" /></a>
<p class="wenxz">石嘴山市实验小学</p>
</li>
<li>
<a href="http://szsdyzx.ebanhui.com" class="img-shadow" style="margin-left: 0px;"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/diyizhongxue.jpg" /></a>
<p class="wenxz">石嘴山市第一中学</p>
</li>
<li>
<a href="http://szsgmzx.ebanhui.com" class="img-shadow" style="margin-left: 0px;"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/guangming.jpg" /></a>
<p class="wenxz">石嘴山市光明中学</p>
</li>
<li style="margin:0px;">
<a href="http://szsdigyxxx.ebanhui.com" class="img-shadow" style="margin-left: 0px;"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/gongye.jpg" /></a>
<p class="wenxz">宁夏第一工业学校</p>
</li>
<li>
<a href="http://szstsjyxx.ebanhui.com" class="img-shadow" style="margin-left: 0px;"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/teshu.jpg" /></a>
<p class="wenxz">石嘴山市特殊教育学校</p>
</li>
<li>
<a href="http://szssyyouer.ebanhui.com" class="img-shadow" style="margin-left: 0px;"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/youeryuan.jpg" /></a>
<p class="wenxz">石嘴山市实验幼儿园</p>
</li>
<li>
<a href="http://szswszz.ebanhui.com" class="img-shadow" style="margin-left: 0px;"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/zhongzhuan.jpg" /></a>
<p class="wenxz">宁夏西北外事中专学校</p>
</li>
<li>
<a href="http://szsdszx.ebanhui.com" class="img-shadow" style="margin-left: 0px;"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/disan.jpg" /></a>
<p class="wenxz">石嘴山市第三中学</p>
</li>
<li style="margin:0px;">
<a href="http://szssszx.ebanhui.com" class="img-shadow" style="margin-left: 0px;"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/shisan.jpg" /></a>
<p class="wenxz">石嘴山市第十三中学</p>
</li>
</ul>
</div>
</div>
   <?php
    $this->display('common/footer');
    ?>
