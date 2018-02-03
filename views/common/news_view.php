<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $itemview['subject']?>(e板会)</title>
<meta name="keywords" content="<?= $keywords?>" />
<meta name="description" content="<?= $description?>" />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/xiang.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" rel="stylesheet" />	
<script type="text/javascript">
<!--
	var sitecpurl ='#getsitecpurl()#';
//-->
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
</head>

<body>
<?php
$this->display('common/header');
	$itemkeyword=$itemview['tag'];
	$itemdescription=$itemview['note'];
	$keywords = (empty($itemkeyword)?$room['crlabel']:$itemkeyword);
	$description =  empty($itemdescription)?$room['message']:$itemdescription;
?>

<div class="xiangbg">
<div class="neis">
<p style="margin-top:18px;">当前位置：资讯详情</p>
</div>
</div>
<div class="mains">
<div class="topkug"></div>
<div class="makug" style="min-height:300px;">
<div class="neikug">
<h2 class="ybg">资讯详情</h2>
<h3 class="zhongtit"><?= $itemview['subject']?></h3>
<p style="text-align:center;color:#777777;">来源：<span style="margin-right:20px;"><?= $itemview['source'] == 0 ? 'e板会':$itemview['source']?></span>人气指数：<span style="margin-right:20px;"><?= $itemview['viewnum']?></span>时间：<span><?= date('Y-m-d H:i:s',$itemview['dateline'])?></span></p>
<div class="fontd">
<?= $itemview['message']?>
</div>
</div>
</div>
<div class="fltkug"></div>
</div>
<div style="text-align:center;clear:both;">
<?php
	$this->display('common/footer');
?>
</div>