<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php $systemsetting = Ebh::app()->room->getSystemSetting();?>
<meta name="keywords" content="<?=empty($systemsetting['metakeywords'])?'':$systemsetting['metakeywords']?>" />
<meta name="description" content="<?=empty($systemsetting['metadescription'])?'':$systemsetting['metadescription']?>" />
<!-- 12.02.2016 -->
<meta content="width=1000, user-scalable=no,,target-densitydpi=300;" name="viewport"/>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title><?=$room['crname']?></title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />

    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20160913001"/>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css?v=20160414" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=getv()?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/aroomv2-style.css<?=getv()?>"/>

<link href="http://static.ebanhui.com/ebh/tpl/default/css/zTreeStyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.ztree-2.6.js"></script>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css" />
	<script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
(function($) {
	//LineMark_Line = "ztree_line";
})(jQuery);
//-->
</SCRIPT>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/teacher.js"></script>
<script type="text/javascript">
$(function(){
	    var myroom =$("#myotherroom");
		var timeout = null;


	myroom.mouseover(function(){
		clearTimeout(timeout);
		$(this).addClass("acurrent");
		$(".classroombox").slideDown();
	}).mouseout(function(){
		clearTimeout(timeout);
		var _this = this;
		timeout = setTimeout(function(){
			$(".classroombox").slideUp("slow",function(){
				$(_this).removeClass("acurrent");
			});
		},500);
	});
	$(".classroombox").mouseover(function(){
		clearTimeout(timeout);
	}).mouseout(function(){
		clearTimeout(timeout);
		var _this = myroom;
		timeout = setTimeout(function(){
			$(".classroombox").slideUp("slow",function(){
				$(_this).removeClass("acurrent");
			});
		},500);
	});




	})

</script>
<!--[if lte IE 6]>
<script type="text/javascript" src="/static/js/DD_belatedPNG_0.0.7a.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('.bottom,.cservice img,.roomtit,.ui_ico,img,background');
</script>
<![endif]-->

</head>
<body>
<a name="areatop" style="line-height:0;height:0;width:0;"></a>
<div class="clay_topfixed">
	<div class="clay_topfixed_inner">
		<div class="ctoolbar">
			<div class="chead">
				<a href="/" class="homepage-1">网校首页</a>
				<div class="csubnav">
					|
					<?php
						$Uproom = Ebh::app()->lib('Uproom');
						echo $Uproom->getUproom('|');
						$troomurl = gettroomurl($room['crid']);
					?>

                                         <?php if(count($roomlist) > 1) { ?>
				 		 	<a id="myotherroom" class="roomlisticon"  href="<?= $troomurl ?>"><?= $room['crname'] ?></a>
                                         <?php } else { ?>
				 		 	<a  href="<?= $troomurl ?>"><?= $roomlist[0]['crname'] ?></a>
                                         <?php } ?>
					<div class="classroombox" style="display:none;">
						<ul>					
												<?php if(!empty($roomlist)) {?>
                                                    <?php foreach($roomlist as $roomitem) {
                                                        if($roomitem['crid'] != $room['crid']) {
															$roomurl = empty($roomitem['fulldomain']) ? $roomitem['domain'].'.ebh.net' : $roomitem['fulldomain'];
                                                     ?>
							<li class="classroomitem"><a href="<?= 'http://'.$roomurl.$troomurl?>"><?= ssubstrch($roomitem['crname'],0,18) ?></a></li>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
						</ul>
					</div>
				</div>
                                <div class="userinfo">您好 ，<?= $user['username'].'('.$user['realname'].')'?>&nbsp;&nbsp;   <a href="<?= geturl('logout') ?>" target='_self'>退出</a> </div>
			</div>

			</div>
		</div>
	</div>
<div class="ctop">
	<div class="cheadpic" style="position:relative; overflow:hidden">
		<?php
            $banner =  '/static/tpl/2012/images/stu_head_pic.jpg';
            if(empty($room['banner'])) {
                if($room['isschool'] == 0)
                    $banner = 'http://static.ebanhui.com/ebh/tpl/2012/images/cloud-top.jpg';
                else
                    $banner = 'http://static.ebanhui.com/ebh/tpl/2012/images/stu_head_pic.jpg?v=20160414';
            } else
                $banner = $room['banner'];
            ?>
            <img src="<?= $banner ?>" />
			<div class="tit fl">
				<span class="spans" style="left:180px; top:20px;"><?=$room['crname']?></span>
			</div>
	</div>
</div>
