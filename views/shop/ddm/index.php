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
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/citytpl/ddm/css/ddm.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
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
  DD_belatedPNG.fix('.main .top_list li div,.primg,.bottom,.cservice img,.qtlol img');   
</script>  
<![endif]-->
</head>

<body>
<?php $this->display('common/public_header'); ?>
<div class="long">
  <div style="width:960px; margin:0 auto; position:relative;">
    <div style="width:960px;"><a class="alogo" href="http://www.ebanhui.com/"></a></div>
	
    <div class="sdfc">
<?php if(!empty($user)) { 
		$sex = empty($user['sex']) ? 'man' : 'woman';
		$type = $user['groupid'] == 5 ? 't' : 'm';
		$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$type.'_'.$sex.'.jpg';
		$face = empty($user['face']) ? $defaulturl : $user['face'];
		$facethumb = getthumb($face,'78_78');
		$url = $user['groupid'] == 5 ? geturl('troom') : geturl('myroom');
?>

	  <div class="lef_log">
		<div class="usouter">
		<div class="figlef">
		<img src="<?= $facethumb?>" width="78" height="78" /></div>
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
	      <input type="submit" class="logbtn1" value=""  onmouseover="this.className='logbtn0'" onmouseout="this.className='logbtn1'" onclick="window.location.href='/myroom.html'" />
		<?php }else{ ?>
		  	<input type="submit" class="logbtn1" value=""  onmouseover="this.className='logbtn0'" onmouseout="this.className='logbtn1'" onclick="window.location.href='/troom.html'" />
		<?php } ?>
	  </div>
<?php } else { ?>


      <div class="lef_log">
      
      <form id="form1" name="form1" action="/login.html?inajax=1&login_from=classroom" onsubmit="form_submit();return false;"> 
		<input type="hidden" name="loginsubmit" value="1" />
	  	<div class="vbf" style="margin-top:40px;">
			<input  class="usk" id="username" 
				onblur="if($(this).val()==''){$(this).val('账号').css('color','#cccccc');}" 
				onfocus="if($(this).val()=='账号'){$(this).val('').css('color','#000000');}" 
				value="账号" name="username"/>
		</div>
		<div class="vbf">
			<input class="usk" id="show" onfocus="$(this).hide();$('#password').show().css('color','#000000');$('#password').show().focus()" style="color:#cccccc" value="密码" />
			
	  		<input class="usk" id="password" onblur="if($(this).val()==''){$(this).hide();$('#show').show().css('color','#cccccc');}" style="DISPLAY: none" type="password" name="password"/>
		</div>
		<div id="lo">
	  		<?php if(!empty($user)) { ?>
	  		<input id="xuangou" name="cookietime" type="checkbox" value="<?= 3600*24*14?>" checked="checked" />	  
	  		<?php }else{ ?>
	  		<input id="xuangou" name="cookietime" type="checkbox" value="<?= 3600*24*14?>"  />
	  		<?php } ?>	  
	  	</div>
	  	<div class="zz">
	<label for="xuangou">下次自动登录</label> <span style="color:#CCC">|</span> <a href="/forget.html" target="_blank">忘记密码</a></div>
	
      <input type="submit" class="logbtn" value=""/>
	  <div class="qtlol" style="margin-top:15px;width: 220px;"><span style="color:#000;">用其他账号登录：</span><a href="/sitecp.html?action=connect_login&op=qq"><img 
	src="http://static.ebanhui.com/ebh/tpl/2012/images/qqico0830.png" /></a><a href="/sitecp.html?action=connect_login&op=sina"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/sianico0830.png" 
	/></a></div>
 <div class="jky"><p>还没有e板会帐号？<a href="/classactive.html">立即开通>></a></p></div>
 
	  </div>
	  </form>
<?php } ?>

        	<div class="rig_ad">
        	
			 <?php
                $this->widget('ad_widget', $adlist, array('_id' => 'actor', '_width' => 670, '_height' => 230));
             ?>
		</div>
    </div>
  </div>
</div>

<div class="main">
<div class="top_list">
<ul>
<li>
<div class="yindaoico">
<a href="/help/helpguide.html" target="_blank" class="yindaobtn"></a>
  <span>第一次登录动动漫的同学们，点击这里，可以引导你如何使用各个功能！</span>
</div>
</li>
<li>
<div class="openico">

<a href="/classactive.html" target="_blank" class="openbtn"></a>
  <span>新来的同学们，点击这里，享受一站式的账号注册、学习申请的服务吧！</span>
