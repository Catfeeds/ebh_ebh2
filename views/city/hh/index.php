<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $room['crname'] ?>-少儿绘画学习班(e板会)</title>
<meta name="keywords" content="<?= $room['crlabel'] ?>" />
<meta name="description" content="<?= $room['summary'] ?>" />

<!--[if lte IE 6]>  
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/DD_belatedPNG_0.0.7a.js"></script>  
<script type="text/javascript">  
  DD_belatedPNG.fix('.head-logo,.head-logo a ,.current-city,.head-logo-text,.header-area span,.bottom,.cservice img,.qtlol img');   
</script>  
<![endif]-->
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/citytpl/huihua/css/pain.css?v=1" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" rel="stylesheet" />	
<script type="text/javascript">
<!--
	var sitecpurl ='#getsitecpurl()#';
//-->
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/dialog.js"></script>
<style type="text/css">
.tisku {
	height: 185px;
	width: 385px;
}
.tisku p {
	float: left;
	width: 230px;
	margin-left: 25px;
	_margin-left: 12px;
	font-size: 14px;
	color: #666;
	font-weight: bold;
	line-height: 1.8;
}
.top50 {
	margin-top:50px;
}
.tisku img {
	float:right;
	margin-right:20px;
	margin-top:20px;
}
 #dialogdivs {
	display:none;
}
</style>
</head>
<body>
<?php $this->display('common/public_header'); ?>
<div class="pain">
<div class="top_nav">
<img src="http://static.ebanhui.com/ebh/citytpl/huihua/images/ad10521.png" width="960" height="81" border="0" usemap="#Map2" />
<map name="Map2" id="Map2"><area shape="rect" coords="4,12,102,71" href="http://www.ebanhui.com/" /></map></div>
<div class="logins">
<div class="logleft">
<?php 
	$crid=$room['crid'];
	$this->widget('ad_widget', $adlist, array('_id' => 'actor', '_width' => 645, '_height' => 222, 'crid'=>$crid, 'default' => '/static/citytpl/stores/images/adzhong0626.jpg'));
?>
</div>
<div class="logright">
<div class="top_bg">
	<?php if(empty($user)){ ?>
      <input type="button" onclick="toregister('/register.html?returnurl=__url__');" class="aniu01" value="" />
	  <?php } ?>
  </div>

<div class="mian_bg">
<div class="bg_lef"></div>
<div class="log_mai">
<?php if(empty($user)) { ?>
	<form id="form1" name="form1" action="/login.html?inajax=1&login_from=classroom" onsubmit="form_submit();return false;">
	<input type="hidden" name="loginsubmit" value="1" />
		<div style="margin-top:15px;"><span>帐&nbsp;&nbsp;号：</span>
		  <input type="text" class="kuang_bg" name="username" id="username" value="帐号" onfocus="if($('#username').val()=='帐号'){$('#username').val('').css('color','#000000');}" onblur="if($('#username').val()==''){$('#username').val('帐号').css('color','#000000');}"/>
		</div>
		<div style="margin-top:10px;"><span>密&nbsp;&nbsp;码：</span>
		  <input type="password" class="kuang_bg" name="password" id="password" style="color:black" />
		</div>
		<div id="lo">
				 <?php if(!empty($user)) { ?>
				<input id="xuangou" type="checkbox" name="cookietime"  value="<?= 3600*24*14?>" checked="checked" />
				<?php }else{ ?>
					<input id="xuangou" type="checkbox" name="cookietime"  value="<?= 3600*24*14?>" />
				<?php } ?>  
			  </div>
			  <div class="zz">
			<label for="xuangou">下次自动登录</label><em style="margin-left:5px; margin-right:5px;">|</em><a href="<?= geturl('forget') ?>" style="color:#999;">忘记密码？</a></div>
			
			  <input id="loginsubmit" type="submit" class="aniu02" name="Submit" value="" />
			  
		<div class="qtlol" style="width:118px;margin-left:10px;float:left;margin-top:-6px;"><span style="color:#000;">用其他账号登录：</span><a href="<?=geturl('otherlogin/qq')?>"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/qqico0830.png" /></a><a href="<?=geturl('otherlogin/sina')?>"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/sianico0830.png" /></a></div>
	</form>
 <?php } else { 
			$sex = empty($user['sex']) ? 'man' : 'woman';
            $type = $user['groupid'] == 5 ? 't' : 'm';
            $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$type.'_'.$sex.'.jpg';
            $face = empty($user['face']) ? $defaulturl : $user['face'];
            $facethumb = getthumb($face,'78_78');
            $url = $user['groupid'] == 5 ? geturl('troom') : geturl('myroom');
	?>

	<div class="usouter">
	<div class="figlef">
	<img src="<?= $facethumb ?>" width="78px" height="78px" />
	</div>
	<div class="showrig">
	<h2 style="font-weight:bold; font-size:14px; color:#3195c6;"><?= $user['username'] ?></h2>
	<p>上次登录时间</p>
	<p><?= $user['lastlogintime']?></p>
	<?php if($user['groupid'] == 6) { ?>
	<p><a href="/classactive.html" target="$target" style="color:#f27245;">开通服务</a><em style="margin-left:5px; margin-right:5px; color:#ccc;">|</em><a href="/logout.html" style="color:#999;">退出</a></p>
	<?php }else{ ?>
	<p><a href="/logout.html" style="color:#999;">退出</a></p>
	<?php } ?>
	</div>
	</div>	
		<?php if($user['groupid'] == 6) { ?>
		  <input type="button" class="aniu0605" value="" onclick="window.location.href='/myroom.html'"/>
		<?php }else{ ?>
		  <input type="button" class="aniu0605" value="" onclick="window.location.href='/troom.html'"/>
		<?php } ?>
 <?php } ?>
