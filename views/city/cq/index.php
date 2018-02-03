<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $room['crname'] ?>(e板会)</title>
<meta name="keywords" content="<?= $room['crlabel'] ?>" />
<meta name="description" content="<?= $room['summary'] ?>" />
<!--[if lte IE 6]>  
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/DD_belatedPNG_0.0.7a.js"></script>  
<script type="text/javascript">  
  DD_belatedPNG.fix('.head-logo,.head-logo a ,.current-city,.head-logo-text,.header-area span,.bottom,.cservice img,.qtlol img');   
</script>  
<![endif]-->
<link href="http://static.ebanhui.com/ebh/citytpl/chongqing/css/base.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/citytpl/chongqing/css/cqgai.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" rel="stylesheet" />	
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
	<div style="width:auto; min-width:960px; padding-bottom:4px; background:url(http://static.ebanhui.com/ebh/citytpl/chongqing/images/top_border_bottom.gif) repeat-x left bottom;">
      	<div class="box960" style="position:relative; height:82px; overflow:hidden; background:url(http://static.ebanhui.com/ebh/citytpl/chongqing/images/top_bg_img.jpg) no-repeat 0 0;">
      		<div class="head-logo"><a href="http://cq.ebanhui.com/">e板会</a><span class="head-logo-text">全球领先的网络在线资源有偿分享增值服务平台</span></div>
            <div class="head-city-select"><span class="current-city"><a>重庆站</a></span><a></a></div>
      	</div>    
    </div>
    <div class="box960" style="margin-top:15px;">
    	
        <div style="width:613px; float:left; height:215px; overflow:hidden; padding:9px; background:#CDE8F3;">
            
               <?php 
					$crid=$room['crid'];
					$this->widget('ad_widget', $adlist, array('_id' => 'actor', '_width' => 613, '_height' => 213, 'crid'=>$crid, 'default' => '/static/citytpl/stores/images/adzhong0626.jpg'));
				?>
        </div>
        <div style="width:329px; float:left; height:233px; background:url(http://static.ebanhui.com/ebh/citytpl/chongqing/images/login_box_bg.png) no-repeat;">
        	<?php if(empty($user)) {?>
	        	<form id="form1" name="form1" action="/login.html?inajax=1&login_from=classroom" onsubmit="form_submit();return false;">
	        	<table width="329" border="0" cellspacing="0" cellpadding="0">
	              <tr>
	                <td height="32" colspan="2"><input type="button" name="uRegist" value="" onclick="javascript:window.open('/register.html');" style="float:right; border:none; width:75px; height:28px; background:url(http://static.ebanhui.com/ebh/citytpl/chongqing/images/btn_regist.png) no-repeat; cursor:pointer;" /><span style="float:right; color:#00ADEF; margin-top:5px;">成为e板会一员，一起加入同步学堂。</span></td>
	              </tr>
	              <tr>
	                <td width="99" height="42" align="center" style="font-size:14px; color:#00ADEF;">&nbsp;登录</td>
	                <td width="230">&nbsp;</td>
	              </tr>
	              <tr>
	                <td height="35" align="right" style="font-size:14px; color:#006699;">账&nbsp;&nbsp;号&nbsp;</td>
	                <td><input name="username" id="username" type="text" class="" value="账号" style="border:none; height:15px; line-height:15px; padding:6px 0 6px 8px; background:url(http://static.ebanhui.com/ebh/citytpl/chongqing/images/input_box_bg.png) no-repeat; width:195px; float:left; font-size: 16px; font-weight: bold; color:#666;" onfocus="if($('#username').val()=='账号'){$('#username').val('').css('color','#000000');}" onblur="if($('#username').val()==''){$('#username').val('账号').css('color','#666666');}"/></td>
	              </tr>
	              <tr>
	                <td height="35" align="right" style="font-size:14px; color:#006699;">密&nbsp;&nbsp;码&nbsp;</td>
	                <td><input name="password" id="password" type="password" class="" style="border:none; height:15px; line-height:15px; padding:6px 0 6px 8px; background:url(http://static.ebanhui.com/ebh/citytpl/chongqing/images/input_box_bg.png) no-repeat; width:195px; float:left; font-size: 16px; font-weight: bold;" /></td>
	              </tr>
	              <tr>
	                <td height="37" colspan="2" style="padding-left:52px;">
	                <input id="xuangou" name="cookietime" style="float:left; height:14px; width:14px; margin:8px 8px 0 0; _margin-right:5px;" type="checkbox" checked='checked' value="1" />
					<input type="hidden" name="loginsubmit" value="1" />
	                <label for="xuangou" style="float:left; margin-top:6px; *margin-top:5px; _margin-top:6px;">自动登录 |&nbsp</label> <a style="float:left; margin-top:6px; *margin-top:5px; _margin-top:6px;" href="/forget.html">忘记密码？</a><input id="loginsubmit" type="submit" value="" style="float:left; border:none; width:57px; height:24px; background:url(http://static.ebanhui.com/ebh/citytpl/chongqing/images/btn_login.png) no-repeat; cursor:pointer; margin-left:43px;" /></td>
					<tr>
					<td style="padding-left:76px;"><div class="qtlol" style="position: absolute;"><span style="color:#000;">用其他账号登录：</span><a href="<?=geturl('otherlogin/qq')?>"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/qqico0830.png" /></a><a href="<?=geturl('otherlogin/sina')?>"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/sianico0830.png" /></a></div></td>
					</tr>
	              </tr>
	            </table>
	            </form>
            <?php }else{ ?>
				 <?php
					$sex = empty($user['sex']) ? 'man' : 'woman';
					$type = $user['groupid'] == 5 ? 't' : 'm';
					$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$type.'_'.$sex.'.jpg';
					$face = empty($user['face']) ? $defaulturl : $user['face'];
					$facethumb = getthumb($face,'78_78');
					$url = $user['groupid'] == 5 ? geturl('troom') : geturl('myroom');
					
				 ?>
	            <div class="usouter">
					<div class="figlef">
						<img src="<<?= $facethumb ?>" width="78" height="78" />
					</div>
					<div class="showrig">
						<h2 style="font-weight:bold; font-size:14px; color:#3195c6;"><?= $user['username'] ?></h2>
						<p>上次登录时间：</p>
						<p><?= $user['lastlogintime']?></p>
							<?php if($user['groupid'] == 6) { ?>
						<p><a href="/classactive.html" target="_blank" style="color:#f27245;">开通服务</a><em style="margin-left:5px; margin-right:5px; color:#ccc;">|</em><a href="/logout.html" style="color:#999;">退出</a></p>
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
        <div class="clear" style="height:10px; background:url(http://static.ebanhui.com/ebh/citytpl/chongqing/images/line_shadow.png) no-repeat;"></div>
    </div>
<div class="main">
	<div class="top_list">
<ul>
<li>
<div class="lef_bg"></div>
<div class="list_bg">
<div class="yindaoico">
<a href="/help/helpguide.html" class="yindaobtn"></a>
  <span>第一次登录重庆同步学堂的同学们，点击这里，可以引导你如何使用各个功能！</span>
</div>
</div>
<div class="rig_bg"></div>
</li>
<li>
<div class="lef_bg"></div>
<div class="list_bg">
<div class="openico">
<a href="$cloudaddurl" class="openbtn"></a>
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
<a href="http://www.ebanhui.com/down.html" target="_blank" class="playbtn"></a>
  <span>第一次开通服务，进行学习之前，点击这里，下载播放器吧！</span>
</div>
</div>
<div class="rig_bg"></div>
</li>
<li style=" margin-right:0px;">
<div class="lef_bg"></div>
<div class="list_bg">
<div class="clientico">
<a href="http://soft.ebanhui.com/ebhclient.zip" class="clientbtn" class="clientbtn"></a>
  <span>无需打开网页，点击这里，下载客户端，可直接在桌面快速登录！</span>
</div>
</div>
<div class="rig_bg"></div>
</li>
</ul>
</div>
	
<div class="xuetang">
<div class="titxt">
<h2 class="titcqxt">重庆中小学同步学堂</h2>
<div class="lefxt">
<div class="whytbxt">
<p style="margin-top:50px;">重庆中小学同步学堂[e板会]是为重庆地区中小学生提供在家轻松拥有同步的、重复的学习机会。同步学堂分年级、分学科，提供教育大纲和学校教材同步的课程内容，帮学生捡回失神瞬间的知识，辅导作业和考试，巩固学习成果。</p>
<p>学生可以在这里预习、学习、做笔记、复习、做作业、考试、向老师提问、和同学交流、查看老师批阅、检查学习成果等，即使在旅游、休假、候车、外出时，都可以随时随地的进行同步学习。</p>
</div>
<div class="letlef">
<div class="brand" id="list1">
<ul>
<li>
<?php $logo=empty($room['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$room['cface']?>
<a class="img-shadow" href="#"><img src="<?= $logo?>" width="100" height="100" /></a>
</li>
</ul>
<h1 class="primg"></h1>
<?php $price=$room['crprice']*2?>
<p>原价元<?= $price?>/年</p>
</div>
<div class="address">
<ul><?php $url='http://'.$room['domain'].'.ebanhui.com'?>
<li class="email">邮箱：<strong style="color:#E67817;"><a style="color:#E67817;font-size:14px;" href="mailto:<?= $room['cremail']?>"><?= $room['cremail']?></a></strong></li>
<li class="phone">电话：<strong style="font-size:24px; font-family:Arial; color:#DA251C;"><?= $room['crphone']?></strong></li>
<li class="qq">Q &nbsp;Q：<strong style="color:#DA251C;"><a style="color:#DA251C;font-size:16px;" target="_blank"  href="http://wpa.qq.com/msgrd?v=3&uin=$room['crqq']&site=qq&menu=yes"><?= $room['crqq']?></a></strong></li>
<li class="url">网址：<strong style="color:#E67817;"><a href="$url" style="color:#E67817;font-size:16px;"><?= $url?></a></strong></li>
<li class="site">地址：<?= $room['craddress']?></li>

</ul>
</div>
</div>
</div>
<div class="rigxt">
<div class="lexuz">
<h3 class="huitit">择校择师现状</h3>
<p>中国教育存在的地区不平衡性，即使同一个地区，不同的学校之间，也存在的师资的巨大差别，因为，择校难、择师难的问题广泛的存在于各个地区。为了弥补择校择师的遗憾，很多家长不遗余力的给孩子报了各种培训班和辅导班，希望用数量来弥补质量。这样做的结果是，孩子的负担重了，学习效果却一般。有些孩子甚至产生了逆反心理，自暴自弃，放弃学习。</p>
<h3 class="huitit" style="margin-top:10px;">家长的心声</h3>
<p style="width:230px;">望子成龙、望女成凤，是许多家长的心愿，为了孩子的一切，家长付出了巨大的精力和财力，就希望给孩子营造一个良好的学习氛围。</p>
</div>
<div class="rigsz">
<h3 class="huitit">同步学堂开启全新的学习模式</h3>
<p>如何寻找一个孩子可以接受的，又能产生良好效果的学习方式？这就是同步学堂的研发缘由。重庆中小学同步学堂通过科技手段，邀请重庆最优秀的老师，根据教学大纲和学校教材，制作同步的知识课件，让孩子在正常学习的同时，可以反复的、重复的学习同样的内容，彻底掌握知识。</p>
</div>
</div>
<div class="folot">
<img src="http://static.ebanhui.com/ebh/citytpl/chongqing/images/jies0907.jpg" style="float:left;margin-left: 12px;" />
<div class="sition">
<p>诚邀重庆一中、重庆三中、重庆八中、巴蜀中学等等重庆地区知名学校的优秀老师组成授课小组，根据教学大纲和同步学习制作而成。所有授课老师均有多年的教龄和丰富的教学经验，曾经担任教研组长、教科研主任，在指导奥数、自然、化学等各类学习竞赛中取得过优异成绩，教学手段丰富、教学目标明确，对调动学生学习热情，提高学习兴趣，提高学习效率，辅导学习进步方面，具有丰富的经验。</p>
</div>
</div>
</div>
</div>
<div class="dkght">
<ul id="swul">
<li class="swotas"><p style="width:280px;" class="scriptfef">旅游、休假、候车、外出……无论何时何地，都可以通过电脑、手机、Ipad等多种媒体进行学习。</p></li>
<li class="swotbs"><p class="scriptfef">在家就可学习，不必东奔西跑，免去择校之苦，轻松享受名校同步教学。</p></li>
<li class="swotcs"><p style="margin-top:50px;" class="scripts">有大量的优秀老师专门辅导学习，解答难题，批改作业，检查学习进度，反馈问题。</p></li>
<li class="swotds"><p class="scripts">包含初中所有年级的所有主要学科，语文、数学、英语、科学，助您一步到位，冲刺中考。</p></li>
<li class="swotes"><p class="scriptfef">课后作业，单元测试，都有老师批改、反馈，辅助学习。</p></li>
<li class="swotfs"><p class="scriptfef">免去择校择师费用，远远低于家教的价格，让你轻松享受优质的教育服务。</p></li>
<li class="swotgs"><p class="scripts">邀请当地特级教师+中青年骨干教师+学科带头人，根据教学大纲和当地教材，共同制作课件，确保学习质量。</p></li>
<li class="swoths"><p class="scriptfef">将要开发远程锁屏功能，可申请锁屏服务，让电脑在上课时只能用于听课，有效管理孩子的学习。</p></li>
<li class="swotis"><p class="scripts">分享海量教学资源，根据个性需求选择合适的内容和上课风格，实现量体裁衣式的学习，远胜于一对一的家教效果。</p></li>
</ul>
</div>

<div class="shiting">
<div class="titxt">
<h2 class="titcqst">免费试听</h2>
<ul>			
<?php foreach($freelist as $key=>$val){ ?>
							<?php if($key<=3){ ?>
<li class="quckl"><i><a href="javascript:freeplay('<?= $val['cwsource']?>','<?= $val['cwid']?>','<?= str_replace("'"," ",$val['title'])?>',1);"><img src="http://static.ebanhui.com/ebh/citytpl/chongqing/images/kejianico0906.jpg" /></a></i><a href="javascript:freeplay('<?= $val['cwsource']?>','<?= $val['cwid']?>','<?= str_replace("'"," ",$val['title'])?>',1);" title="<?= $val['title']?>"><?= shortstr($val['title'],28)?></a></li>
							<?php }else{ ?>
<li><i><a href="javascript:freeplay('<?= $val['cwsource']?>','<?= $val['cwid']?>','<?=  str_replace("'"," ",$val['title'])?>',1);"><img src="http://static.ebanhui.com/ebh/citytpl/chongqing/images/kejianico0906.jpg" /></a></i><a href="javascript:freeplay('<?= $val['cwsource']?>','<?= $val['cwid']?>','<?= str_replace("'"," ",$val['title'])?>',1);" title="<?= $val['title']?>"><?= shortstr($val['title'],28)?></a></li>
							<?php } ?>
<?php } ?>
</ul>
</div>
</div>

<div class="dagang">
<div class="titxt">
<h2 class="titcqdg">学习大纲</h2>
<ul class="list1">

		<?php foreach($folderlist as $fval){ ?>
<li>
<div class="enidet">
<div class="dettu">
<h3><a target="dialog" onclick="showdialog()" href="<?= geturl('smallcourse-0-0-0-'.$fval['folderid'])?>" title="<?= $fval['foldername']?>"><?= shortstr( $fval['foldername'],14)?></a></h3>
<a class="img-shadow" href="<?= geturl('smallcourse-0-0-0-'.$fval['folderid'])?>" target="dialog" onclick="showdialog()"><img src="<?= empty($fval['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$fval['img']?>" width="114" height="159" /></a>
</div>
</div>
</li>
		<?php } ?>
</ul>
</div>
</div>

<div class="maad"><img src="http://static.ebanhui.com/ebh/citytpl/chongqing/images/ad10907.jpg" /></div>
<div class="shijiao">
<div class="titxt">
<h2 class="titcqsj">学习视角</h2>
<div class="lefot">
<img src="http://static.ebanhui.com/ebh/citytpl/chongqing/images/newtu09071.jpg" />
<h4>1、同步学习提高学习效率</h4>
<p>德国著名的心理学家艾宾浩斯根据实验研究发现了记忆遗忘规律，人在学习一天后，如果不抓紧复习，就会忘记75%的内容，随着时间的推移，遗忘的速度减慢，遗忘的数量也会减少。</p>
<p>重庆中小学同步学堂，严格按照教学大纲和学校同步课程授课，不但让上课走神的孩子们可以回家捡回遗落的知识，还能在随时随地巩固学习，按照遗忘规律，重复学习、反复学习，及时复习，提高学习效果。</p>
<p>有人为此做了一个实验：两组学习在学校学习了一堂语文课，甲组同学回家后在同步学堂又学习了一遍，乙组同学不予复习，一天以后，甲组学习内容保持了98%，乙组保持了56%；一周以后，甲组保持83%，乙组保持33%，甲组的记忆平均值比乙组要高很多。</p>
<img src="http://static.ebanhui.com/ebh/citytpl/chongqing/images/newtu09073.jpg" />
</div>
<div class="rigot">
<h4>2、同步学堂——同一片蓝天的平等教育</h4>
<p>随着教育的发展，每个孩子都能享受到九年制义务教育，但是由于各地资源差异和家庭经济差异，并不是每个孩子都能享受到平等的优质教育，择校难、择师难是当前普遍存在的问题。</p>
<p>重庆中小学同步学堂，组织重庆地区最优秀的老师，精心制作同步学习内容，让所有孩子能都享受到名校名师的优质学习资源，学费低、效果好、附加值高，包括从预习、听课、复习、作业、考试、笔记交流、单元练习、老师在线一对一解答等一系列学习内容和服务，轻松在家学习，开启平等教育新时代，让孩子们享受同一片教育蓝天。</p>
<img src="http://static.ebanhui.com/ebh/citytpl/chongqing/images/newtu09072.jpg" />
<h4>3、异地学习的最佳方式——同步学堂</h4>
<p>中国地域辽阔，各地中高考实行户籍和学籍相结合的方式，也就是说，如果你的户口在哪里，你必须回到哪里去参加考试。同时，北京、上海等城市实行本地录取分数线差异化形式，让许多家长都努力把孩子的户口放进去，但是孩子就读还是在原来的地区，这样就导致了学习和考试不同区的问题。
小洁是重庆的学生，从小跟着父母在河南生活，也在当地上学。但是收到户籍的限制，他必须回重庆参加考试。为了再最短的时间内学习和掌握重庆的学习内容，正常参加考试，他的父母给他报名参加了重庆中小学同步学堂，年费仅600，可以学习中小学各个阶段的所有科目的内容。据他们了解，重庆中小学同步学堂的由重庆地区最优秀的老师授课，精心制作学校同步课件的，还包含预习、听课、复习、做笔记、单元练习、考试等内容，还有老师24小时网络在线指导，有任何学习上的问题，也可以及时的和老师沟通，完全不用担心落下课程。经过一段时间的学习和测试，小洁的父母发现，孩子的成绩不但有所提升，而且学习兴趣也更加浓郁了。对于跨地区考试，小洁信心在握。</p>
</div>
</div>
</div>
<div class="maad"><img src="http://static.ebanhui.com/ebh/citytpl/chongqing/images/ad20907.jpg" /></div>
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
<div class="clear"></div>
<?php
$this->display('common/player');
$this->display('common/footer');
?>
