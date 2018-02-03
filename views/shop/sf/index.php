<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $room['crname'] ?></title>
<meta name="keywords" content="<?=empty($systemsetting['metakeywords'])?'':$systemsetting['metakeywords']?>" />
<meta name="description" content="<?=empty($systemsetting['metadescription'])?'':$systemsetting['metadescription']?>" />
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/citytpl/sf/css/calig.css" />
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
<!--[if lte IE 6]>  
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/DD_belatedPNG_0.0.7a.js"></script>  
<script type="text/javascript">  
  DD_belatedPNG.fix('.main .sdcalig .sd_fot .ler_diz .sd_diz li,.bottom,.cservice img,.qtlol img');   
</script>  
<![endif]-->

</head>

<body>
<?php $this->display('common/public_header'); ?>
<!--头部登录与广告-->
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
	      <input type="submit" class="logbtn3" value="" onmouseover="this.className='logbtn4'" onmouseout="this.className='logbtn3'" onclick="window.location.href='/myroom.html'" />
	<?php }else{ ?>
		  	<input type="submit" class="logbtn3" value="" onmouseover="this.className='logbtn4'" onmouseout="this.className='logbtn3'" onclick="window.location.href='/troom.html'" />
	<?php } ?>
	
	</div>
<?php } else { ?>
      <div class="lef_log">
    <form id="form1" name="form1" action="/login.html?inajax=1&login_from=classroom" onsubmit="form_submit();return false;">
		<input type="hidden" name="loginsubmit" value="1" />
	  	<div class="vbf" style="margin-top:30px;">
			<input class="usk" id="username" onblur="if($(this).val()==''){$(this).val('账号').css('color','#CCCCCC');}" onfocus="if($(this).val()=='账号'){$(this).val('').css('color','#000000');}" value="账号" name="username"/>

		</div>
		<div class="vbf" >
			<INPUT class="usk" id="show" onfocus="$(this).hide();$('#password').show().css('color','#666666');$('#password').show().focus()" style="color:#cccccc" value="密码"> 
			<INPUT class="usk" id="password" onblur="if($(this).val()==''){$(this).hide();$('#show').show().css('color','#cccccc');}" style="DISPLAY: none" type="password" name="password">
		</div>
		<div id="lo">
		<?php if(!empty($user)) { ?>
				<input id="xuangou" name="cookietime" type="checkbox" style="height:14px; width:14px; float:left; margin-left:3px;" checked='checked' value="<?= 3600*24*14?>"/>
		<?php }else{ ?>
				<input id="xuangou" name="cookietime" type="checkbox" style="height:14px; width:14px; float:left; margin-left:3px;" value="<?= 3600*24*14?>"/>
		<?php } ?>
	  	</div>
	  	<div class="zz">
	<label for="xuangou">下次自动登录</label> <span style="color:#CCC">|</span> <a href="/forget.html" target="_blank">忘记密码</a></div>
	
      <div><input type="submit" class="logbtn" onmouseout="this.className='logbtn'" onmouseover="this.className='logbtn1'" value="" /></div>
		<div class="qtlol" style="width:215px;margin-top:5px;"><span style="color:#000;">用其他账号登录：</span><a href="<?=geturl('otherlogin/qq')?>"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/qqico0830.png" /></a><a href="<?=geturl('otherlogin/sina')?>"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/sianico0830.png" /></a></div>
 <div class="jky"><p>还没有e板会帐号？<a href="/classactive.html" style="color:#f27245;">立即开通>></a></p></div>
 
	  </div>

		</form>
<?php } ?>
     
     
	  <?php 
	$crid=$room['crid'];
	$this->widget('ad_widget', $adlist, array('_id' => 'actor', '_width' => 650, '_height' => 220, 'code'=>'headfocus', 'crid'=>$crid, 'default' => '/static/citytpl/stores/images/adzhong0626.jpg'));
?>
		
        	<div class="rig_ad"></div>
    </div>
  </div>