</div>
<div class="bg_rig"></div>
</div>


<div class="fot_bg"></div>
</div>
</div>

<div class="top_list">
<ul>
<li>
<div class="lef_bg"></div>
<div class="list_bg">
<div class="yindaoico">
<a href="/help.html" target="_blank" class="yindaobtn"></a>
  <span>第一次登录涂涂画画的同学们，点击这里，可以引导你如何使用各个功能！</span>
</div>
</div>
<div class="rig_bg"></div>
</li>
<li>
<div class="lef_bg"></div>
<div class="list_bg">
<div class="openico">

<a href="/classactive.html" target="_blank" class="openbtn"></a>
  <span>新来的同学们，点击这里，享受一站式的账号注册、学习申请的服务吧！</span>
</div>
</div>
<div class="rig_bg"></div>
</li>
<li>
<div class="lef_bg"></div>
<div class="list_bg">
<div class="rechargeico">
<a href="/classactive.html" class="rechargebtn"></a>
  <span>新购卡或快到期的同学们，点击这里，可以快速充值缴费，开通学习权限哦！</span>
</div>
</div>
<div class="rig_bg"></div>
</li>
<li>
<div class="lef_bg"></div>
<div class="list_bg">
<div class="playico">
<a href="http://soft.ebanhui.com/ebhsetup.exe" class="playbtn"></a>
  <span>第一次开通服务，进行学习之前，点击这里，下载播放器吧！</span>
</div>
</div>
<div class="rig_bg"></div>
</li>
<li style=" margin-right:0px;">
<div class="lef_bg"></div>
<div class="list_bg">
<div class="clientico">
<a href="http://soft.ebanhui.com/ebhclient.zip" class="clientbtn"></a>
  <span>无需打开网页，点击这里，下载客户端，可直接在桌面快速登录！</span>
</div>
</div>
<div class="rig_bg"></div>
</li>
</ul>

</div>

