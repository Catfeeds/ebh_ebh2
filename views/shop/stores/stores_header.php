<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
	$catelib = EBH::app()->lib('Category');
	$cate = $catelib -> getCate();
	$crid = $room['crid'];
	$title= $this->input->get('q');
	$catepath = $this->uri->codepath;
	if($catepath == 'platform'){
		$subtitle = '平台简介';
	}elseif($catepath == 'thteam'){
		$subtitle = '师资团队';
	}elseif($catepath == 'askquestion'){
		$subtitle = '答疑专区';
	}elseif($catepath == 'studyline'){
		$subtitle = '学习大纲';
	}elseif($catepath == 'contacts'){
		$subtitle = '联系方式';
	}elseif($catepath == 'dyinformation'){
		$subtitle = '动态资讯';
	}else{
		$subtitle = '首页';
	}
	$keywords = (empty($itemkeyword)?$room['crlabel']:$itemkeyword);
	$description =  empty($itemdescription)?$room['summary']:$itemdescription;
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title><?= $subtitle?>-<?= $room['crname'] ?></title>
<meta name="keywords" content="<?=empty($systemsetting['metakeywords'])?$keywords:$systemsetting['metakeywords']?>" />
<meta name="description" content="<?=empty($systemsetting['metadescription'])?$description:$systemsetting['metadescription']?>" />
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/citytpl/stores/css/yun.css" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" rel="stylesheet" />	

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
 <script type="text/javascript">
<!--
function searchTip(){
	var title = $("#title").val();
		title = (title=='搜索本网校内容'?'':title);
	var url = '/studyline.html?q='+title;
 // alert(url);
	window.location.href=url;
}	
//-->
</script>
</head>
<body>
<?php $this->display('common/public_header');?>
<?php $indexclass = empty($catepath)?'class="dilan"':'style="color: #9a9b9d;"';?>
<div class="waibg">

<?php 
  $itemlib = EBH::app()->lib('Items');
  $item = $itemlib->getItemdetail();
?>
 <?php if(empty($item['thumb'])){ ?>
<div class="waisou" style="background:url('http://static.ebanhui.com/ebh/citytpl/stores/images/gxheader.jpg') no-repeat; width:960px; height:74px;">
<?php }else{ ?>
<div class="waisou" style="background:url('<?= $item['thumb']?>') no-repeat; width:960px; height:74px;">
<?php } ?>

	<div class="lefdatit">
	<a style="color: #939393;font-family: tahoma;font-size: 24px;font-weight: bold; text-decoration:none;" href="/"><?= $room['crname']?></a>
	<?php if(!empty($room['weibosina'])){?>
	<a href="$_SGLOBAL['room']['weibosina']" target="_blank"><img src="http://static.ebanhui.com/ebh/citytpl/stores/images/weibo0121.jpg"></a>
	<?php }else{ ?>
	<a href="http://weibo.com/ebanhui" target="_blank"><img src="http://static.ebanhui.com/ebh/citytpl/stores/images/weibo0121.jpg"></a>
	<?php } ?>
	</div>
	<div class="sulo">
	  <input class="kuangbg" name="title" type="text" value="<?= $title?str_replace('\'\'','\'',$title):'搜索本网校内容'?>" onblur="if($.trim(this.value).length==0){this.value='搜索本网校内容';this.style.color='#A5A5A5';}" onfocus="if(this.value=='搜索本网校内容')this.value='';this.style.color='#000';" id="title" /><a onclick="searchTip(title)" href="javascript:searchTip(title);" style="color:#fff;text-decoration: none;" class="solobtn">搜索</a>
	</div>
</div>
<?php if(count($cate)==4){ ?>
	<div class="topva">
	<ul class="liste">
<?php }elseif(count($cate)==5){?>
	<div class="topvan">
	<ul class="lister">
<?php }else{ ?>
	<div class="topvans">
	<ul class="listers">
<?php } ?>

	<li class="autuder"><a <?= $indexclass?> href="/">首页</a></li>

	<?php foreach($cate as $catvalue){ ?>	
		<li class="autuder"><a <?= ($catepath==$catvalue['code']||$catepath==$catvalue['catid']) ?'class="dilan"':'style="color: #9a9b9d;"'?> href="<?=geturl($catvalue['code']) ?>" title="<?= $catvalue['name']?>"><?= $catvalue['name']?></a></li>
	<?php } ?>
	</ul>
	</div>
</div>
</div>