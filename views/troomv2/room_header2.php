<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"  content="user-scalable=no">
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title><?= $room['crname']?></title>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?d=20160316001" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/course2.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common2.js?version=20150528001"></script>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20160415001"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/wussyu.css"/>

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
		var iframeHeight = Math.min(mainFrame.contentWindow.window.document.documentElement.scrollHeight, mainFrame.contentWindow.window.document.body.scrollHeight)+50;
	}else{
		var iframeHeight = 700;
	}
	iframeHeight = iframeHeight<700?700:iframeHeight;
	$(mainFrame).height(iframeHeight);
}
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xPhoto.js?v=3"></script>
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
			<div class="chead">
			<?php if($room['domain'] != 'bndx'){ ?>
				<div class="csubnav" style="float:right;"> | <a href="/homev2.html">个人中心</a></div>
			<?php }?>
				<div class="csubnav">
					<?php $curdomain = $this->uri->curdomain;
					$roomurl = empty($roominfo['fulldomain']) ? $roominfo['domain'].'.'.$curdomain : $roominfo['fulldomain'];
					?>
			 		<a href="http://<?= $roomurl ?>">网校首页</a>
					<!--<div class="classroombox" style="display:none;">
						<ul>
							<?php foreach($roomlist as $room) { ?>
									<?php if($room['crid'] != $room['crid']) { 
									$roomurl = 'http://'.$room['domain'].'.ebanhui.com/myroom.html';
									?>
										<li class="classroomitem"><a href="<?= $roomurl ?>"><?= ssubstrch($room['crname'],0,20) ?></a></li>
									<?php } ?>
							<?php } ?>
						</ul>
					</div>-->
				</div>
<div class="userinfo"><span style="float:left;">您好 ，<?= empty($user['realname'])?$user['username']:$user['username'].'('.$user['realname'].')'?></span>
				
				<div id="msgbox" class="fdsjres1">
					<a href="<?=geturl('myroom/msg')?>" class="fdsjre" target="mainFrame"><img style="float:left;" src="http://static.ebanhui.com/sns/images/liseng.jpg" /><span class="grehsr" style="display:none;">&nbsp;</span></a>
					<ul id="msgboxlist" class="user-drop-down" style="display:none;">
						<li><a href="<?=geturl('troom/msg/message')?>" target="mainFrame">新私信<span id="msgcount3"></span></a></li>
						<li><a href="<?=geturl('troom/msg/answer')?>" target="mainFrame">新回答<span id="msgcount2"></span></a></li>
                    </ul>
				</div>
				<a href="/logout.html" target='_self'>退出</a>　|
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