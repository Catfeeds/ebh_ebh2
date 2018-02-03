<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="http://static.ebanhui.com/js/jquery-1.11.0.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/base.css" />
<style type="text/css">
html {background:#fbfbfb}
.youhao {
width:428px;
overflow:hidden;
float:left;
padding:0px 6px 10px 20px;
font-size:13px;
line-height:1.8;
background-color:#fbfbfb;
}
.youhao .yonghu {
border-bottom:solid 1px #dfeef6;
padding:12px 0;
float:left;
width:428px;
}
.youhao .yonghu p {
word-break:break-all;
}
.youhao .yonghu .yonglef {
border:solid 1px #a7c6e5;
width:120px;
height:120px;
float:left;
}
.youhao .yonghu .yonglef img{
float:left;
}
.youhao .yonghu .yongrig {
float:left;
margin-left:18px;
width:288px;
}
</style>
<title>好友详情</title>
</head>

<body scroll=no>
<div class="youhao">
<div class="yonghu">
<div class="yonglef">
<?php 
	$_UP = Ebh::app()->getConfig()->load('upconfig');
	$showpath = $_UP['avatar']['showpath'];

	if(!empty($teacherInfo['face']))
		$face = $teacherInfo['face'];
	elseif($teacherInfo['sex']==0)
		$face = 'http://static.ebanhui.com/ebh/tpl/default/images/t_man_120_120.jpg';
	else
		$face = 'http://static.ebanhui.com/ebh/tpl/default/images/t_woman_120_120.jpg';

	
?>
<img src="<?=$face?>" width="120" height="120" />
</div>
<div class="yongrig">
<p><span style="font-size:24px;font-weight:bold;margin-right:20px;"><?=$teacherInfo['nickname']?></span><?=$teacherInfo['email']?><span>(<?=$teacherInfo['username']?>)</span></p>
<p>个性签名：<span><?=$teacherInfo['mysign']?></span></p>
</div>
</div>
<div class="yonghu">
<!--<p>昵　　称：<span>职业学生</span></p>-->
<span style="width:180px;float:left;">姓　　名：<span><?=$teacherInfo['realname']?></span></span>

</div>
<div class="yonghu">
<p>个　　人：<span><?=$teacherInfo['sex']==0?'男':'女' ?></span>
<span><?=empty($teacherInfo['birthdate'])?'':date('Y-m-d',$teacherInfo['birthdate'])?></span>
<!--　属兔　水瓶座　AB型 -->
<p>现 居 地：<span id="city"></span></p>
</p>
</div>
<div class="yonghu">
<p>手机号码：<span><?=$teacherInfo['mobile']?></span></p>
<p>邮　　箱：<span><?=$teacherInfo['email']?></span></p>
</div>
<div class="yonghu" style="border:none;">
<p>简　　介：<span><?=$teacherInfo['profile']?></span></p>
</div>
</div>
<script type="text/javascript">
function getcityname(){
	return $.ajax({ 
		url: "/admin/cities/getAddrText.html",
		type:"post",
		data:{citycode:<?=$teacherInfo['citycode']?>},
		async:false,
  	}).responseText;
}
$(function(){
	$("#city").text(getcityname());
});
</script>
</body>
</html>