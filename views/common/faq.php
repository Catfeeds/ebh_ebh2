<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $codepath = $this->uri->codepath;
	if($codepath=='help'){
		$title = '首页'; 
	}elseif($codepath=='faq'){
		$title = '常见问题';
	}elseif($codepath=='service'){
		$title = '联系客服';
	}
?>
<title><?= $title?>-帮助中心</title>
<meta name="keywords" content="$keywords" />
<meta name="description" content="$description" />
<script src="http://static.ebanhui.com/ebh/js/jquery.js" type="text/javascript"></script>
<script src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" />
</head>
<body>
<?php
	$this->display('common/helps_common');
?>
<div class="details">

<?php
	$this->display('common/helps_left');
?>
<div class="rigku">
<h2 class="titre"><span>帮助中心→常见问题</span></h2>

<?php foreach($itemlist as $value){ ?>
<div class="wenti">
<h3 class="wentit"><a href="<?= geturl('help/'.$value['itemid'])?>"><?= shortstr($value['subject'],84)?></a></h3>
<p><span><?= shortstr($value['note'],96)?></span><a href="<?= geturl('help/'.$value['itemid'])?>">[阅读全文]</a></p>
</div>
<?php } ?>
</div>

<?=$page?>
</div>
<div style="clear:both;"></div>
<?php
	$this->display('common/player');
	$this->display('common/footer');
?>
</body>
</html>