<div class="tittophh">
<div class="tittj">
<h2 class="merte"></h2>
<div class="refhh">
<h3 class="tithhwhat"><img width="140" height="36" src="http://static.ebanhui.com/ebh/citytpl/huihua/images/tit_smhh0608.png"></h3>
<div class="hhwhat">
<p>涂涂画画是针对3-12岁的幼儿、以及绘画初学者的兴趣特点和学习需求而设的独立的少儿绘画平台。收集孩子们生活中最喜爱的形象，通过夸张的线条呈现出来，让孩子们在欢快的学习氛围中，掌握点、线、面、几何形、简单型的组合、构图和上色。</p>
</div>
</div>
<div class="whyhh">
<h3 class="tithhwhat"><img width="140" height="36" src="http://static.ebanhui.com/ebh/citytpl/huihua/images/tit_wsmxhh0608.png"></h3>
<div class="hhwhy">
<p style="margin-top:10px;"><span class="storon">美国科学家长期跟踪研究发现：</span>同在一个生活环境、同样的文化教养及家庭环境里，因为艺术素质不同，形象思维能力差别很大。</p>
<p><span class="storon">美国机制设计之父&mdash;&mdash;莱昂尼德?赫维奇，自学成才。</span>提起儿童时期学习绘画，他说：“小的时侯学画画影响了我一生。学画对人的思维发展特别有好处。比如，绘画要求整体观察，我从小写作文，不管多短的文章，我都能写得完整，我觉得我比同龄人显得聪明。绘画开启了我的思维空间。</p>
<p><span class="storon">大量儿童成长的实例表明，</span>形象思维能力在儿童发展中具有重要的作用，基础美术教育对儿童来说，不是目的，而是手段，是素质教育的基石。</p>
</div>
</div>
<div class="letter">
<div class="neilet">
<div class="letlef">
<h3 class="tithhwhat"><img width="140" height="36" src="http://static.ebanhui.com/ebh/citytpl/huihua/images/tit_jieshaohh0608.png"></h3>
<div class="neilef">
<div class="brand">
<a href="#" class="img-shadow"><img width="100" height="100" src="http://static.ebanhui.com/ebh/citytpl/huihua/images/hhtu0608.jpg"></a>
<h1 class="primg"><img width="118" height="36" src="http://static.ebanhui.com/ebh/citytpl/huihua/images/jiage0608.png"></h1>
<p>原价1000元/年</p>
</div>
<div class="address">
<ul>
<li class="email">邮箱：<a href="mailto:<?= $room['cremail']?>" title="给我们发邮件"><?= $room['cremail']?></a></li>
<li class="phone">电话：0571-88252183</li>
<li class="qq">Q　Q：<a href="http://wpa.qq.com/msgrd?v=3&uin=<?= $room['crqq']?>&site=qq&menu=yes" title="QQ联系"><?= $room['crqq']?></a></li>
<li class="url">网址：<a href="http://hh.ebanhui.com" title="涂涂画画">http://hh.ebanhui.com</a></li>
<li class="site">地址：<?= $room['craddress']?></li>
</ul>
</div>
</div>
</div>
<div class="letrig">
<p style="margin-top:10px;">由美院绘画名师宋光弟领队，组成授课小组。小组成员老师均有深厚的绘画功底和几十年的绘画教育经验，充分了解儿童学画特点和兴趣点，因材施教，从零开始授课，提供统一、专业的绘画课程和单独、专一的个性化绘画指导。</p>
<p>领队老师&mdash;&mdash;宋光弟：美院老师，中国国际书画联合会会员，浙江省逸仙书画院会员，有多年儿童绘画的教学经验，书画作品并多次入展（如：省书画院大展、纪念建党周年书画展、纪念辛亥革命书画展、逸仙书院周年等）并经常刊登于各级书、报。</p>
</div>
</div>
</div>
<div class="gain">
<ul>
<li><img src="http://static.ebanhui.com/ebh/citytpl/huihua/images/hh_ad20608.jpg">
<div style="margin:0 10px;">
<h5 style="color:#c96b41;font-weight:bold;">线下培训机构：</h5>
<p>可以营造一个团队学习氛围、可以通过对比、激励，培养孩子的自信心。</p>
<h5 style="color:#c96b41;" class="size">线上涂涂画画：</h5>
<p>通过展示绘画过程，一步步引导和激发孩子的想象力、思考力，开发智力，提高综合能力。</p>
</div>
</li>
<li><img src="http://static.ebanhui.com/ebh/citytpl/huihua/images/hh_ad30608.jpg">
<div style="margin:0 10px;">
<h5 style="color:#41abc9;font-weight:bold;">线下培训机构：</h5>
<p>班级授课，老师现场指导，有问题可以得到及时的解决。</p>
<h5 style="color:#41abc9;" class="size">线上涂涂画画：</h5>
<p>免去上下课及路上赶车奔波之苦，任何地方都可进行学习；有多名全国最优秀的绘画老师在线辅导，及时沟通，达到和现场一样的指导效果。</p>
</div>
</li>
<li><img src="http://static.ebanhui.com/ebh/citytpl/huihua/images/hh_ad40608.jpg">
<div style="margin:0 10px;">
<h5 style="color:#c441c9;font-weight:bold;">线下培训机构：</h5>
<p>动则几百几千，每周一两次，每次几十分钟。</p>
<h5 style="color:#c441c9;" class="size">线上涂涂画画：</h5>
<p>500元/年，平均每天不到2元钱，就可以不限时间、不限次数的反复学习。的指导效果。</p>
</div>
</li>
<li style="border-right:none;"><img src="http://static.ebanhui.com/ebh/citytpl/huihua/images/hh_ad50608.jpg">
<div style="margin:0 10px;">
<h5 style="color:#41c974;font-weight:bold;">线下培训机构：</h5>
<p>使用纸质绘画，孩子画完可以拿给老师批阅，拿给家长看，携带方便，但是不易保存，容易损坏。</p>
<h5 style="color:#41c974;" class="size">线上涂涂画画：</h5>
<p>可以让孩子跟着老师在平板电脑上临摹，直接保存下画画的笔记和备注，显示每一次的进步。</p>
</div>
</li>
</ul>
</div>
<div class="fothh">
<ul id="clist">
<li class="hhtoptu"><div><img src="http://static.ebanhui.com/ebh/citytpl/huihua/images/hh_ad60608.jpg"></div></li>
<li class="hhtoptu"><div><img src="http://static.ebanhui.com/ebh/citytpl/huihua/images/hh_ad70608.jpg"></div></li>
<li class="hhtoptu"><div><img src="http://static.ebanhui.com/ebh/citytpl/huihua/images/hh_ad80608.jpg"></div></li>
<li style="margin-right:0px;" class="hhtoptu"><div><img src="http://static.ebanhui.com/ebh/citytpl/huihua/images/hh_ad90608.jpg"></div></li>

