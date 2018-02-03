<!--[if lte IE 6]>  
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/DD_belatedPNG_0.0.7a.js"></script>  
<script type="text/javascript">  
  DD_belatedPNG.fix('.menubox ul li i,.bottom,.cservice img');   
</script>  
<![endif]-->
<style type="text/css">
.cleft {
	width: 190px;
	float: left;
	height: auto;
	height: auto !important;
	min-height: 478px;
	display: inline;
}

.cleft .menubox {
	background-color: #fff;
	border: 1px solid #cdcdcd;
	border-bottom:none;
	float: left;
	padding-top:10px;
	width: 188px;
}

.leku {
	background: url(http://static.ebanhui.com/ebh/tpl/2012/images/cleft_bg0619.jpg) no-repeat scroll 0 0
		transparent;
	float: left;
	height: 60px;
	width: 190px;
}

.menubox .menulist a {
	display: block;
	font-size: 14px;
	height: 24px;
	line-height: 24px;
	padding: 6px 0;
}

.menubox .menulist a:hover {
	background:#f2f2f2;
	color: #3d3d3d;
}

.menulist li {
	height: 34px;
	overflow: hidden;
}
.menulist .line {
	border-bottom: 1px solid #e4e4e4;
}

.ui_ico {
	display: inline;
	float: left;
	height: 24px;
	margin: 0 15px 0 19px;
	width: 24px;
}

.line .gerenzhongxin {
	background: url(http://static.ebanhui.com/ebh/tpl/2012/images/clefticon0702.png) no-repeat scroll 0 0
		transparent;
}

.yunjiaoyu {
	background: url(http://static.ebanhui.com/ebh/tpl/2012/images/clefticon0702.png) no-repeat scroll 0 -33px
		transparent;
}

.mynewffix {
	background: url(http://static.ebanhui.com/ebh/tpl/2012/images/yuan.png) no-repeat scroll 0 10px transparent;
}

.shareshop {
	background: url(http://static.ebanhui.com/ebh/tpl/2012/images/clefticon0702.png) no-repeat scroll 0 -66px
		transparent;
}
.gobuy {
	background: url(http://static.ebanhui.com/ebh/tpl/2012/images/clefticon0702.png) no-repeat scroll 0 -183px
		transparent;
}
.myask {
	background: url(http://static.ebanhui.com/ebh/tpl/2012/images/clefticon0702.png) no-repeat scroll 0 -216px
		transparent;
}
.txbroom {
	background: url(http://static.ebanhui.com/ebh/tpl/2012/images/clefticon0702.png) no-repeat scroll 0 -143px
		transparent;
}
.score {
	background: url(http://static.ebanhui.com/ebh/tpl/2012/images/clefticon.png) no-repeat scroll 0 -531px
		transparent;
}
.current {
    background:#f2f2f2;
}
.stu_crumb {
    background: none repeat scroll 0 0 #E7F6FB;
    border: 1px solid #D1EDF7;
    border-radius: 5px 5px 5px 5px;
    height: 43px;
    margin-bottom: 8px;
    width: 750px;
    padding-left: 7px;
}
.tit_search {
    float: left;
    height: 29px;
    margin-top: 13px;
    width: 390px;
}
.room_search {
    float: right;
    height: 29px;
    margin-right: 5px;
    margin-top: 7px;
    width: 306px;
}
.room_search_ipt {
    background: url(http://static.ebanhui.com/ebh/tpl/default/images/room_search.gif) repeat scroll 0 0 transparent;
    border: medium none;
    float: left;
    height: 29px;
    line-height: 29px;
    padding: 0 5px;
    width: 241px;
}
.room_search_btn {
    background: url(http://static.ebanhui.com/ebh/tpl/default/images/room_search.gif) repeat scroll -251px 0 transparent;
    border: medium none;
    color: #70727F;
    float: left;
    height: 29px;
    width: 55px;
}
.ui_yun {
    display: inline;
    float: left;
    height: 15px;
    margin: 0px 0px 0px 10px;
    width: 12px;
}
.jicai {
	width: 182px;
	margin-left: 3px;
	border-bottom:solid 1px #cdcdcd;
}
.topxian {
	border-top:solid 1px #cdcdcd;
}
.newxiao {
	background: url(http://static.ebanhui.com/ebh/tpl/2012/images/ico12122.jpg) no-repeat left center;
}
.jinjilv {
	background: url(http://static.ebanhui.com/ebh/tpl/2012/images/ico12123.jpg) no-repeat left center;
}
.jinzuoye {
	background: url(http://static.ebanhui.com/ebh/tpl/2012/images/ico12124.jpg) no-repeat left center;
}
.jicai .waiku {
	border:solid 1px #cdcdcd;
	width:120px;
	height:120px;
	margin-left:24px;
	padding:4px;
	margin-top:5px;
}
.topxian .utfcn {
	line-height: 32px;
	height: 32px;
	width: 130px;
	margin-left: 28px;
	padding-left: 20px;
	color: #666666;
}
</style>
<?php
$memberlib = Ebh::app()->lib('Member');
if($memberlib==null)
	$memberlib = Ebh::app()->member;
$leftinfo = $memberlib->getleftinfo($user['uid']);
$menuid = empty($menuid)?0:$menuid;
$currmenu = array('','','','','','');
$currmenu[$menuid]=' current';
if(!empty($user['face']))
	$face = $user['face'];
elseif($user['sex'] == 0)
	$face = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man_120_120.jpg';
else
	$face = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman_120_120.jpg';
?>
<div class="cleft">
<div class="menubox">

<div class="jicai">
<div class="waiku"><img src="<?=$face?>" style="width:120px;height:120px;"/></div>
<p style="font-weight:bold;margin-left:25px;"><?=$user['username']?></p>
<p style="margin-left:25px;font-size:14px;">你的积分：<span style="font-size:18px;color:#c51601;margin-right:5px;"><?=$user['credit']?></span><img src="http://static.ebanhui.com/ebh/tpl/2012/images/ico12121.jpg" /></p>
<ul class="topxian">
<li class="jinjilv utfcn">最近学习记录：<span style="color:#f58220;"><?=$leftinfo['study']?> </span>条</li>

<li class="jinzuoye utfcn">最近完成作业：<span style="color:#f58220;"><?=$leftinfo['answer']?> </span>份</li>
</ul>
</div>

<ul class="menulist">
	<li id="liroom" class="limyroom <?=$currmenu[0]?> line"><a href="<?=geturl('member/setting/profile')?>"> 
	<i class="ui_ico gerenzhongxin"></i> 基本信息 </a></li>
	<li id="liroom" class="<?=$currmenu[1]?> line"><a href="<?=geturl('member/cloud')?>">
	<i class="ui_ico yunjiaoyu"></i> 云教学网校 (<?=$leftinfo['room'];?>)</a></li>
	<li id="liroom" class="<?=$currmenu[2]?> line"><a href="<?=geturl('member/space')?>">
	<i class="ui_ico txbroom"></i> 原创空间 </a></li>
	
	<li id="liroom" class="<?=$currmenu[4]?> line"><a href="<?=geturl('member/records')?>">
	<i class="ui_ico gobuy"></i> 服务记录 </a></li>
	<li id="liroom" class="<?=$currmenu[5]?> line"><a href="<?=geturl('member/myask')?>">
	<i class="ui_ico myask"></i> 我的答疑 </a></li>
</ul>
</div>
<div class="touch" style="height:218px;">
<img src="http://static.ebanhui.com/ebh/tpl/2012/images/ycad.jpg" width="188px"/>
</div>
</div>