</div>
</li>
<li>
<div class="rechargeico">
<a href="/sitecp.html?action=classpay" target="_blank" class="rechargebtn"></a>
  <span>新购卡或快到期的同学们，点击这里，可以快速充值缴费，开通学习权限哦！</span>
</div>
</li>
<li>
<div class="playico">
<a href="/down.html" target="_blank" class="playbtn"></a>
  <span>第一次开通服务，进行学习之前，点击这里，下载播放器吧！</span>
</div>
</li>
<li>
<div class="clientico">
<a href="http://soft.ebanhui.com/ebhclient.zip" target="_blank" class="clientbtn"></a>
  <span>无需打开网页，点击这里，下载客户端，可直接在桌面快速登录！</span>
</div>
</li>
</ul>
</div>
<div class="eddm">
<div class="tits"><img src="http://static.ebanhui.com/ebh/citytpl/ddm/images/tit_lef10703.png" />
<h2 class="tit_eddm">[e板会]动动漫</h2><img src="http://static.ebanhui.com/ebh/citytpl/ddm/images/tit_rig10703.png" />
</div>
<div class="eddm_lef"></div>
<div class="eddm_main">
<div class="whyeddm">
<p>[e板会]动动漫是针对广大动漫爱好者、动漫初学者、<br />动漫再学习者、动漫应试者的需求而设的独立动漫学习平台，免去高额学费，无需来回奔波上课，直接在家，就可从入门基础开始，逐步深入学习构图、造型、着色、动作、渲染、合成、后期编辑等，快速掌握动漫技巧，并能实现学以致用，制作自己的动画人物和动漫作品。</p>
</div>
<div class="whyrig">
<img src="http://static.ebanhui.com/ebh/citytpl/ddm/images/whyddm0703.png" />
<ul>
<li class="whybgtu">
<h3 class="sizes">新技术</h3>
<p>动动漫依托e板会品牌技术，实现交互式网络授课，真实高效，学习更加轻松，效果更加显著。</p>
</li>
<li>
<h3 class="sizes">唯一性</h3>
<p>独创真实笔触的手绘笔技术，可以呈现轻重深浅的绘画效果；通过黑板+投影技术，呈现真实课堂场景；交互沟通，随和可以询问老师获得指导。这些都是全球唯一，网络上唯一的学习模式。</p>
</li>
<li>
<h3 class="sizes">学费低</h3>
<p>以往学习，2、3个月学费，就需要四、五千元，而且只包含某个方面的学习内容；[e板会]动动漫分享式学习，包年500元，不限次数，不限时间，当年可以享受全科全部的学习内容。</p>
</li>
</ul>
</div>
<div class="jiess">
<ul>
<li>
<h3 class="sizes">实战指导</h3>
<p>动漫学习，更加注重实战训练，学一点，运用一点，并接受老师实时的一对一指导，掌握更精确，学习更有针对性。</p>
</li>
<li>
<h3 class="sizes">完备的师资</h3>
<p>聘请拥有多年项目研发经验和动漫教学经验的老师，理论+实践结合授课。</p>
</li>
<li>
<h3 class="sizes">互动交流学习模式</h3>
<p>首创教育互动技术，实现随时随地的师生交流、学员互动，让学习变成一件有趣的事情。</p>
</li>
<li>
<h3 class="sizes">创新课程体系</h3>
<p>直接链接e板会运系统，可以分享海量的教学资源，引领行业潮流。</p>
</li>
</ul>
</div>
<div class="letter">
<div class="letlef">
<div class="brand">
<a class="img-shadow" href="#"><img src="http://static.ebanhui.com/ebh/citytpl/ddm/images/fengmian0703.jpg" width="100" height="100" /></a>
<h1 class="primg"></h1>
<p>原价1000元/年</p>
</div>
<div class="address">
<ul><?php $url='http://'.$room['domain'].'.ebanhui.com'?>
<li class="email">邮箱：<a href="mailto:<?= $room['cremail']?>"><?= $room['cremail']?></a></li>
<li class="phone">电话：<?= $room['crphone']?></li>
<li class="qq">Q&nbsp;<span style="margin-left:5px;">Q：<a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<? $room['crqq']?>&amp;site=qq&amp;menu=yes"><?= $room['crqq']?></a></li>
<li class="url">网址：<a title="动动漫" href="<?= $url?>"><?= $url?></a></li>
<li class="site">地址：<?= $room['craddress']?></li>
</ul>
</div>
</div>
<div class="letrig">
<h4><img src="http://static.ebanhui.com/ebh/citytpl/ddm/images/terijjes0703.png" width="505" height="37" /></h4>
<p>由美院和动动漫的专业教师进行授课，有些教师有丰富的实战经验，熟悉整个制作流程，对每个过程中的绘画、衔接、人物造型、场景布置等有独家技巧；有些教师有丰富的理论知识，多年授课，系统掌握动漫各方面的发展，培养学员全方位的理论知识；有些教师有较强的行业运筹能力，对整个行业的形式和发展趋势有独到见解，引领综合学习方向。专业教师各展所长，倾囊相授，从基础的素描开始，逐渐提升难度，加入技巧讲解，方便学员逐层深入学习，并提供一对一的个性化指导，提高学员动漫创作能力，培养独当一面的专业动漫人才。
</p>
</div>
</div>
</div>
<div class="eddm_rig"></div>
</div>
<div class="meun">
<div class="lef_meun"></div>
<div class="miain_meun" id="list1">
<h2 class="tit_menu">大纲导航</h2>
<ul>
<?php foreach($freecourselist as $fval){?>
	<li>
	<div class="dettu"><a target="dialog" onclick="showdialog()" class="img-shadow" href="<?= geturl('smallcourse-0-0-0-'.$fval['folderid'])?>"><img src="<?= empty($fval['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$fval['img']?>" width="114" height="159" /></a></div>
	<div class="refdet">
	<h5 style="color:#6f552c; font-size:14px; margin-top:5px;"><a href="javascript:freeplay('<?= $fval['cwsource']?>','<?= $fval['cwid']?>','<?= $fval['title']?>',1);"><?= $fval['title']?></a></h5>
	<input type="submit" class="audibtn" value="" onmouseover="this.className='audibtn1'" onmouseout="this.className='audibtn'" onclick="javascript:freeplay('<?= $fval['cwsource']?>','<?= $fval['cwid']?>','<?= $fval['title']?>',1);" />
	<p><?= shortstr($fval['summary'],96)?></p>
	</div>
	</li>
<?php } ?>

