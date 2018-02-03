<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $systemsetting = Ebh::app()->room->getSystemSetting();?>
<meta name="keywords" content="<?=empty($systemsetting['metakeywords'])?'':$systemsetting['metakeywords']?>" />
<meta name="description" content="<?=empty($systemsetting['metadescription'])?'':$systemsetting['metadescription']?>" />
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title>个人中心</title>
<meta name="viewport">
<!-- 12.02.2016 -->
<meta content="width=1000, user-scalable=no,target-densitydpi=300;" name="viewport"/>
<meta http-equiv="X-UA-Compatible" content="IE=7,IE=9">  
<meta http-equiv="X-UA-Compatible" content="IE=7,9">  
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2016/css/personal.css<?=getv()?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css<?=getv()?>" />


<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/course2.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common2.js?version=20150528001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?version=20160308001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css<?=getv()?>" />

<script type="text/javascript" src="http://static.ebanhui.com/js/js-xss/xss.min.js?version=20160827001"></script>

	<?php
	$room = Ebh::app()->room->getcurroom();
	$domain = empty($room['domain'])?'':$room['domain'];
        $room['crid'] = empty($room['crid'])?0:$room['crid'];
        if(empty($room['crid'])){
        	$is_zjdlr = false;
        	$is_newzjdlr = false;
        }else{
	        $appsetting = Ebh::app()->getConfig()->load('othersetting');
	        $appsetting['zjdlr'] = !empty($appsetting['zjdlr']) ? $appsetting['zjdlr'] : 0;
	        $appsetting['newzjdlr'] = !empty($appsetting['newzjdlr']) ? $appsetting['newzjdlr'] : array();
	        $is_zjdlr = ($room['crid'] == $appsetting['zjdlr']) || (in_array($room['crid'],$appsetting['newzjdlr']));
	        $is_newzjdlr = in_array($room['crid'],$appsetting['newzjdlr']);        	
        }
	?>
	<script>
		var domain = "<?= $domain ?>";
		if ($is_zjdlr) {
			$('html').css('background','none');
		}
	</script>
</head>
<?php
if(!empty($hidetop))
	;
else{?>
<body style="position:relative;left:0px">
<div class="clay_topfixed">
	<div class="clay_topfixed_inner">
		<div class="ctoolbar">
			<div style="color: #b6b9be;font-size: 16px;font-weight: bold;left: 25%;position: absolute;top: 10px;"></div>
			<div class="chead">
				<div class="userinfo">
				<span style="float:left;">您好 ，<?= empty($user['realname'])?$user['username']:$user['username'].'('.$user['realname'].')'?></span> 
				<a href="/logout.html" target='_self' style="margin-left:10px">退出</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="ctop">
	<div class="cheadpic">
	<img src="http://static.ebanhui.com/ebh/tpl/2016/images/stu_head_pic.jpg?v=20160415" />
	</div>
</div>
<?php }?>