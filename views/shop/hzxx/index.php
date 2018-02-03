<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $room['crname'] ?></title>
<meta name="keywords" content="<?=empty($systemsetting['metakeywords'])?'':$systemsetting['metakeywords']?>" />
<meta name="description" content="<?=empty($systemsetting['metadescription'])?'':$systemsetting['metadescription']?>" />
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/citytpl/hangzhouxx/css/hangzhouxx.css" rel="stylesheet" type="text/css" /><script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" rel="stylesheet" />	
<script type="text/javascript">
<!--
	var sitecpurl ='#getsitecpurl()#';
//-->
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<!--[if lte IE 6]>  
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/DD_belatedPNG_0.0.7a.js"></script>  
<script type="text/javascript">  
  DD_belatedPNG.fix('.wrap,.bottom,.cservice img,.cbuyclass,.log,.qtlol img');   
</script>
<![endif]-->

</head>

<body>
<?php $this->display('common/public_header'); ?>
<div class="long">
<div style="width:960px; margin:0 auto; position:relative">
<div style="width:960px;"><img src="http://static.ebanhui.com/ebh/citytpl/hangzhou/images/log040161.jpg" /></div>
<div class="sdfc">
<div class="sate">

<?php 
	$crid=$room['crid'];
	$this->widget('ad_widget', $adlist, array('_id' => 'actor', '_width' => 599, '_height' => 208, 'code'=>'headfocus', 'crid'=>$crid, 'default' => 'http://static.ebanhui.com/ebh/citytpl/stores/images/adzhong0626.jpg'));
?>
</div>
<div class="lite">
	<?php if(empty($user)) { ?>
		<form id="form1" name="form1" action="/login.html?inajax=1&login_from=classroom" onsubmit="form_submit();return false;">
			<input type="hidden" name="loginsubmit" value="1" />
			<div class="vbf">
			<span class="rtul">帐&nbsp; 号：</span>
			<input id="username" name="username" type="text" class="usk" value="帐号" onfocus="if($('#username').val()=='帐号'){$('#username').val('').css('color','#000000');}" onblur="if($('#username').val()==''){$('#username').val('帐号').css('color','#666666');}"
		/></div>
			<div class="vbf" style="margin-bottom:8px; _margin-bottom:1px;"><span class="rtul">密&nbsp; 码：</span>
			  <input id="password" name="password" type="password" class="usk" value="" style="color:black" />
			</div>
			<div class="lo">
			 <?php if(!empty($user)){ ?>
				<input id="xuangou" name="cookietime" type="checkbox" style="height:14px; width:14px; float:left; margin-left:3px;" checked='checked' value="<?= 3600*24*14?>"/>
			<?php }else{ ?>
				<input id="xuangou" name="cookietime" type="checkbox" style="height:14px; width:14px; float:left; margin-left:3px;" value="<?= 3600*24*14?>"/>
			<?php } ?>	  
			</div>
			  <div class="zz">
			<label for="xuangou">下次自动登录</label> <span style="color:#CCC">|</span> <a href="/forget.html" target="_blank">忘记密码</a></div>
			
		      <div style="width:312px;"><input type="submit" class="loginiu" value="" onmouseover="this.className='loginiu2'" onmouseout="this.className='loginiu'" /></div>
			<div class="qtlol" style="width:240px;margin-top:5px;"><span style="color:#000;">用其他账号登录：</span><a href="<?=geturl('otherlogin/qq')?>"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/qqico0830.png" /></a><a href="<?=geturl('otherlogin/sina')?>"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/sianico0830.png" /></a></div>
		 <div class="jky"><p>还没有e板会帐号？<a href="/register.html" target="_blank">免费注册>></a></p></div>
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
				<img src="<?= $facethumb ?>" width="78" height="78" />
			</div>
			<div class="showrig">
				<h2 style="font-weight:bold; font-size:14px; color:#3195c6;"><?= $user['username'] ?></h2>
				<p>上次登录时间：</p>
				<p><?= $user['lastlogintime']?></p>
	
				<p><a href="/classactive.html" target="_blank" style="color:#f27245;">开通服务</a><em style="margin-left:5px; margin-right:5px; color:#ccc;">|</em><a href="/logout.html" style="color:#999;">退出</a></p>
			</div>
		</div>	
  		<?php if($user['groupid'] == 6){ ?>
	      <input type="button" class="loginius" value="" onmouseover="this.className='loginius2'" onmouseout="this.className='loginius'" onclick="window.location.href='/myroom.html'"/>
		<? }else{ ?>
		  <input type="button" class="loginius" value="" onmouseover="this.className='loginius2'" onmouseout="this.className='loginius'" onclick="window.location.href='/troom.html'"/>
		<? } ?>
	<?php } ?>