<li class="hhbottu"><div><img src="http://static.ebanhui.com/ebh/citytpl/huihua/images/hh_ad100608.jpg"></div></li>
<li class="hhbottu"><div><img src="http://static.ebanhui.com/ebh/citytpl/huihua/images/hh_ad110608.jpg"></div></li>
<li class="hhbottu"><div><img src="http://static.ebanhui.com/ebh/citytpl/huihua/images/hh_ad120608.jpg"></div></li>
<li style="margin-right:0px;" class="hhbottu"><div><img src="http://static.ebanhui.com/ebh/citytpl/huihua/images/hh_ad130608.jpg"></div></li>
</ul>
</div>
</div>
</div>

<div class="outine">
<div class="titmer">
<h2 class="mertine"></h2>
<div class="dettine">
<ul id="flist">

<?php
	$courselist = array(
		'634'=>array('cwid'=>1615,'title'=>'人物---跳绳','cwsource'=>'http://www.ebanhui.com/','summary'=>'跳绳可以锻炼人的协调力和平衡力，本课老师要教小朋友画一个跳绳的小女孩，并且给她穿上漂亮的衣服，赶紧来学一学吧！'),
		'632'=>array('cwid'=>1675,'title'=>'服饰---童装之简装','cwsource'=>'http://www.ebanhui.com/','summary'=>'小朋友们喜欢穿漂亮的衣服吗？本课老师要教小朋友们画经常穿的衣服、背心、裙子、背带裙等。'),
		'635'=>array('cwid'=>1537,'title'=>'水果蔬菜---桃子','cwsource'=>'http://www.ebanhui.com/','summary'=>'喜欢吃桃子嘛？本课老师要教小朋友们画桃子。通过简单的线条和上色，就可以画出又大又好吃的桃子哦。'),
		'633'=>array('cwid'=>1822,'title'=>'交通工具---小汽车','cwsource'=>'http://www.ebanhui.com/','summary'=>'小汽车是我们生活中经常见到的东西，想画一辆栩栩如生的小汽车吗？赶紧跟老师学习吧。'),
		'639'=>array('cwid'=>1539,'title'=>'植物---荷花','cwsource'=>'http://www.ebanhui.com/','summary'=>'夏天到了，荷花开了，荷叶绿了，本课老师要教小朋友们画一朵栩栩如生的荷花，以及荷花边上的翠绿荷叶。'),
		'637'=>array('cwid'=>1621,'title'=>'武器---手枪','cwsource'=>'http://www.ebanhui.com/','summary'=>'男孩子们都会有一个手枪玩具吧？本课老师要教小朋友们画各种手枪、机关枪，让你在画纸上也能酷一把！'),
		'630'=>array('cwid'=>1541,'title'=>'自然风景---秀丽山水','cwsource'=>'http://www.ebanhui.com/','summary'=>'杭州山清水秀，通过简单的几笔，勾勒出亭子、远山、清水、绿树等，画出美丽杭州的秀丽山水图。'),
		'631'=>array('cwid'=>1722,'title'=>'动物---牛与大象','cwsource'=>'http://www.ebanhui.com/','summary'=>'牛和大象，都是大个子的动物，它们憨直可爱，力大无比，本课老师要教小朋友们画这些大力士。'),
		'0'=>array('cwid'=>1515,'title'=>'画画工具','cwsource'=>'http://www.ebanhui.com/','summary'=>'小朋友们，你们喜欢画画吗？你们了解画画吗？本课老师带大家认识画画的基本工具，并学习这些工具的画法。'),
		'638'=>array('cwid'=>1832,'title'=>'生活物品---摄像机','cwsource'=>'http://www.ebanhui.com/','summary'=>'爸爸妈妈经常给你拍照片，拍视频的东西叫什么呢？对了，摄像机！本课老师要教小朋友们学画摄像机！'),
		'636'=>array('cwid'=>1646,'title'=>'动漫---喜洋洋','cwsource'=>'http://www.ebanhui.com/','summary'=>'记得动画片中那只聪明可爱的喜洋洋吗？本课老师要教小朋友们画喜洋洋。一笔一划，让喜洋洋出现在你的画纸上吧。'),
		'645'=>array('cwid'=>1856,'title'=>'精品---梅花图','cwsource'=>'http://www.ebanhui.com/','summary'=>'梅花香自苦寒来是一种非常有意境的画面，本课老师要教小朋友们综合运用点、线、块的技巧，来画一副梅花傲雪图。')
		);
