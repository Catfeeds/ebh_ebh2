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
	padding-top:35px;
	position:relative;
}
.botlink li {
	width:130px;
	float:left;
	margin-right:90px;
	height:25px;
	text-align: left;
	padding-left:10px;
	margin-top: 5px;
}
.botlink li a.asds
{
	text-decoration: underline;
	color:#000;
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
	font-size: 14px;
}

.titaaa {
    color: #1B6EA6;
    height: 26px;
    width: 100%;
	text-align: left;
	float:left;
	font-size: 14px;
}
</style>
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>

<title><?= $room['crname'] ?></title>
</head>
<?php $this->display('common/public_header'); ?>
<body>
<?php $this->display('common/up_header'); ?>
<div class="xiatop">
<?php $logo=empty($room['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$room['cface']?>
<img src="<?= $logo?>" width="102" height="102" style="float:left;"/>
<div class="rigsse">
<h2 class="kichtss"><?= $room['crname']?></h2>
<p class="wensize"><?= $room['summary']?></p>
</div>
</div>
<div class="botlink">
<div style="width:960px;margin:0 auto;">
	<div class="lilie" style="width:960px;float:left;">
	<div class="titbiaot">幼儿园:</div>
		<ul class="list_fltwo" >
		<li>
		<a class="asds" href="http://dwyou.ebanhui.com" title="大武口区幼儿园"> 大武口区幼儿园 </a>
		</li>
		</ul>
	
	</div>
	<div style="width:960px;float:left;">
	<div class="titaaa">小学:</div>
		<ul class="list_fltwo" >
			<li>
			<a class="asds" href="http://szsliux.ebanhui.com" title="石嘴山市六小"> 石嘴山市六小 </a>
			</li>
			<li>
			<a class="asds" href="http://szsqix.ebanhui.com" title="石嘴山市七小"> 石嘴山市七小 </a>
			</li>
			<li>
			<a class="asds" href="http://szsshix.ebanhui.com" title="石嘴山市十小"> 石嘴山市十小 </a>
			</li>
			<li>
			<a class="asds" href="http://szsshiyx.ebanhui.com" title="石嘴山市十一小"> 石嘴山市十一小 </a>
			</li>
			<li>
			<a class="asds" href="http://szsshierx.ebanhui.com" title="石嘴山市十二小"> 石嘴山市十二小 </a>
			</li>
			<li>
			<a class="asds" href="http://szsshisx.ebanhui.com" title="石嘴山市十三小"> 石嘴山市十三小 </a>
			</li>
			<li>
			<a class="asds" href="http://szsshiwx.ebanhui.com" title="石嘴山市十五小"> 石嘴山市十五小 </a>
			</li>
			<li>
			<a class="asds" href="http://szsshilx.ebanhui.com" title="石嘴山市十六小"> 石嘴山市十六小 </a>
			</li>
			<li>
			<a class="asds" href="http://szsshibx.ebanhui.com" title="石嘴山市十八小"> 石嘴山市十八小 </a>
			</li>
			<li>
			<a class="asds" href="http://szsshijx.ebanhui.com" title="石嘴山市十九小"> 石嘴山市十九小 </a>
			</li>
			<li>
			<a class="asds" href="http://szsershix.ebanhui.com" title="石嘴山市二十小"> 石嘴山市二十小 </a>
			</li>
			<li>
			<a class="asds" href="http://szsershiyx.ebanhui.com" title="石嘴山市二十一小"> 石嘴山市二十一小 </a>
			</li>
			<li>
			<a class="asds" href="http://szsslx.ebanhui.com" title="石嘴山市胜利小学"> 石嘴山市胜利小学 </a>
			</li>
			<li>
			<a class="asds" href="http://szsbn.ebanhui.com" title="石嘴山市奔牛学校"> 石嘴山市奔牛学校 </a>
			</li>
			<li>
			<a class="asds" href="http://szsyc.ebanhui.com" title="石嘴山市育才学校"> 石嘴山市育才学校 </a>
			</li>
			<li>
			<a class="asds" href="http://szsjlx.ebanhui.com" title="石嘴山市锦林小学"> 石嘴山市锦林小学 </a>
			</li>
			<li>
			<a class="asds" href="http://szslrx.ebanhui.com" title="石嘴山市丽日小学"> 石嘴山市丽日小学 </a>
			</li>
			<li>
			<a class="asds" href="http://szsybxmx.ebanhui.com" title="石嘴山市燕宝新民小学"> 石嘴山市燕宝新民小学 </a>
			</li>
			<li>
			<a class="asds" href="http://szsxhx.ebanhui.com" title="石嘴山市星海小学"> 石嘴山市星海小学 </a>
			</li>
			<li>
			<a class="asds" href="http://szslherzx.ebanhui.com" title="石嘴山市隆湖二站小学"> 石嘴山市隆湖二站小学 </a>
			</li>
			<li>
			<a class="asds" href="http://szslhszx.ebanhui.com" title="石嘴山市隆湖四站小学"> 石嘴山市隆湖四站小学 </a>
			</li>
			<li>
			<a class="asds" href="http://szslhwzx.ebanhui.com" title="石嘴山市隆湖五站小学"> 石嘴山市隆湖五站小学 </a>
			</li>
			<li>
			<a class="asds" href="http://szslhlzx.ebanhui.com" title="石嘴山市隆湖六站小学"> 石嘴山市隆湖六站小学 </a>
			</li>
		</ul>
	
	</div>
	<div style="width:960px;float:left;">
	<div class="titaaa">中学:</div>
		<ul class="list_fltwo">
		<li>
		<a class="asds" href="http://szsliuz.ebanhui.com" title="石嘴山市六中"> 石嘴山市六中 </a>
		</li>
		<li>
		<a class="asds" href="http://szsqiz.ebanhui.com" title="石嘴山市七中"> 石嘴山市七中 </a>
		</li>
		<li>
		<a class="asds" href="http://szsbaz.ebanhui.com" title="石嘴山市八中"> 石嘴山市八中 </a>
		</li>
		<li>
		<a class="asds" href="http://szsjiuz.ebanhui.com" title="石嘴山市九中"> 石嘴山市九中 </a>
		</li>
		<li>
		<a class="asds" href="http://szsrlzx.ebanhui.com" title="石嘴山市丽日中学"> 石嘴山市丽日中学 </a>
		</li>
		<li>
		<a class="asds" href="http://szsshiqz.ebanhui.com" title="石嘴山市十七中"> 石嘴山市十七中 </a>
		</li>
		<li>
		<a class="asds" href="http://szslh.ebanhui.com" title="石嘴山市隆湖中学"> 石嘴山市隆湖中学 </a>
		</li>
		<li>
		<a class="asds" href="http://szslhyzx.ebanhui.com" title="石嘴山市隆湖一站学校"> 石嘴山市隆湖一站学校 </a>
		</li>
		</ul>
	
	</div>

</div>
</div>
   <?php
    $this->display('common/footer');
    ?>
