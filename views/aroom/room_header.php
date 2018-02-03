<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$room['crname']?></title>
<meta http-equiv="X-UA-Compatible" content="IE=7,IE=9">
<meta http-equiv="X-UA-Compatible" content="IE=7,9">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
<meta name="viewport"  content="user-scalable=no">
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css?v=20160414" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/common.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />


<link href="http://static.ebanhui.com/ebh/tpl/default/css/zTreeStyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.ztree-2.6.js"></script>
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
<div class="clay_topfixed">
	<div class="clay_topfixed_inner">
		<div class="ctoolbar">
			<div class="chead">
				<div class="csubnav">
					|
					<?php
						$Uproom = Ebh::app()->lib('Uproom');
						echo $Uproom->getUproom('|');
					?>

                                         <?php if(count($roomlist) > 1) { ?>
				 		 	<a id="myotherroom" class="roomlisticon"  href="<?= geturl('troom') ?>"><?= $room['crname'] ?></a>
                                         <?php } else { ?>
				 		 	<a  href="<?= geturl('troom') ?>"><?= $roomlist[0]['crname'] ?></a>
                                         <?php } ?>
					<div class="classroombox" style="display:none;">
						<ul>
                                                    <?php foreach($roomlist as $roomitem) {
                                                        if($roomitem['crid'] != $room['crid']) {
                                                     ?>
							<li class="classroomitem"><a href="<?= 'http://'.$roomitem['domain'].'.ebh.net/troom.html' ?>"><?= ssubstrch($roomitem['crname'],0,18) ?></a></li>
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
	<div class="cheadpic" style="position:relative;">
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
