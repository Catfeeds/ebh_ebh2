<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<style type="text/css">
.topebroll {
	background: url(http://static.ebanhui.com/ebh/tpl/2012/images/topgb511.jpg) repeat-x scroll center top transparent;
    height: 120px;
    min-width: 960px;
    overflow: hidden;
    width: auto;
}
.toplogo {
    float: left;
    height: 53px;
    margin-top: 22px;
    width: 302px;
	position: relative;
	left: 0px;
}
.toplowen {
	width:218px;
	height:26px;
	float:left;
	position:relative;
	margin-top:35px;
	left:76px;
}
</style>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"  content="user-scalable=no">
<?php if(empty($title))
	$title = '支付中心';?>
<title><?=$title?></title>
<meta name="keywords" content="开通e板会服务" />
<meta name="description" content="开通e板会服务" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
</head>
<body>
<div class="topebroll">
<div style="width:960px; margin:0 auto; position:relative">
<div class="toplogo">
<?php if(empty($hideebhinfo)){
	$img1 = 'http://static.ebanhui.com/ebh/tpl/2016/images/payimg.png';
	$img2 = 'http://static.ebanhui.com/ebh/tpl/2012/images/toplogkai0307.jpg';
}else{
	$img1 = 'http://static.ebanhui.com/ebh/tpl/2014/images/ibuy_top_jx_1.png';
	$img2 = 'http://static.ebanhui.com/ebh/tpl/2014/images/ibuy_top_jx_2.png';
}
?>
<a href="javascript:void(0)" style="cursor:auto;"><img src="<?=$img1?>" /></a>
</div>
</div>
</div>