</div>
<!--中间内容-->
<div class="main">
<div class="top_list">
<ul>
<li>
<div class="yindaoico">
<a href="/help/helpguide.html" target="_blank" class="yindaobtn"></a>
  <span>第一次登录生动书法的同学们，点击这里，可以引导你如何使用各个功能！</span>
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
<a href="/sitecp.html?action=classpay" class="rechargebtn"></a>
  <span>新购卡或快到期的同学们，点击这里，可以快速充值缴费，开通学习权限哦！</span>
</div>
</li>
<li>
<div class="playico">
<a href="/down.html" class="playbtn"></a>
  <span>第一次开通服务，进行学习之前，点击这里，下载播放器吧！</span>
</div>
</li>
<li>
<div class="clientico">
<a href="http://soft.ebanhui.com/ebhclient.zip" class="clientbtn"></a>
  <span>无需打开网页，点击这里，下载客户端，可直接在桌面快速登录！</span>
</div>
</li>
</ul>
</div>
<div class="sdcalig">
<div class="sd_top">
<div class="sd_lef">
<h3 class="tit_sd">什么是<span>[e板会]声动书法</span></h3>
<p>[e板会]声动书法是针对广大的书法爱好者、书法初学者而设的书法学习和书法欣赏平台。通过高科技手段，让手绘笔呈现真实的毛笔、钢笔的功能，可以随着使用者的手感体现出不同的粗细、浓淡、笔锋、结构等，从而实现在线书法学习和书写，让大家在家就能轻松、快速、随意的学得一手好字。</p>
</div>
<div class="sd_why">
<h3 class="tit_sd">为什么选择<span>[e板会]声动书法</span></h3>
<p class="bolds">书法是中国传统文化中重要的组成部分</p>
<p>迄今已经有了三千多年的历史，是古人聪明和智慧的结晶，是我们的祖先留给我们的一笔巨大的宝贵财富，是我国独有的一门艺术。从小学习书法，能够陶冶情操，提高文化和艺术素养，为个人全面发展打下良好的基础。</p>
<p class="bolds">传承书法文化，是每个中华儿女的责任</p>
<p>教育部早已将书法学习列为中小学生的一门必修科目，作为青少年素质教育的一项重要内容；90%以上的书法培训班、授课班为书法爱好者自发成立的机构，将传承书法艺术作为毕生目标。</p>
</div>
<div class="sd_rig">
<p class="bolds">让书法在信息化时代继续传承并发展下去</p>
<p>是[e板会]声动书法的研发目的。在如今网络时代，键盘打字成为一种主流，文字书写越来越少，如何在网络上也能实现传统的手写，锻炼文字认知、书写能力，追求书法艺术，传承传统文化，并融入现代元素，是当前主要的研究课题。[e板会]声动书法首创仿真电子笔，让使用者在电脑上也能实现真实的毛笔、钢笔的书写，根据书写者的习惯和方式，呈现相应的书写结构、笔锋造型、文字骨架……符合现代生活习惯，又能传承文化，提升艺术修养，一举两得，全球唯一，互联网唯一！</p>
</div>
</div>
<div class="sd_fot">
<div class="ler_diz">
<div class="kejmu">
<a class="img-shadow" href="#"><img src="http://static.ebanhui.com/ebh/citytpl/sf/images/cover0628.jpg" width="100" height="100" /></a>
<p>原价1000元/年</p>
</div>
<div class="sd_diz">
<ul>
<li class="email">邮箱：<a href="mailto:<?= $room['cremail']?>"><?= $room['cremail']?></a></li>
<li class="phone">电话：<?= $room['crphone']?></li>
<li class="qq">Q&nbsp;<span style="margin-left:5px;">Q</span>：<a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?= $room['crqq']?>&amp;site=qq&amp;menu=yes"><?= $room['crqq']?></a></li>
<li class="url">网址：<a title="生动书法" href="http://sf.ebanhui.com">http://sf.ebanhui.com</a></li>
<li class="site">地址：浙江省杭州市西湖区天目山路<br /><span style=" margin-left:40px;">159号现代国际大厦B座18F</span></li>
</ul>
</div>
</div>
<div class="rig_tuandui">
<h3 class="tit_sd"><span>师资团队</span>介绍</h3>
<p>书法名师组成书法编委会，精心制作课件，从零开始授课。委员会授课老师均有深厚的书法功底和几十年的书法教育经验，充分了解各个年龄阶段受众群体的学习需求和学习特点，从基础的横、竖、撇、捺开始授课，提供系统、完整的书法课程，并在线辅导和解答学员问题，提供专一的个性化指导。同时委员会授课老师会提供逐渐梯度加深的艺术品鉴内容，提升综合艺术知识和艺术素养。</p>
</div>
</div>
</div>
<div class="jianj">
<ul id="clist">
<li><img src="http://static.ebanhui.com/ebh/citytpl/sf/images/calig_tu10628.jpg" /></li>
<li><img src="http://static.ebanhui.com/ebh/citytpl/sf/images/calig_tu20628.jpg" /></li>
<li><img src="http://static.ebanhui.com/ebh/citytpl/sf/images/calig_tu30628.jpg" /></li>
<li><img src="http://static.ebanhui.com/ebh/citytpl/sf/images/calig_tu40628.jpg" /></li>
<li><img src="http://static.ebanhui.com/ebh/citytpl/sf/images/calig_tu50628.jpg" /></li>
<li><img src="http://static.ebanhui.com/ebh/citytpl/sf/images/calig_tu60628.jpg" /></li>
<li><img src="http://static.ebanhui.com/ebh/citytpl/sf/images/calig_tu70628.jpg" /></li>
<li><img src="http://static.ebanhui.com/ebh/citytpl/sf/images/calig_tu80628.jpg" /></li>
<li><img src="http://static.ebanhui.com/ebh/citytpl/sf/images/calig_tu90628.jpg" /></li>
<li><img src="http://static.ebanhui.com/ebh/citytpl/sf/images/calig_tu100628.jpg" /></li>
<li><img src="http://static.ebanhui.com/ebh/citytpl/sf/images/calig_tu110628.jpg" /></li>
</ul>
</div>
<div class="rough" id="list1">
<ul>

