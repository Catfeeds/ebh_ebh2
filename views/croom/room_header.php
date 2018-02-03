<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$roominfo['crname']?></title>
<meta name="keywords" content="$keywords" />
<meta name="description" content="$description" />
<meta name="viewport"  content="user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<!--$_SCONFIG[seohead]-->
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/common.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />


<link href="http://static.ebanhui.com/ebh/tpl/default/css/zTreeStyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.ztree-2.6.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
(function($) {
	//LineMark_Line = "ztree_line";
})(jQuery);
//-->
</SCRIPT>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/teacher.js"></script>
  

<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>
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
			<div style="color: #fff;font-size: 16px;font-weight: bold;left: 25%;position: absolute;top: 10px;"><?= $roominfo['crname']; ?></div>
			<div class="chead">
				<a class="stulogo" href="/"></a>
				<div class="csubnav">
					|<a target="_blank" href="http://www.ebanhui.com">e板会首页</a>|
				 		 	<a  href="<?=geturl('croom')?>"><?=$roominfo['crname']?></a>
					
				</div>
				
				<div class="userinfo">您好 ，<?=$user['username'].'('.$user['realname'].')&nbsp;&nbsp;';?>   <a href="<?=geturl('logout')?>" target='_self'>退出</a> </div>
			</div>
		</div>
	</div>
</div>
<div class="ctop">
	<div class="cheadpic">
	<?php
            $banner =  'http://static.ebanhui.com/ebh/tpl/2012/images/stu_head_pic.jpg';
            if(empty($room['banner'])) {
                if($roominfo['isschool'] == 0) 
                    $banner = 'http://static.ebanhui.com/ebh/tpl/2012/images/cloud-top.jpg';
                else 
                    $banner = 'http://static.ebanhui.com/ebh/tpl/2012/images/stu_head_pic.jpg';
            } else 
                $banner = $room['banner'];
            ?>
            <img src="<?= $banner ?>" />
	
	</div>
</div>
