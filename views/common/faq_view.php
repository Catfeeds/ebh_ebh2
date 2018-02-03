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
<h2 class="titre"><span>常见问题→问题详情</span></h2>
<div>

<h3 class="titwen"><?= $itemdetail['subject']?></h3>
<div class="jieess"><?= stripslashes($itemdetail['message'])?></div>

</div>
</div>
</div>
<div style="clear:both;"></div>
<?php
	$this->display('common/footer');
?>