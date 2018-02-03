<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title>网校简介</title>
</head>

<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2014/css/zjdfysxy.css"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/zzys.css?v=20150413"/>

<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?version=20150827001" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/drag/style.css?v=2015121401"/>
<style>
.see{ background: #fff;border: 1px solid #e2e2e2;display: inline-block;left: 10px;padding: 10px 20px 20px;margin-top:10px;width: 919px;}
.see .title{ font-size:24px; color:#333; text-align:center;}
.see .p1s{ font-size:14px; line-height:24px; padding-top:15px; text-indent:24px;}
#actor p{
	display:none!important;
}
.navlie {
	width: 920px;
	clear: #555;
	height: 220px;
	float: left;
	}
	.navlie .navlietit {
	height: 42px;
	line-height: 42px;
	border-bottom: dashed 1px #e7e7e7;
	font-size: 20px;
	font-family: "Microsoft YaHei";
	font-weight: bold;
}
.martopbtm {
	margin: 10px 0;
}
.navlie img {
	float: left;
}
.navlie .tiwes {
	width: 775px;
	margin-left: 15px;
	float: left;
	font-size: 14px;
	display: inline;
	line-height: 1.8;
}
.yuedubtn {
	float: right;
	font-size: 14px;
	display: block;
	width: 60px;
	margin-right: 10px;
	height: 24px;
	line-height: 24px;
	background: url(http://static.ebanhui.com/portal/images/quanico.jpg) no-repeat left center;
	padding-left: 20px;
}
html,body {background:#f9f9f9;}
.dizitu{display:inline-block; height:auto !important;}
.zzind .lefzong{ width:960px;}
.lefzong .dizitu{ width:928px;}
.baidutu{width:926px;}
.lefzong .dizitu li{width:900px;}
.fontxian{ margin-top:10px; margin-bottom:15px;}
.titbgt {
    background:url("http://static.ebanhui.com/ebh/citytpl/stores/images/titbg1123.jpg") no-repeat;
    font-size: 14px;
    height: 27px;
    line-height: 27px;
    margin-left: 5px;
    padding-left: 10px;
}
.naver>p{font-size:14px;letter-spacing: 1pt;}
.zwnr{
	text-align: center;
	padding: 135px 0px;
}
</style>

<body>
<?php $this->display('shop/drag/topbar');?>

    <div class="banner" style="background:none;height:auto">
	<?php
		$this->widget('ad_widget', $adlist, array('_id' => 'actor', '_width' => 960, '_height' => 'auto', 'default' => 'http://static.ebanhui.com/ebh/tpl/default/images/toptuad0411.jpg'));
		?>
	</div>
	<div style="clear:both;"></div>
		<?php $navlib = Ebh::app()->lib('Navigator');
		$navlib->getnavigator();
		?>
	<div style="clear:both;"></div>
<div class="fonttwo">
<?php $itemid = $this->uri->itemid; ?>

<div class="rigxiang" style="overflow:hidden;margin:0; border:1px solid #fff;">
<!--列表页面-->
<div class="mass">
<div class="rigku">
<div class="rigtop">
</div>
<div class="rigmain">
<div class="naver">
<h2 class="titbgt" style="color: #103ba8;font-weight:bold;"><?= $room['crname']?></h2>
<p class="tongbjs" style="text-indent:32px;font-size:14px;letter-spacing: 1pt;"><?= $room['summary']?></p>

<h2 class="titbgt" style="font-size:12px;font-weight:bold;color:#000;">详情介绍</h2>

<?php if(!empty($classroommess['message'])){
	echo str_replace('\\"','"',$classroommess['message']);
	}else{?>
<div class="zwnr"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/hmyxgnr.jpg"/></div>
<?php }?>
</div>

</div>
<div class="rigbottom"></div>
</div>
</div>
<div style="text-align:center;clear:both;">

</div>
</div>
<!-- =-==== -->
</div>
<!--增加客服系统sta-->
<div class="clear"></div>
<div class="kfxt">
    <?php $this->display('shop/drag/kf')?>
</div>
<!--增加客服系统end-->
<script>
var tologin = function(url){
		url = url.replace('__url__',encodeURIComponent(location.href));
		location.href=url;
	}
	var toregister = function(url){
		url = url.replace('__url__',encodeURIComponent(location.href));
		location.href=url;
	}
</script>

<?php $this->display('common/footer')?>




