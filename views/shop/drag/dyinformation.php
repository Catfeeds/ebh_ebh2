<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title>新闻资讯</title>
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
html{background:none;}
body {background:#f9f9f9;}
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
	<div style="width:960px; margin:0 auto;">
		
		
		
		
		
		
		
<div class="fonttwo">
<?php $itemid = $this->uri->itemid; ?>

<div class="rigxiang" style="overflow:hidden;width:930px; border:none;">
<!--列表页面-->
<h2 class="titzixun">全部资讯</h2>


<ul>
<?php if(empty($mitemlist)){?>
		<li  style="width:920px;text-align: center;border-bottom: 1px none #D1D1D1; margin-top: 40px;"><img src="http://static.ebanhui.com/ebh/citytpl/stores/images/wuzixun_03.jpg" /></li>
	<?php }else{ ?>
	<?php foreach($mitemlist as $value){
	$newsurl = geturl('dyinformation/'.$value['itemid']);
	?>
	<li class="navlie">
	<h2 class="navlietit"><a title="<?= $value['subject']?>" href="<?= $newsurl?>" target="_blank"><?= shortstr($value['subject'],50)?></a></h2>
	<p class="martopbtm">发表于：<?= date('Y-m-d H:i:s',$value['dateline'])?>  阅读(<?= $value['viewnum']?>)次  </p>
	<a href="<?= $newsurl ?>" target="_blank"><img width="130px" height="98px" src="<?=empty($value['thumb'])?'http://static.ebanhui.com/portal/images/defaultpic.jpg':$value['thumb']?>" /></a>
	<p class="tiwes"><?= shortstr($value['note'],350)?></p>
	<a href="<?= $newsurl ?>" class="yuedubtn" target="_blank">阅读全文</a>
	</li>
	<?php } ?>
<?php } ?>
</ul>
<!-- =-==== -->

<?=$pagestr?>
</div>
</div>
<!--增加客服系统sta-->
<div class="clear"></div>
<div class="kfxt">
    <?php $this->display('shop/drag/kf')?>
</div>
<!--增加客服系统end-->
		
		
		
		
		
		
		
	</div>
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