</div>
</div>
</div>
</div>
<!--2012/04/06end-->

<!--最新添加-->

<!--结束-->
<div class="main">
<div class="buglink">
<ul>
<li><a href="/help/helpguide.html"><img src="http://static.ebanhui.com/ebh/citytpl/hangzhou/images/yindao1106.jpg" /></a></li>
<?php 
		$cloudaddurl="/classactive.html";
?>
<li><a href="<?= $cloudaddurl?>"><img src="http://static.ebanhui.com/ebh/citytpl/hangzhou/images/kaitong1106.jpg" /></a></li>
<li><a href="/classpay.html"><img src="http://static.ebanhui.com/ebh/citytpl/hangzhou/images/chongzhi1106.jpg" /></a></li>
<li><a href="/down.html"><img src="http://static.ebanhui.com/ebh/citytpl/hangzhou/images/bofang1106.jpg" /></a></li>
<li style="margin-right:0px;"><a href="http://soft.ebanhui.com/ebhclient.zip"><img src="http://static.ebanhui.com/ebh/citytpl/hangzhou/images/kehu1106.jpg" /></a></li>
</ul>
</div>
<div class="tbxue">
<div class="xianbg">
<h2 class="tbbg">杭州小学同步学堂</h2>
</div>
<div class="tblef">
<h3 class="titsize">什么是杭州小学同步学堂</h3>
<p style="margin-top:5px;">&nbsp;&nbsp;&nbsp;&nbsp;e板会杭州小学同步学堂为广大的小学生提供在家轻松拥有同步的、重复的学习机会。</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;由杭州地区知名学校的、有着丰富教学经验的优秀老师，根据教育大纲和学校教材同步的课程内容，分年级、分学科的制作优质课件，帮学生捡回失神瞬间的知识，辅导作业和考试，巩固学习成果。</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;学生可以在这里预习、学习、做笔记、复习、做作业、考试、向老师提问、和同学交流、查看老师批阅、检查学习成果等，即使在旅游、休假、候车、外出时，都可以随时随地的进行同步学习。</p>
</div>
<div class="btrig">
<h3 class="titsize">为什么选杭州小学同步学堂</h3>
<ul>
<li>
<img style="float:left;" src="http://static.ebanhui.com/ebh/citytpl/hangzhou/images/whytu11106.jpg" />
<div class="liyou">
<h4 style="font-weight:bold;">教育现状：</h4>
<p style="color:#666;">传统教育中，每个老师面对众多的学生，采用统一的教学，但每个学生学习能力不一样，难免成绩差异。如何让这些孩子能够追上统一教学进度，彻底掌握知识？很多家长选择了昂贵的培训班和辅导班。这么做的结果就是，孩子加重了负担，但是效果一般。有些孩子甚至产生了叛逆心理，放弃了学习。</p>
</div>
</li>
<li>
<img style="float:left;" src="http://static.ebanhui.com/ebh/citytpl/hangzhou/images/whytu21106.jpg" />
<div class="liyou">
<h4 style="font-weight:bold;">同步学堂开启全新的学习模式：</h4>
<p style="color:#666;">如何寻找一个孩子可以接受的，又能产生良好效果的学习方式？这就是同步学堂的研发缘由。杭州中学同步学堂，通过科技手段，让杭州最好的老师精心制作课件，完全根据教学大纲和学校课本进行，可以让孩子们在正常学习的同时，可以反复、重复学习同样的内容，彻底掌握知识。</p>
</div>
</li>
</ul>
</div>
</div>
<div class="titnav" >
<p class="titlezi">大纲导航</p>
<div class="nav">

