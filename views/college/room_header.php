<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $systemsetting = Ebh::app()->room->getSystemSetting();
if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title><?= !empty($room['crname'])?$room['crname']:'';?></title>
<meta content="width=1000, user-scalable=no" name="viewport"/>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?d=20160316001" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/course2.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common2.js?version=20161130001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js"></script>
<script src="http://static.ebanhui.com/sns/js/layer/layer.min.js"></script>
<script src="http://static.ebanhui.com/sns/js/layer/extend/layer.ext.js"></script>


<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=getv()?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css<?=getv()?>"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css<?=getv()?>"/>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/aroomv2-style.css"/>
<style>
.userinfo .user-drop-down a, .userinfo .user-drop-down a:visited ,.userinfo .user-drop-down a:hover {
    color: #545454;
    text-decoration: none;
}
</style>
<script type="text/javascript">
/***预览图片***/
function photosShow(start,arr){
	 var jsonObj = {
			"title": "图片预览", //相册标题
			"id": 123, //相册id
			"start": start, //初始显示的图片序号，默认0
			"data":arr
		};
	layer.photos({
		photos: jsonObj,
		tab: function(pic, layero){
			// console.log(pic) //当前图片的一些信息
		}
	})
}
/***监听iframe滚动事件***/
window.onscroll = function(){
	if(typeof($('#mainFrame')[0].contentWindow.callScroll) == 'function'){
		$('#mainFrame')[0].contentWindow.callScroll();
	}
}
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
	setInterval("msgcount()",120000);
});
<?php
	$roominfo = Ebh::app()->room->getcurroom();
	$other_config = Ebh::app()->getConfig()->load('othersetting');
	$other_config['zjdlr'] = !empty($other_config['zjdlr']) ? $other_config['zjdlr'] : 0;
	$other_config['newzjdlr'] = !empty($other_config['newzjdlr']) ? $other_config['newzjdlr'] : array();
	$is_zjdlr = ($roominfo['crid'] == $other_config['zjdlr']) || (in_array($roominfo['crid'],$other_config['newzjdlr']));
	$is_newzjdlr = in_array($roominfo['crid'],$other_config['newzjdlr']);
?>
//私信计数
function msgcount() {
	//判断用户是否登录，如果没有登录不再获取私信计数
	var auth = getcookie('ebh_auth');
	if (auth == ''){
		return false;
	}
	$.ajax({
		url:'/college/msg/getcount.html?d='+Math.random(),
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
			if(data['type_2'] > 0) $("#msgcount2").html('&nbsp;('+data['type_2']+')');//新回答
			else $("#msgcount2").html('');
			<?php if($is_zjdlr){?>
			if(data['type_5'] > 0) $("#msgcount5").html('&nbsp;('+data['type_5']+')');
			else $("#msgcount5").html('');
			<?php }?>
		}
	});
}
//私信发送成功
function showSendSuccess()
{
	var dialog1=top.dialog({
        skin:"ui-dialog2-tip",
        width:350,
        content: "<div class='TPic'></div><p>发送成功！</p>",
		onshow:function(){
			setTimeout(function () {
				dialog1.close().remove();
				window.H.get('wxDialog').exec('close');
			}, 1000);
		}
	}).show();
	return false;
}
//私信发送失败
function showSendFail()
{
	$.showmessage({message:'发送失败'});
}
</script>
</head>
<body style="position:relative;left:0px;<?= $is_zjdlr?'background:url(http://static.ebanhui.com/ebh/tpl/2016/images/bg_gt.jpg?v=20161201) no-repeat #f5fafd center top;':''?>">
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
			<?php if(!empty($showModuleMenu) && !empty($room['domain']) && ($room['domain'] != 'bndx')){ ?>
				<div class="csubnav" style="float:right;"> | <a href="/homev2.html">个人中心</a></div>
			<?php }?>
				<div class="csubnav">
					<?php $curdomain = $this->uri->curdomain;
					$roomurl = empty($roominfo['fulldomain']) ? $roominfo['domain'].'.'.$curdomain : $roominfo['fulldomain'];
					?>
					<!--判断是网校还是企业，企业$room_type变量输出1，0为网校-->
					<?php $room_type = Ebh::app()->room->getRoomType();$room_type = $room_type == 'com' ? 1 : 0;?>
			 		<a href="/"><?=($room_type==1) ? "平台首页":"网校首页"?></a>
				</div>
				<?php $user['realname']=!empty($user['realname'])?$user['realname']:'';$user['username']=!empty($user['username'])?$user['username']:'';?>
				<div class="userinfo"><span style="float:left;">您好 ，<?= empty($user['realname'])?$user['username']:$user['username'].'('.$user['realname'].')'?></span>
				<div id="msgbox" class="fdsjres1">
					<a href="<?=geturl('college/msg')?>" class="fdsjre" target="mainFrame"><img style="float:left;" src="http://static.ebanhui.com/sns/images/liseng.jpg" /><span class="grehsr" style="display:none;">&nbsp;</span></a>
					<ul id="msgboxlist" class="user-drop-down" style="display:none;">
						<li><a href="<?=geturl('college/msg/message')?>" target="mainFrame">新私信<span id="msgcount3"></span></a></li>
						<li><a href="<?=geturl('college/msg/answer')?>" target="mainFrame">新回答<span id="msgcount2"></span></a></li>
						<?php if($is_zjdlr){?>
						<li><a href="<?=geturl('college/myask/tome')?>" target="mainFrame">新问题<span id="msgcount5"></span></a></li>
						<?php }?>
						<li><a href="<?=geturl('college/msg/send')?>" target="mainFrame">发送私信</a></li>
                    </ul>
				</div>
				<a href="/logout.html" target='_self'>退出</a>　|
				</div>
			</div>
		</div>
	</div>
</div>
<?php if(!$is_zjdlr){?>
<?php
$isapp = isApp();
if(!$isapp) {?>
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
<?php } ?>
<?php }?>
<div style="position:relative; width:980px; margin:0 auto; height:0px;">
		<div class="titles fl" style="background:none">
			<span class="spans" style="left:130px; top:-40px; *top:-40px;"><?= !empty($room['crname'])?$room['crname']:'';?></span>
		</div>
</div>
