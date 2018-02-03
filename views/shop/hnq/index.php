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
	width:140px;
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
		<a class="asds" href="http://szsyiyou.ebanhui.com" title="惠农区一幼"> 惠农区一幼 </a>
		</li>
		<li>
		<a class="asds" href="http://szseryou.ebanhui.com" title="惠农区二幼"> 惠农区二幼 </a>
		</li>
		<li>
		<a class="asds" href="http://szszhyou.ebanhui.com" title="燕子墩中幼"> 燕子墩中幼 </a>
		</li>
		</ul>
	
	</div>
	<div style="width:960px;float:left;">
	<div class="titaaa">小学:</div>
		<ul class="list_fltwo" >
			<li>
			<a class="asds" href="http://szsyx.ebanhui.com" title="石嘴山市一小"> 石嘴山市一小 </a>
			</li>
			<li>
			<a class="asds" href="http://szserx.ebanhui.com" title="石嘴山市二小"> 石嘴山市二小 </a>
			</li>
			<li>
			<a class="asds" href="http://szssx.ebanhui.com" title="石嘴山市三小"> 石嘴山市三小 </a>
			</li>
			<li>
			<a class="asds" href="http://szswx.ebanhui.com" title="石嘴山市五小"> 石嘴山市五小 </a>
			</li>
			<li>
			<a class="asds" href="http://szsbx.ebanhui.com" title="石嘴山市八小"> 石嘴山市八小 </a>
			</li>
			<li>
			<a class="asds" href="http://szsjx.ebanhui.com" title="石嘴山市九小"> 石嘴山市九小 </a>
			</li>
			<li>
			<a class="asds" href="http://szserserx.ebanhui.com" title="石嘴山市二十二小"> 石嘴山市二十二小 </a>
			</li>
			<li>
			<a class="asds" href="http://szserssx.ebanhui.com" title="石嘴山市二十三小"> 石嘴山市二十三小 </a>
			</li>
			<li>
			<a class="asds" href="http://szserssix.ebanhui.com" title="石嘴山市二十四小"> 石嘴山市二十四小 </a>
			</li>
			<li>
			<a class="asds" href="http://szserslx.ebanhui.com" title="石嘴山市二十六小"> 石嘴山市二十六小 </a>
			</li>
			<li>
			<a class="asds" href="http://szshnx.ebanhui.com" title="石嘴山市惠农小学"> 石嘴山市惠农小学 </a>
			</li>
			<li>
			<a class="asds" href="http://szshgzx.ebanhui.com" title="石嘴山市红果子小学"> 石嘴山市红果子小学 </a>
			</li>
			<li>
			<a class="asds" href="http://szsjbx.ebanhui.com" title="石嘴山市聚宝小学"> 石嘴山市聚宝小学 </a>
			</li>
			<li>
			<a class="asds" href="http://szsyzdx.ebanhui.com" title="石嘴山市燕子墩学校"> 石嘴山市燕子墩学校 </a>
			</li>
			<li>
			<a class="asds" href="http://szslhzx.ebanhui.com" title="石嘴山市礼和中心小学"> 石嘴山市礼和中心小学 </a>
			</li>
			<li>
			<a class="asds" href="http://szsmtx.ebanhui.com" title="石嘴山市庙台小学"> 石嘴山市庙台小学 </a>
			</li>
			<li>
			<a class="asds" href="http://szsyzdzx.ebanhui.com" title="石嘴山市燕子墩中心小学"> 石嘴山市燕子墩中心小学 </a>
			</li>
			<li>
			<a class="asds" href="http://szsjqx.ebanhui.com" title="石嘴山市简泉小学"> 石嘴山市简泉小学 </a>
			</li>
		</ul>
	
	</div>
	<div style="width:960px;float:left;">
	<div class="titaaa">中学:</div>
		<ul class="list_fltwo">
		<li>
		<a class="asds" href="http://szserz.ebanhui.com" title="石嘴山市二中"> 石嘴山市二中 </a>
		</li>
		<li>
		<a class="asds" href="http://szssiz.ebanhui.com" title="石嘴山市四中"> 石嘴山市四中 </a>
		</li>
		<li>
		<a class="asds" href="http://szsshiz.ebanhui.com" title="石嘴山市十中"> 石嘴山市十中 </a>
		</li>
		<li>
		<a class="asds" href="http://szsshiwz.ebanhui.com" title="石嘴山市十五中"> 石嘴山市十五中 </a>
		</li>
		<li>
		<a class="asds" href="http://szsshilz.ebanhui.com" title="石嘴山市十六中"> 石嘴山市十六中 </a>
		</li>
		<li>
		<a class="asds" href="http://szshnz.ebanhui.com" title="石嘴山市惠农中学"> 石嘴山市惠农中学 </a>
		</li>
		<li>
		<a class="asds" href="http://szswzz.ebanhui.com" title="石嘴山市尾闸中学"> 石嘴山市尾闸中学 </a>
		</li>
		<li>
		<a class="asds" href="http://szshmz.ebanhui.com" title="石嘴山市回民中学"> 石嘴山市回民中学 </a>
		</li>
		</ul>
	
	</div>

</div>
</div>
<?php
	$this->display('common/footer');
?>
