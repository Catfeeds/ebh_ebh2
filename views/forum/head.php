<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"  content="user-scalable=no">
<!-- 12.02.2016 -->
<meta content="width=1000, user-scalable=no,target-densitydpi=300;" name="viewport"/>
<?php $systemsetting = Ebh::app()->room->getSystemSetting();?>
<meta name="keywords" content="<?=empty($systemsetting['metakeywords'])?'':$systemsetting['metakeywords']?>" />
<meta name="description" content="<?=empty($systemsetting['metadescription'])?'':$systemsetting['metadescription']?>" />
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title><?=$page_title?></title>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?d=20160316001" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/course2.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=2016060131"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common2.js?version=20160606001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js"></script>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=getv()?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css<?=getv()?>"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/wussyu.css<?=getv()?>"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css?v=20160913002"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/mall/css/popupwindow.css"/>

<!-- troom 老版本的js -->
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<!-- troom 老版本的js -->
<script>
var resetmain = function(){
	var mainFrame = document.getElementById("mainFrame");
	if(mainFrame.contentWindow.window.document.documentElement && mainFrame.contentWindow.window.document.body){
		var iframeHeight = Math.min(mainFrame.contentWindow.window.document.documentElement.scrollHeight, mainFrame.contentWindow.window.document.body.scrollHeight)+100;
	}else{
		var iframeHeight = 450;
	}
	if(isFirefox=navigator.userAgent.indexOf("Firefox")>0){ 
		var mainH =  mainFrame.contentWindow.document.getElementById('Main');
		if(mainH){
			iframeHeight += 618;
		} 
  }
	iframeHeight = iframeHeight<450?450:iframeHeight;
	
	$(mainFrame).height(iframeHeight);
}

</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xPhoto.js?v=3"></script>
<style>
.userinfo .user-drop-down a, .userinfo .user-drop-down a:visited ,.userinfo .user-drop-down a:hover {
    color: #545454;
    text-decoration: none;
}
</style>
</head>

<body style="position:relative;left:0px">
<!--[if lte IE 6]>  
<script type="text/javascript" src="/static/js/DD_belatedPNG_0.0.7a.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('.bottom,.cservice img,.roomtit,.ui_ico,.kewate span,img,background,.lischool span,');
</script>
<![endif]-->
<div class="clay_topfixed">
	<div class="clay_topfixed_inner">
		<div class="ctoolbar">
			<div style="color: #b6b9be;font-size: 16px;font-weight: bold;left: 25%;position: absolute;top: 10px;"></div>
			<div class="chead" style="width:1000px;">
				<a href="/" class="homepage-1">网校首页</a>
				<div class="csubnav">
				| <a  href="<?= geturl('troomv2') ?>"><?=$room['crname']?></a>
				<?php if($room['uid'] == $user['uid'] && ($room['isschool'] == 3 || $room['isschool'] == 6 || $room['isschool'] == 7) ) { ?>
				|<a href="http://<?= empty($room['fulldomain']) ? $room['domain'].'.ebh.net' : $room['fulldomain']?>/aroomv2.html" name="">管理平台</a>
				<?php } ?>
                |<a href="<?php echo geturl('homev2/default/index')?>">个人中心</a>
				</div>
				<div class="userinfo">
				<span style="float:left;">您好 ，<?= empty($user['realname'])?$user['username']:$user['username'].'('.$user['realname'].')'?></span>
                <div id="msgbox" class="fdsjres1">
                    <?php if(isset($head) && $head==1){?>
                        <a href="<?=geturl('troomv2')?>?url=troomv2/msg.html" class="fdsjre" target="_blank"><img style="float:left;" src="http://static.ebanhui.com/sns/images/liseng.jpg" /><span class="grehsr" style="display:none;">&nbsp;</span></a>
                    <?php }else{?>
					<a href="<?=geturl('troomv2/msg')?>" class="fdsjre" target="mainFrame"><img style="float:left;" src="http://static.ebanhui.com/sns/images/liseng.jpg" /><span class="grehsr" style="display:none;">&nbsp;</span></a>
                    <?php }?>
					<ul id="msgboxlist" class="user-drop-down" style="display:none;">
						<li><a href="<?=geturl('troomv2/msg/message')?>" target="mainFrame">新私信<span id="msgcount3"></span></a></li>
						<li><a href="<?=geturl('troomv2/msg/question')?>" target="mainFrame">新问题<span id="msgcount5"></span></a></li>
						<li><a href="<?=geturl('troomv2/msg/answer')?>" target="mainFrame">新回答<span id="msgcount2"></span></a></li>
						<li><a href="<?=geturl('troomv2/msg/review')?>" target="mainFrame">新评论<span id="msgcount4"></span></a></li>
						<li><a href="<?=geturl('troomv2/notice/send')?>" target="mainFrame">发送通知</a></li>
						<li><a href="<?=geturl('troomv2/msg/send')?>" target="mainFrame">发送私信</a></li>
                    </ul>
				</div>
				<a href="/logout.html" target='_self'>退出</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="ctop">
	<div class="cheadpic">
	<?php
		if(!empty($roominfo['banner']))
			$bannerurl = $roominfo['banner'];
		else if($roominfo['isschool'] == 0)
			$bannerurl = 'http://static.ebanhui.com/ebh/tpl/2012/images/cloud-top.jpg';
		else
			$bannerurl = 'http://static.ebanhui.com/ebh/tpl/2012/images/stu_head_pic.jpg';

	?>
	<img src="<?= $bannerurl ?>" />
	</div>
</div>
<div style="position:relative; width:980px; margin:0 auto; height:0px;">
		<div class="titles fl">
			<span class="spans" style="left:130px; top:-40px; *top:-40px;"><?=$room['crname']?></span>
		</div>
</div>