?>

<?php foreach($folderlist as $fval){?>
<li><div class="enidet">
<div class="dettu"><a href="<?= geturl('smallcourse-0-0-0-'.$fval['folderid'])?>" target="dialog" onclick="showdialog()" class="img-shadow">
<img width="114" height="159" src="<?= empty($fval['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$fval['img']?>" /></a></div>
<div class="refdet">
<h5 style="color:#0065ac; font-size:14px; margin-top:5px;"><a style="color:#0065ac;" href="javascript:freeplay('<?= $courselist[$fval['folderid']]['cwsource']?>','<?= $courselist[$fval['folderid']]['cwid']?>','<?= $courselist[$fval['folderid']]['title']?>',1);"><?= $courselist[$fval['folderid']]['title']?></a></h5>
<input type="submit" onmouseout="this.className='audibtn'" onmouseover="this.className='audibtn1'" value="" class="audibtn" onclick="javascript:freeplay('<?= $courselist[$fval['folderid']]['cwsource']?>','<?= $courselist[$fval['folderid']]['cwid']?>','<?= $courselist[$fval['folderid']]['title']?>',1);"/>
<p><?= $courselist[$fval['folderid']]['summary']?></p>
</div>
</div></li>
<?php } ?>

<li><div class="enidet">
<div class="dettu"><a href="javascript:" target="dialog" class="img-shadow"><img width="114" height="159" src="http://static.ebanhui.com/ebh/citytpl/huihua/images/other.jpg" /></a></div>
<div class="refdet">
<h5 style="color:#0065ac; font-size:14px; margin-top:5px;"><a style="color:#0065ac;" href="javascript:freeplay('$courselist[0]['cwsource']','$courselist[0]['cwid']','$courselist[0]['title']',1);"></a></h5>
<input type="submit" onmouseout="this.className='audibtn'" onmouseover="this.className='audibtn1'" value="" class="audibtn" onclick="javascript:freeplay('$courselist[0]['cwsource']','$courselist[0]['cwid']','$courselist[0]['title']',1);">
<p></p>
</div>
</div></li>
</ul>
</div>
</div>
</div>

