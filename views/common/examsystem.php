<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/2012/css/eq/lrtlk.css" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/portal/css/ebhportal.css">
<link href="http://static.ebanhui.com/portal/css/ebtert.css" type="text/css" rel="stylesheet">
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" rel="stylesheet" />	
<script src="http://static.ebanhui.com/js/jquery-1.11.0.min.js" type="text/javascript"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>
<script src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<style type="text/css">
html {
    background: none repeat scroll 0 0 #eef0f3;
}
#footer{
	text-align: center;
	line-height: 24px;
}
</style>

<title>组卷系统-e板会-开启云教学互动时代</title>
<meta content="e板会,云教育,教育界的淘宝,开教育店,在线教育,无线互联网教育,在线考试,课后作业,电子教室,网络课堂,同步学堂,补课系统,答疑系统,播放器,课件制作软件,小学,初中,高中,大学,语文,英语,数学,地理,物理,化学,生物,历史,政治,体育,名师讲坛,远程教育,自考,成考,考试辅导,考研,外语,英语,职业技能,资格考试,法律" name="keywords">
<meta content="e板会-全球领先的网络在线资源有偿分享增值服务平台,打造教育界的淘宝,让每个人都能开云教育知识店,提供在线教育,无线互联网教育,同步学习,补课系统,答疑系统,小学,初中,高中,大学,语文,英语,数学,地理,物理,化学,生物,历史,政治,体育,名师讲坛,远程教育,自考,成考,考试辅导,考研,外语,英语,职业技能,资格考试,法律等教学" name="description">
</head>

<body>
<!--头部条!-->
<?php $user = Ebh::app()->user->getloginuser();?>
<div class="ebhcceud">
<div class="pass_e">
<div class="inftur">
<div class="headerleft" style="float:left;">
	<a class="linwen" target="_blank" href="<?=geturl('intro/schooliswhat')?>">什么是网络学校？</a>
	<!--<a class="linwen" target="_blank" href="<?=geturl('intro/schoolfunction')?>">能做什么？</a>-->
</div>
<ul class="quick-menu">
<?php if(empty($user)){?>
<li class="">
<a class="linwen" href="javascript:void(0);" onclick="_login()">登录</a>
</li>
<li class="">
<a class="linwen" target="_blank" href="/register.html">免费注册</a>
</li>
<?php }else{?>
<li class="">
<a class="linwen" style="color: #777;" href="javascript:void(0)">您好 <?= $user['username']?> 欢迎来到e板会！</a>
</li>
<?php $homeurl = $user['groupid'] == 6 ? geturl('homev2') : geturl('teacher/choose')?>
<li class="">
<a class="linwen" target="_blank" href="<?=$homeurl?>">个人中心</a>
</li>
<li class="">
<a class="linwen" href="<?=geturl('logout')?>">安全退出</a>
</li>
<?php }?>
<li class="">
<a class="linwen" id="moreapp" href="/moreapp.html">更多应用</a>
</li>
</ul>
</div>
</div>
</div>

