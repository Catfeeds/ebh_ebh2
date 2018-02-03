<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php $systemsetting = Ebh::app()->room->getSystemSetting();?>
<meta name="keywords" content="<?=empty($systemsetting['metakeywords'])?'':$systemsetting['metakeywords']?>" />
<meta name="description" content="<?=empty($systemsetting['metadescription'])?'':$systemsetting['metadescription']?>" />
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title><?= $room['crname'] ?></title>
<meta name="viewport"  content="user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=7,IE=9">  
<meta http-equiv="X-UA-Compatible" content="IE=7,9">  
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css?v=20160414" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/common.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?version=20160128001" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/teacher.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/course2.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/swfobject.js"></script>
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
	//私信box
	var msgDelayTime;
	$("#msgbox").hover(function(){
		clearTimeout(msgDelayTime);
		msgDelayTime = setTimeout(function(){
			$("#msgbox").attr("class", "fdsjres");
			$("#msgboxlist").slideDown("fast");
		}, 200);
	},function(){
		clearTimeout(msgDelayTime);
		msgDelayTime = setTimeout(function(){
			$("#msgbox").attr("class", "fdsjres1");
			$("#msgboxlist").slideUp("fast");
		}, 200);
	});
	msgcount();	
	setInterval("msgcount()",30000);
});
//私信计数
function msgcount() {
	//判断用户是否登录，如果没有登录不再获取私信计数
	var auth = getcookie('ebh_auth');
	if (auth == ''){
		return false;
	}
	$.ajax({
		url:'/troom/msg/getcount.html?d='+Math.random(),
		dataType:"json",
		success:function(data){			
			if(data['total'] > 0){
				$(".grehsr").html(data["total"]);
				$(".grehsr").show();
			} else {
				$(".grehsr").hide();
			}
			
			var msgcount3 = 0;			
			//新私信和系统消息合并
			if (typeof(data['type_1']) != "undefined") msgcount3 += data['type_1'];
			if (typeof(data['type_3']) != "undefined") msgcount3 += data['type_3'];
			
			if(msgcount3 > 0) $("#msgcount3").html('&nbsp;('+msgcount3+')');//新私信
			else $("#msgcount3").html('');
			if(data['type_5'] > 0) $("#msgcount5").html('&nbsp;('+data['type_5']+')');//新提问
			else $("#msgcount5").html('');
			if(data['type_2'] > 0) $("#msgcount2").html('&nbsp;('+data['type_2']+')');//新回答
			else $("#msgcount2").html('');
			if(data['type_4'] > 0) $("#msgcount4").html('&nbsp;('+data['type_4']+')');//新回答
			else $("#msgcount4").html('');
		}
	});
}
//私信发送成功
function showSendSuccess()
{
	$.showmessage({
		message:'发送成功！',
		callback :function(){
			window.H.get('wxDialog').exec('close');
	}});
}
//私信发送失败
function showSendFail()
{
	$.showmessage({message:'发送失败'});
}
</script>
<!--[if lte IE 6]>  
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/DD_belatedPNG_0.0.7a.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('.bottom,.cservice img,.roomtit,.ui_ico,img,background');
</script>
<![endif]-->
</head>
<body>
<?php $hszcrid = 10420; ?>
<div class="clay_topfixed">
	<div class="clay_topfixed_inner">
		<div class="ctoolbar">
			<div style="color: #b6b9be;font-size: 16px;font-weight: bold;left: 25%;position: absolute;top: 10px;"></div>
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
				 		 	<a  href="<?= geturl('troom') ?>"><?= !empty($roomlist)?$roomlist[0]['crname']:'' ?></a>
                                         <?php } ?>
					<?php if($room['uid'] == $user['uid'] && ($room['isschool'] == 3 || $room['isschool'] == 6 || $room['isschool'] == 7) ) { ?>
				 	|<a href="http://<?= empty($room['fulldomain']) ? $room['domain'].'.ebh.net' : $room['fulldomain']?>/aroomv2.html" name="">管理平台</a>
				 	<?php } ?>

					<div class="classroombox" style="display:none;">
						<ul>
                                                    <?php foreach($roomlist as $roomitem) { 
                                                        if($roomitem['crid'] != $room['crid']) {
															$roomurl = empty($roomitem['fulldomain']) ? $roomitem['domain'].'.ebh.net' : $roomitem['fulldomain'];
                                                     ?>
							<li class="classroomitem"><a href="<?= 'http://'.$roomurl.'/troom.html' ?>"><?= ssubstrch($roomitem['crname'],0,18) ?></a></li>
                                                        <?php } ?>                                                                       
                                                    <?php } ?>
						</ul>
					</div>
				</div>                
                <div class="userinfo"><span style="float:left;">您好 ，<?= $user['username'].'('.$user['realname'].')'?></span>
                <div id="msgbox" class="fdsjres1">
					<a href="<?=geturl('troom/msg')?>" class="fdsjre" target="mainFrame"><img style="float:left;" src="http://static.ebanhui.com/sns/images/liseng.jpg" /><span class="grehsr" style="display:none;">&nbsp;</span></a>
					<ul id="msgboxlist" class="user-drop-down" style="display:none;">
						<li><a href="<?=geturl('troom/msg/message')?>" target="mainFrame">新私信<span id="msgcount3"></span></a></li>
						<li><a href="<?=geturl('troom/msg/question')?>" target="mainFrame">新问题<span id="msgcount5"></span></a></li>
						<li><a href="<?=geturl('troom/msg/answer')?>" target="mainFrame">新回答<span id="msgcount2"></span></a></li>
						<li><a href="<?=geturl('troom/msg/review')?>" target="mainFrame">新评论<span id="msgcount4"></span></a></li>
                    </ul>
				</div>
                <a href="<?= geturl('logout') ?>" target='_self'>退出</a> </div>
			</div>
		</div>
	</div>
</div>
<div class="ctop">
	<div class="cheadpic" style="position:relative;">
            <?php
            $banner = 'http://static.ebanhui.com/tpl/2012/images/stu_head_pic.jpg';
            if(empty($room['banner'])) {
                if($room['isschool'] == 0) 
                    $banner = 'http://static.ebanhui.com/ebh/tpl/2012/images/cloud-top.jpg?v=20160414';
                else 
                    $banner = 'http://static.ebanhui.com/ebh/tpl/2012/images/stu_head_pic.jpg';
            } else 
                $banner = $room['banner'];
            ?>
            <img src="<?= $banner ?>" />
			<div class="tit fl">
				<span class="spans" style="left:180px; top:20px;"><?=$room['crname']?></span>
			</div>
    </div>
	</div>
</div>