</ul>
</div>
<div class="rig_meun"></div>
</div>
<div class="info">
<div class="lef_info"></div>
<div class="main_info">
<h2 class="tit_menu">动漫资讯</h2>
<div class="run_menu">
<p class="sekdf">从事金融行业的小李对动漫情有独钟，甚至专门抽出了时间去动漫培训班学习了一段时间的动漫学习。但是每周周末学习，学了近一年，才学会了基本的素描。小李觉得这个进度，估计短期内无法达成所愿，制作自己的动漫作品了，甚至还会逐渐抹杀自己对动漫的爱好了，毕竟学习是一件枯燥的事情。</p>
<div class="sizee">
<p class="baitit">近年来，动漫行业发展迅速，杭州也被评为了动漫之都。动漫人才需求极大，然而很多技术因素制约了人们的学习热情，学习费用高，学习周期长等成为主要掣肘因素。很多动漫爱好者为了不能自由创作出自己的动漫作品而倍感遗憾。</p>
<p class="houzes">后来，他接触到[e板会]动动漫后，发现原来学动漫制作也可以变得有趣而快捷。由于[e板会]动动漫学习是在网络上进行的，随时随地可以抽出二十分钟来学习，在家里，在公司，在旅游时，都可以坚持每天学习,很方便。学习中，老师们不但教授专业知识，还会讲些相应的小技巧以及行业动态，可以加深他对动漫的了解，掌握最近的讯息。这也是他保持学习兴趣的原因之一。由于每天都能学习一点，看似很简单，很少，但是不到2个月时间就已经学会了原先需要1年才能学完的东西。接下去，小李打算继续学习下阶段的内容。原来[e板会]动动漫提供从基础到完整作品的全部过程学习，只要循序渐进就可以了。等到学会全部内容后，还可以参加毕业考核，获得网络毕业证！小李相信，经过一年的学习，他一定可以完整的制作出自己的作品，分享给大家！</p>
</div>
</div>
</div>
<div class="rig_info"></div>
</div>
<div style=" margin-bottom:5px;"><img src="http://static.ebanhui.com/ebh/citytpl/ddm/images/fot_ad0703.jpg" /></div>
</div>
<?php
$this->display('common/player'); 
$this->display('common/footer');
?>