<?php foreach($folderlist as $fkey=>$fval ){ ?>
	<?php if($fkey<=11){ ?>
	
	<li>
		<div class="dettu"><a target="dialog" onclick="showdialog()" class="img-shadow" href="<?= geturl('smallcourse-0-0-0-'.$fval['folderid'])?>"><img src="<?= empty($fval['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$fval['img']?>" width="114" height="159" /></a></div>
		<div class="refdet">
		<h5 style="color:#6f552c; font-size:14px; margin-top:5px;"><a href="javascript:freeplay('<?= $courselist[$fval['folderid']]['cwsource']?>','<?= $courselist[$fval['folderid']]['cwid']?>','<?= $courselist[$fval['folderid']]['title']?>',1);"><?= $courselist[$fval['folderid']]['title']?></a></h5>
		<input type="submit" class="audibtn" value="" onmouseover="this.className='audibtn1'" onmouseout="this.className='audibtn'" onclick="javascript:freeplay('$courselist[$fval[folderid]]['cwsource']','$courselist[$fval[folderid]]['cwid']','$courselist[$fval[folderid]]['title']',1);" />
		<p><?= $courselist[$fval['folderid']]['summary']?></p>
		</div>
	</li>
	<?php } ?>
<?php } ?>
</ul>
</div>