<div class="affect">
<div class="titaff">
<h2 class="meraff"></h2>
<div class="detaff">
<ul>
<li><img src="http://static.ebanhui.com/ebh/citytpl/huihua/images/yingxiang_ad10608.jpg" style="border:none">
<h1 class="thick">1、绘画提高孩子的综合能力</h1>
<p>康妮和杰瑞是一对双胞胎姐妹，她们生活的环境是完全一致的，一起住在家里，吃完早饭一块儿去上学，而且在同一班。但是妹妹杰瑞很喜欢绘画，从小喜欢涂涂画画。每一次，她们遇到问题的时候，妹妹总是能用简单的绘画勾勒出来，然后姐妹两个一起研究解决。这表明，在同样的条件下，绘画对孩子的思维能力，能够产生极大的作用，有利于提高孩子观察事物和分析问题的能力。</p>
</li>
<li class="mianaff"><img src="http://static.ebanhui.com/ebh/citytpl/huihua/images/yingxiang_ad20608.jpg" style="border:none">
<h1 class="thick">2、绘画是其他学科的基础</h1>
<p>美国机械设计之父&mdash;&mdash;莱昂尼德?赫维奇，是自学成才的典型。提到他的成功经验时，他归功于“从小学绘画”。原来，莱昂尼德?赫维奇儿童时期就开始学绘画，并将这个爱好保持下来了。每次做数学题的时候，他总是能从公式里看到形象，理解概念，从而获得解题思路。这表明，绘画不但能够提高孩子的想象力、模仿力和创造力，还能够加深孩子的理解力，对未来其他学科的学习，也将产生积极的作用。</p>
</li>
<li><img src="http://static.ebanhui.com/ebh/citytpl/huihua/images/yingxiang_ad30608.jpg" style="border:none">
<h1 class="thick">3、绘画的积极影响力</h1>
<p>绘画是素质教育的基础，对儿童有积极的影响：</p>
<p>（1）提高儿童感知能力。</p>
<p>（2）培养丰富的情感。</p>
<p>（3）培养创造力、组织力。</p>
<p>（4）发展思维能力。</p>
<p>（5）促进个性发展。</p>
<p>（6）提高实际动手能力。</p>
<p>（7）开拓视野，培养文化修养。</p>
<p>（8）促进全面和谐发展。</p>
</li>
<li><img src="http://static.ebanhui.com/ebh/citytpl/huihua/images/yingxiang_ad40608.jpg">
<h1 class="thick">4、简笔画，让孩子的形象思维更开阔</h1>
<p style=" width:282px;">简笔画花是孩子们学习绘画最基础的内容之一。在涂涂画画的过程中，通过观察及思考，用画笔来表现其所见、所思，只要寥寥数笔，一个生动的形象，一幅简单明快的图画会栩栩如生地展现出来。</p>
<p style=" width:282px;">简笔画造型生动、简练，便于儿童学习和掌握，它通过目识、心记、手写等活动，提取客观形象中最典型、最突出的特点，以平面化及程序化的形式和运用简洁精炼的笔法，表现出有概括性，又有可识性的绘画。这些绘画活动既能促进孩子大脑右半区艺术感知能力的发挥，又能启发孩子的智力，发展他们的形象思维，进而培养他们的审美能力，为今后的艺术创作打下良好的基础，为数学、科学、语文等学习奠定良好的形象思维能力，因此简笔画在儿童教育中，越来越受到家长们和教育界的重视。
</p>
</li>
<li class="mianaff"><img src="http://static.ebanhui.com/ebh/citytpl/huihua/images/yingxiang_ad50608.jpg">
<h1 class="thick">5、美术入门&mdash;&mdash;临摹绘画</h1>
<p>临摹绘画是儿童和一切绘画初学者进行自然创作的基础和前提，是进一步学习的关键，通过对这些绘画活动和临摹学习，能使孩子们更好的掌握绘画事物的技巧，巩固后期自然创作的基础。</p>
<p>简笔画以简单的线条入手，结合点、面组成图画，并收集了孩子们在生活中最喜爱的形象，抓住所描绘对象的特征，加以提炼，用夸张的线条呈现给小朋友们。通过简笔画的学习和创作，希望能够逐渐提高孩子们观察事物，了解生活的能力，并让简笔形象成为孩子们学习的好伙伴，让学习生趣盎然。</p>
</li>
<li><img src="http://static.ebanhui.com/ebh/citytpl/huihua/images/yingxiang_ad60608.jpg">
<p>简单的绘画，不简单的效果，通过学习绘画，可以培养孩子们的注意力、观察力、审美能力、模仿力和基本造型能力，启发儿童智力，激发儿童兴趣，启迪儿童想象力、创造力、欣赏力，培养儿童完美的人格，为未来的科学、数学、艺术等奠定良好的基础。</p>
</li>
</ul>
</div>
</div>
</div>


</div>
<div id="dialogdiv" style="display:none">
<iframe width="100%" height="100%" frameborder="0" src="about:blank" id="dislog" name="dialog"></iframe>
</div>
<div id="dialogdivs">
<div class="tisku">
<p class="top50">对不起，您还没有开通此平台的服务，无法学习该课程。</p>
<img src="http://static.ebanhui.com/ebh/tpl/2012/images/elog0913.jpg" />
<p>您可以点击&nbsp;<a style="color:#337fb6;" href="<?= geturl('classactive') ?>" >开通</a>&nbsp;进行学习。</p>
</div>
<div>
<p style="text-align:center;">如果您已经开通此平台的服务，请点击&nbsp;<a style="color:#CD2626;" href="/myroom.html" >进入学习</a>&nbsp;.</p>
</div>
</div>
</div>
<div style="clear: both"></div>
    <?php
	 $this->display('common/player');
    $this->display('common/footer');
    ?>

