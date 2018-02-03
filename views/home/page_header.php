<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= empty($subtitle) ? $this->get_title() : $subtitle.'-'. $this->get_title() ?></title>
<meta name="keywords" content="<?= empty($subkeywords) ? $this->get_keywords() : $subkeywords ?>" />
<meta name="description" content="<?= empty($subdescription) ? $this->get_description() : $subdescription?>" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css<?=getv()?>" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css<?=getv()?>" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/2014/css/werke.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<script type="text/javascript">
<!--
	$(function(){
		try{
			if($.isFunction(top.resetmain)){
				top.resetmain();
			}
		}catch(e){
				}

	});
//-->
</script>
</head>
<body>
<?php //var_dump($notop);?>
<script>

$(function(){
	<?php if(empty($notop)){?>
	if (top.location == self.location) {
		setCookie('ebh_refer',encodeURIComponent(self.location),10,'/','.<?=$this->uri->curdomain?>');
		top.location='/home.html';
    }
	<?php }?>
});
</script>