<div class="mess">
<div class="top_mess">
<ul>
<li><img src="http://static.ebanhui.com/ebh/citytpl/sf/images/mess_tu10628.jpg" />
<p>中国文化悠远流长，一言一行，一字一画，都蕴含着丰富的意义。琴棋书画中的书，就是书法。书法虽然已经脱离了生活基本需求，但是其富含的文化气息和潜在作用，为广大的人们所推崇。</p>
</li>
<li>
<p>首先，挥毫书法，可以修生养性，不急不躁，淡定自若，可以陶冶情操，抒发情感，派遣苦闷，表达心境；</p>
<p>其次，书法可以锻炼对汉字结构的把握和书写过程中的用力问题，让手腕变得灵活，提高书写能力；</p>
<p>第三，书法过程中需要手、脑、心的共同配合，可以锻炼人的综合能力；</p>
<p>第四，练习书法，也可以提高硬笔字书写能力，让日常写的字变得美观、规范、整洁；</p>
<p>第五，学习书法可以加深对中国传统文化的了解，传承文化，延绵书法技巧，提高艺术修养和文化内涵。</p>
</li>
<li>
<img src="http://static.ebanhui.com/ebh/citytpl/sf/images/mess_tu20628.jpg" />
<p>在日常生活中，一个人的字被看成是人的第二张脸，具有重要的意义。比如学习中写得好字，可以获得同学老师的赞赏；中、高考中，写出规范漂亮的好字，可以获得加分；在求职工作中，漂亮的好字更加容易获得招聘方的青睐；生活中，会写好字的人更易被人尊重……因此，快速掌握一种书法的字体方法，使得自己在短时间内发生质的变化，可以写出一手美观、规范又有个性的字体，满足学习、工作和生活的需求，是非常有必要的。</p>
</li>
<li>
<img src="http://static.ebanhui.com/ebh/citytpl/sf/images/mess_tu30628.jpg" />
<p>在网络信息化时代，如何继承中国传统书法精粹，进而发扬光大，是当前的研究重点。[e板会]声动书法，通过技术手段，把电脑的触角延伸到现实生活中，实现真实触感、压感、热感、笔感一体的真实电子毛笔，让人们可以在电脑中自由挥洒，书写一番，延续书法技能和文化韵味，提高生活和艺术质量。</p>
</li>
</ul>
</div>
<div class="fot_mess">
<ul>
<li><img src="http://static.ebanhui.com/ebh/citytpl/sf/images/mess_tu40628.jpg" />
<p>在快速发展的信息化时代，文字书写越来越少，键盘打字、打印成为一种主流。诚然，整洁美观的电脑字便于认知很阅读，但是总是缺少了一种文字的韵味和个性。</p>
</li>
<li><img src="http://static.ebanhui.com/ebh/citytpl/sf/images/mess_tu50628.jpg" />
<p>近年来，书法学习逐渐兴起，写一手好字，提个好词，成为一种流行和时尚，更是一种身份和修养的代表。某公司高层张女士，就很想能够练就一手好字，但是受到工作和生活的限制，没有太多时间去学习，去学校接受正规的训练也不太现实。</p>
</li>
<li><img src="http://static.ebanhui.com/ebh/citytpl/sf/images/mess_tu60628.jpg" />
<p>后来，有人向她介绍了[e板会]声动书法，一个专门针对现代人学习需求的书法学习平台。她发现，采用声动书法专用的手绘笔，完全和现实中的毛笔一样，可以或轻或重、或粗或喜、或正或斜……总之，自己写什么样的，就是什么样的，不像一般的键盘打字或者手写输入一样，呈现一个个呆板而整齐的电脑字。</p>
</li>
<li><img src="http://static.ebanhui.com/ebh/citytpl/sf/images/mess_tu70628.jpg" />
<p>有了这个高科技工具，张女士再在声动书法中，每天抽出十分钟来学习书法老师们的教授课程，一点点修正自己的不足，不足一年，就写出了一手好楷体。在公司年会上，她当成挥笔书写，提下“百尺高杆，更进一层”的祝福，赢得满堂喝彩。</p>
</li>
</ul>
</div>
</div>
<div class="ad0628"><img src="http://static.ebanhui.com/ebh/citytpl/sf/images/ad_fot0628.gif" /></div>
</div>
<div style="clear:both;"></div>
  <?php
    $this->display('common/player');
    $this->display('common/footer');
    ?>