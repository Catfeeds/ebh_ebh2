<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
	$codepath = $this->uri->codepath;
	if($codepath == 'aboutus'){
		$title='关于e板会';
	}elseif($codepath == 'contact'){
		$title='联系我们';
	}elseif($codepath == 'copyright'){
		$title='版权申明';
	}elseif($codepath == 'terms'){
		$title='服务条款';
	}elseif($codepath == 'join'){
		$title='合作加盟';
	}elseif($codepath == 'job'){
		$title='人才招聘';
	}elseif($codepath == 'link'){
		$title='友情链接';
	}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $title?>-e板会-开启云教学互动时代</title>
<meta name="keywords" content="$keywords" />
<meta name="viewport"  content="user-scalable=no">
<meta name="description" content="$description" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/list.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/page.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="l_head">
  <div class="l_top">
  	<div class="l_logo"><a href="/" title="e板会"><img src="http://static.ebanhui.com/ebh/tpl/default/images/list_logo.png" alt="e板会" /></a></div>
    <div class="lit_bt"></div>
    <div class="list_nav">
		<p><a href="<?= geturl('aboutus')?>">关于我们</a></p>
	</div>
  </div>
</div>
<div class="pagebody">
	<div class="pagetop"></div>
	<div class="pagecontent">
	  <div class="pageleft">

	  	<div class="pagemenu">
	  	  <ul>
		  	<li><a href="<?= geturl('aboutus')?>" title="关于e板会"><?php if($thecat[0]['code'] == 'aboutus'){?><b>关于e板会</b><?php }else{ ?>关于e板会<?php } ?></a></li>
			<li><a href="http://www.svnlan.com/enterprise/contactus.php" title="联系我们" target="_blank"><?php if($thecat[0]['code'] == 'contact'){ ?><b>联系我们</b><?php }else{ ?>联系我们<?php } ?></a></li>
		  </ul>
	  	</div>
		<div class="pagemenu">
	  	  <ul>
		  	<li><a href="<?= geturl('copyright')?>" title="版权申明"><?php if($thecat[0]['code'] == 'copyright'){?><b>版权申明</b><?php }else{ ?>版权申明<?php } ?></a></li>
			<li><a href="<?= geturl('terms')?>" title="服务条款"><?php if($thecat[0]['code'] == 'terms'){ ?><b>服务条款</b><?php }else{ ?>服务条款<?php } ?></a></li>
		  </ul>
	  	</div>
		<div class="pagemenu">
	  	  <ul>
		  	<li><a href="http://join.ebanhui.com" target="_blank" title="合作加盟"><?php if($thecat[0]['code'] == 'join'){ ?><b>合作加盟</b><?php }else{ ?>合作加盟<?php } ?></a></li>
		  	<li><a href="<?= geturl('job')?>" title="人才招聘"><?php if($thecat[0]['code'] == 'job'){ ?><b>人才招聘</b><?php }else{ ?>人才招聘<?php } ?></a></li>
		  	<li><a href="<?= geturl('link')?>" title="友情链接"><?php if($thecat[0]['code'] == 'link'){ ?><b>友情链接</b><?php }else{ ?>友情链接<?php } ?></a></li>
		  </ul>
	  	</div>
	  </div>