<div class="dettine">
	<ul id="list1">
		
		<?php foreach($folderlist as $fval ){ ?>
				<li>
					<div class="enidet">
						<div class="dettu">
							<h3><a href="<?= geturl('smallcourse-0-0-0-'.$fval['folderid'])?>" target="dialog" onclick="showdialog()"><?= $fval['foldername']?></a></h3>
							<a class="img-shadow" href="<?= geturl('smallcourse-0-0-0-'.$fval['folderid'])?>" target="dialog" onclick="showdialog()">
								<img src="<?= empty($fval['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$fval['img']?>" width="114" height="159" />
							</a>
						</div>
						<div class="refdet">
							<h5 style="color:#0065ac; font-size:14px; margin-top:5px;"><a href="javascript:freeplay('$fval['cwsource']','$fval['cwid']','$fval['title']',1);" title="<?= $fval['title']?>"><?= shortstr($fval['title'],18,'')?></a></h5>
							<input type="submit" class="audibtn" value="" onmouseover="this.className='audibtn1'" onmouseout="this.className='audibtn'" onclick="javascript:freeplay('$fval['cwsource']','$fval['cwid']','<?= str_replace("'"," ",$fval['title'])?>',1);" />
							<p><?= shortstr($fval['summary'],150)?></p>
						</div>
					</div>
				</li>
		<?php } ?>
	</ul>
</div>

<div class="kelist">
<ul>

	<?php foreach($classlist as $val){ ?>
		<li>
			<a class="ashiting" href="javascript:freeplay('$val['cwsource']','$val['cwid']','<?= str_replace("'"," ",$val['title'])?>',1);" title="<?= $val['title']?>"><img src="http://static.ebanhui.com/ebh/citytpl/hangzhou/images/audution0614.jpg" /></a><p><a href="javascript:freeplay('$val['cwsource']','$val['cwid']','<?= str_replace("'"," ",$val['title'])?>',1);" title="<?= $val['title']?>"><?= ssubstrch($val['title'],0,20)?></a></p>
			</li>
	<?php } ?>
</ul>
</div>
</div>
</div>

<div class="titxuexi">
<p class="titlezi">学习视角</p>
<div class="angle">
<div class="lefangle"><img src="http://static.ebanhui.com/ebh/citytpl/hangzhou/images/ad70614.jpg" />
<h4 class="rude">1、同步学习提高学习效率</h4>
<p>&nbsp;&nbsp;&nbsp;&nbsp;德国著名的心理学家艾宾浩斯根据实验研究发现了记忆遗忘规律，人在学习一天后，如果不抓紧复习，就会忘记75%的内容，随着时间的推移，遗忘的速度减慢，遗忘的数量也会减少。</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;杭州小学同步学堂，严格按照教学大纲和学校同步课程授课，不但让上课走神的孩子们可以回家捡回遗落的知识，还能在随时随地巩固学习，按照遗忘规律，重复学习、反复学习，及时复习，提高学习效果。</p>
<h4 class="rude" style="margin-top:10px;">2、异地学习的最佳方式――同步学堂</h4>
<p>&nbsp;&nbsp;&nbsp;&nbsp;中国地域辽阔，各地中高考实行户籍和学籍相结合的方式，也就是说，如果你的户口在哪里，你必须回到哪里去参加考试。同时，北京、上海等城市实行本地录取分数线差异化形式，让许多家长都努力把孩子的户口放进去，但是孩子就读还是在原来的地区，这样就导致了学习和考试不同区的问题。</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;杭州小学同步学堂解决了在外读书的杭州孩子的学习问题，即使不在杭州也可以学习杭州学校同步的学习内容，听课、做笔记、做作业，让老师批改参加模拟考试，及时的和老师沟通交流等，完全不用担心落下课程，抓不住考试重点。</p>
</div>
<div class="rigangle" style="margin-top:20px;"><img src="http://static.ebanhui.com/ebh/citytpl/hangzhou/images/ad90614.jpg" />
<h4 class="rude">3、同步学堂，撑起平等教育的蓝天</h4>
<p>&nbsp;&nbsp;&nbsp;&nbsp;随着九年制义务教育的推行，很多孩子都能够免除学费，获得学习机会，但是因为家庭原因、地域借读费、学习补习等因素，每年还是需要开支几千甚至几万，几十万的教育费用。面对这些庞大的费用，很多家庭是承担不了。</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;杭州小学同步学堂的课件由杭州地区的特级教师+中青年骨干教师领头，精心制作的同步学习内容，让所有的孩子都能享受名校名师的优质学习，不但学费低，附加值高，而且可以预习下学习和复习之前的学习内容，一次费用，小学课程全部包含。一年之内，想学就学，不限时间不限次数，也不用上下课来回奔波。真正实现平等教育，公平教育，为孩子们撑起同一片教育蓝天，在同一起跑线上前进。</p>
</div>
</div>
</div>
</div>
<div style="clear:both;"></div>
<?php
	$this->display('common/player');
	$this->display('common/footer');
?>