<div class="zujuan">
<div class="botop">
<a href="javascript:void(0)" onclick="showdia()">
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/adzujuan.jpg" />
</a>
</div>
</div>
<div class="wany">
<div class="xtjian" style="height:200px;">
<h2 class="titeket"><span class="lkandi">系统简介</span></h2>
<p class="tirkw">e板会作业组卷系统是针对学校教学需求，采用云技术实现在线快捷自动组卷，自动批阅功能，包含自动组卷生成、题库录入管理、
试题搜索、动态难度分析、测试统计分析、管理员管理等几个功能模块，大大减轻了教师的工作量，全面提高了学校的教学管理效率及教
学质量，还可以减少试卷泄题现象，从而确保学生考试的公平性。本系统为在线平台系统，登录端口进入本系统后，根据教学实际情况和
具体内容，按照一定的要求，科学、合理进行系统分析、设计，就可灵活、方便地生成试卷。</p>
</div>
<div class="xtjian">
<h2 class="titeket"><span class="lkandi">系统业务流程</span></h2>
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/tuliu.jpg" style="margin-left:100px;margin-top:20px;" />
</div>
<div class="ptgou" style="height:1950px;">
<h2 class="titeket"><span class="lkandi">平台系统构成和功能</span></h2>
<div class="leften">
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/tumuk.jpg" style="margin-top:80px;margin-right:25px;" />
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/titmok.jpg" style="margin-top:30px;margin-bottom:10px;" />
<p class="dapns indent">这是最核心的功能模块。根据组卷要求，比如题型、知识点、难度
系数、数量、关键词等参数，系统自动筛选出符合的题目，组成卷子，并可
直接布置为作业，或导出为word打印，简洁操作，快速组卷。
<p class="dapns">（1）主客观题同卷合成</p>
<p class="dapns indent">从程序设计角度看，机器自动批阅与人工手动批阅的界面属性不同，传
统编程技术很难合成统一页面，但是本系统可以统一卷面的组卷和批改，也
就是自动批改客观题，教师手动批改主观题，就和纸质同卷测试和批阅一样
的效果。</p>
<p class="dapns">（2）word导出打印试卷</p>
<p class="dapns indent">
所有组卷成功的卷子，可以直接导出word，保存到电脑中直接打印成卷
子，下发给学生进行考试。
</p>
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/yundixian.jpg" style="margin-top:30px;margin-bottom:10px;" />
<div class="lefgent">
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/titlvru.jpg" style="margin-top:36px;margin-bottom:10px;" />
<p class="dapns indent">题库是自动组卷系统功能实现的前提和基础。目前e板会已有400余万道题，
包含从小学到大学的各个学科、各种题型、各个知识点。</p>
<p class="dapns">（1）题库分类：题库分为我的题库（教师个人题库）、学校题库、公共题库3个
类别，可以根据权限分类管理和录入。</p>
<p class="dapns">（2）题库录入：可以手工一道道录入，也可以直接导入word题库，批量录入。</p>
<p class="dapns">（3）公式编辑器：录入试题中，自带强大的公式编辑器，可以在试题中加入复杂
的数学公式和符号，并可任意输入数字和文字，可以提高教学准确率，提升试题
应用性，对试题编辑和习题讲解，具有极大的便利性。</p>
<p class="dapns">（4）动态解析课件：在录入题目后的答案解析中，可以直接插入课件解析，在课
件解析中，教师可以通过手写+声音+视频+多媒体文件辅助等多种方式，详细的演
示和讲解每一步骤，也就是动态解题，媲美面对面、一对一的辅导。</p>
</div>
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/tulvru.jpg" style="margin-bottom:10px;" />
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/yundixian.jpg" style="margin-top:10px;margin-bottom:20px;" />
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/tusous.jpg" style="margin-bottom:10px;margin-right:25px;" />
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/titsous.jpg" style="margin-top:50px;margin-bottom:10px;" />
<p class="dapns indent">教师在手工组卷或者查询题目时，只要搜索年级、课程、知识点、题型、
关键词等搜索条件，即可查询到相关的试题。</p>
<p class="dapns indent">组卷成功的试卷，均可在“组卷历史”中查询到相关试卷，并可进行修
改或导出word打印。</p>
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/yundixian.jpg" style="margin-bottom:50px;" />
<div class="lefgent">
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/titdongt.jpg" style="margin-bottom:10px;" />
<p class="dapns indent">题库中每一题都设置了动态难度系数值，该值是一个动态的。</p>
<p class="dapns indent">每个学生对该题的正误率和订正后再次测试的正误率，都在系统数据库
中自动记录。随着该题发布和解答次数的增多，该难度系数值就会自动发生
变化。</p>
<p class="dapns indent">随着样本数量的增加，该题的难度系数也就日趋精确，可以真实而动态
的反应历史和当前学生对该知识点的掌握情况，为教学设计提供可靠的依据。</p>
</div>
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/tudongt.jpg" style="margin-bottom:10px;" />
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/yundixian.jpg" style="margin-bottom:20px;" />
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/tuceshi.jpg" />
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/titceshi.jpg" style="margin-top:50px;margin-bottom:10px;" />
<p class="dapns indent">试卷测试过后，系统自动形成统计分析图标，可以清晰的展示每个班
级、每个同学、每个学科、每份试卷的情况，并根据答题情况，收集错题，
形成错题汇总，便于教师在课堂讲解中集中力量，重点讲解。同时也可以
跟踪每个学生的知识掌握情况，提供一对一的辅导。</p>
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/yundixian.jpg" style="margin-bottom:40px;margin-top:10px;" />
<div class="lefgent">
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/titguanli.jpg" style="margin-bottom:10px;" />
<p class="dapns indent">系统设置了管理权限，根据不同权限，可以查看和了解相应的内容。</p>
<p class="dapns indent">作为管理者的显示教育局，可以查看本县市所有试卷和试题，以及所
有学生的测试结果；</p>
<p class="dapns indent">作为学校，可以查看本校试题库和试卷，以及所有学生的测试结果；
作为教师，可以查看和编辑本人布置的试卷，以及学生答题情况和知识掌
握情况。</p>
</div>
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/tuguanli.jpg" style="margin-top:40px;" />

</div>
</div>
</div>
<!--获得e板会软件提示框-->
<div id="dialogdivss" style="display:none">
<img src="http://static.ebanhui.com/ebh/tpl/2012/images/show.jpg" />
</div>
<script>
//获得e板会软件提示框
	function showdia(){
			$("#dialogdivss").dialog("open");
	}
			
	$(function(){
		$("#dialogdivss").dialog({
			modal: true, 
			autoOpen:false,
			bgiframe:true,
			draggable:false,
			title:'获得e板会软件',
			width:540,
			height:270
		});
	});

	function _login(){
        tologin('/login.html?returnurl=__url__');
    }
    var tologin = function(url,href,hark){
		if(href == undefined || href==''){
			href = location.href;
			if(typeof(hark)=='string'  && typeof(hark)!='' ){
				href=href+'#'+hark;
			}
		}
		url = url.replace('__url__',encodeURIComponent(href));
		location.href=url;
	}
</script>
<?=$this->display('common/footer');?>
