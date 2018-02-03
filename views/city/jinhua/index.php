<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>金华中小学同步学堂(e板会)</title>
<meta name="keywords" content="金华,$keywords" />
<meta name="description" content="金华,$description" />
<link href="http://static.ebanhui.com/ebh/citytpl/jinhua/css/global.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" rel="stylesheet" />	
<script type="text/javascript">
<!--
	var sitecpurl ='#getsitecpurl()#';
//-->
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/piceffect.js"></script>
<!--[if lte IE 6]>  
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/DD_belatedPNG_0.0.7a.js"></script>  
<script type="text/javascript">  
  DD_belatedPNG.fix('.bottom,.cservice img,.cbuyclass,.wrap,.header-area span,userlog,.qtlol img');   
</script>  
<![endif]-->
</head>

<body>
<?php $this->display('common/public_header'); ?>
<div class="toptu"> 
  <div align="center"><img src="http://static.ebanhui.com/ebh/citytpl/jinhua/images/bg003.png" border="0" usemap="#Map" style="padding-top: 2px" />
      <map name="Map" id="Map">
        <area shape="rect" coords="6,6,113,72" href="http://www.ebanhui.com" />
        <area shape="rect" coords="373,40,435,58" href="#" />
        </map>
  </div>
</div>
<div class="user">
<div class="userlog">
<form style="float:left;" id="form1" name="form1" action="/login.html?inajax=1&login_from=classroom" onsubmit="form_submit();return false;">
<input type="hidden" name="loginsubmit" value="1" />
<label>账号：<input id="log" type="text" class="log" name="username" value="账号"  onfocus="if($('#log').val()=='账号'){$('#log').val('').css('color','#000000');}" onblur="if($('#log').val()==''){$('#log').val('账号').css('color','#666666');}"/>
  </label>
 <label> 密码：<input id="pass" type="password" class="pad" name="password" />
  </label>
  <label>
   <?php if(!empty($user)) { ?>
  <input id="xuangou" name="cookietime" type="checkbox" checked="checked" value="<?= 3600*24*14?>" />
  <?php }else{ ?>
   <input id="xuangou" name="cookietime" type="checkbox" value="<?= 3600*24*14?>" />
  <?php } ?>
  </label><label for="xuangou">下次自动登录</label>
  <label>
  <input style="cursor:pointer" type="submit" name="Submit" value="" class="dengl" />
  </label><a href="/forget.html" style="color:#0C547C;">忘记密码？</a>

  </form>

  <div class="qtlol" style="line-height: normal;margin-top: 15px;"><span style="color:#000;">用其他账号登录：</span><a href="<?=geturl('otherlogin/qq')?>"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/qqico0830.png" /></a><a href="<?=geturl('otherlogin/sina')?>"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/sianico0830.png" /></a></div>
</div>
      <a class="zhuce" href="#getsitecpurl()#?action=register" target="_blank" style="color:#0C547C;line-height: normal;margin-left: 5px;">注册e板会帐号？</a>
</div>
<div class="main">
<div class="js">
  <div align="center" style="padding-top: 10px;">
<?php 
	$crid=$room['crid'];
	$this->widget('ad_widget', $adlist, array('_id' => 'actor', '_width' => 636, '_height' => 263, 'code'=>'headfocus', 'crid'=>$crid, 'default' => '/static/citytpl/stores/images/adzhong0626.jpg'));
?>
  </div>
</div>
<div class="deve"> <div class="biao"><img src="http://static.ebanhui.com/ebh/citytpl/jinhua/images/title01.png" width="286" height="27" /></div>
  <div class="devers">
    <ul>
	<?php foreach($studylist as $value) {?>
	<li>·<?= date('Y.m.d',$value['studydataline'])?> <span><?= $value['username']?></span> <a href="javascript:void(0);"><?= ssubstrch($value['title'],0,(24-strlen($value['username'])))?></a></li>
	<?php } ?>
</ul></div>
</div>
<img src="http://static.ebanhui.com/ebh/citytpl/jinhua/images/dw_01.png" />
<div>
<div class="lieb">
<ul>
<?php foreach($itemlist as $val){ ?>
<li><img src="http://static.ebanhui.com/ebh/citytpl/jinhua/images/tu_24.png" /><a href="<?= $val['itemurl']?>" title="<?= $val['subject']?>" target="_blank"><?= ssubstrch($val['subject'],0,22)?></a></li>
<?php } ?>
</ul>
</div>
<div class="ad"><img src="http://static.ebanhui.com/ebh/citytpl/jinhua/images/gg_01.jpg" />
</div></div>
<img style="padding-top:10px;" src="http://static.ebanhui.com/ebh/citytpl/jinhua/images/title02.png" />

<div class="waik">

<div class="list-wrapper">
            <ul class="clearfix" id="freeul">
			<?php foreach($freelist as $val){ ?>
               <li>
                    <a class="img-shadow" href="javascript:freeplay('<?= $val['cwsource']?>','<?= $val['cwid']?>','<?= str_replace("'"," ",$val['title'])?>',1);"><img src="<?php getThumb($val['logo'],'194_194','http://static.ebanhui.com/ebh/tpl/default/images/default.jpg')?>" width="194" height="194" /></a>
                    <h4 style="clear:both; height:26px; line-height:32px; overflow:hidden; text-align:center; font-weight:bold;"><a  href="javascript:freeplay('<?= $val['cwsource']?>','<?= $val['cwid']?>','<?= str_replace("'"," ",$val['title'])?>',1);" title="<?= $val['title']?>"><?= shortstr($val['title'],26)?></a></h4>
                    <p style="text-indent:2em; line-height:20px;"><?= shortstr($val['summary'],88)?></p>
              </li>
            <?php } ?>
            </ul>
        </div>
</div>
<div class="gg"> <a href="$_SBLOCK[tlad][0][url]" target="_blank"><img src="$_SBLOCK[tlad][0][thumb]" title="$_SBLOCK[tlad][0][subject]" /></a></div>
<div class="zuocont">
<img src="http://static.ebanhui.com/ebh/citytpl/jinhua/images/gg_03.png" />
  <div class="smtb"><img src="http://static.ebanhui.com/ebh/citytpl/jinhua/images/title04.png" /><p>同步学堂是一个独立的学习平台，紧跟教学大纲，实现同步学堂学习，轻松捡回失神瞬间的知识，巩固学习成果，随时和老师同学交流、解惑，即使在旅游、休息、生病、外出等时候，也可以随时随地同步学习。</p></div>
<img src="http://static.ebanhui.com/ebh/citytpl/jinhua/images/gg_04.png" />
<div class="lianxi">
  <img src="http://static.ebanhui.com/ebh/citytpl/jinhua/images/title05.png" width="282" height="35" /><p><strong>金华e板会</strong> </p>
  <p>邮箱：</p>
  <p>地址：</p>
  <p>邮编：</p>
  <p>电话：</p>
  <ul>
  <li></li>
  <li></li>
  <li></li>
  </ul>
</div>
</div>
<div class="youcont" id="VSListHolder">
<img src="http://static.ebanhui.com/ebh/citytpl/jinhua/images/title03.png" />
<div class="lkuang"><img src="http://static.ebanhui.com/ebh/citytpl/jinhua/images/tu_05.png" />
<ul>
<li style="color:#0066b3">传统课堂：</li>
<li>固定在某个场所，上课时需要赶过去听课；</li>
<li style="color:#0066b3">同步学堂：</li>
<li>全球沟通，直接在家、在学校、在旅游、在路上都可学习。</li>
</ul>
</div>
<div class="lkuang"><img src="http://static.ebanhui.com/ebh/citytpl/jinhua/images/tu_06.png" width="269" height="94" />
<ul>
<li style="color:#6ba883">传统课堂：</li>
<li>每个课程由一个老师上课；</li>
<li style="color:#6ba883">同步学堂：</li>
<li>同一课程由成千上万的老师上课，其中不乏优秀的老师。</li>
</ul>
</div>
<div class="lkuang"><img src="http://static.ebanhui.com/ebh/citytpl/jinhua/images/tu_07.png" width="269" height="94" />
<ul>
<li style="color:#cb7d65">传统课堂：</li>
<li>进哪个班级，学哪个课程，都是固定的；</li>
<li style="color:#cb7d65">同步学堂：</li>
<li>任意选择喜欢的老师，喜欢的课程。</li>
</ul>
</div>
<div class="lkuang"><img src="http://static.ebanhui.com/ebh/citytpl/jinhua/images/tu_08.png" width="269" height="94" />
<ul>
<li style="color:#879f13">传统课堂：</li>
<li>综合安排学习的课程和时间；</li>
<li style="color:#879f13">同步学堂：</li>
<li>任意选择何时学什么内容，同步学习，不影响最终学习进度。</li>
</ul>
</div>
<div class="lkuang"><img src="http://static.ebanhui.com/ebh/citytpl/jinhua/images/tu_09.png" width="269" height="94" />
<ul>
<li style="color:#24a1a3">传统课堂：</li>
<li>老师上完课就走；</li>
<li style="color:#24a1a3">同步学堂：</li>
<li>动态跟进，随时提问，随时解惑,捡回失神的瞬间，巩固复习知识。</li>
</ul>
</div>
</div>
<div class="zuo"><img src="http://static.ebanhui.com/ebh/citytpl/jinhua/images/title06.png" />
<div class="xiat">> 同步学堂学习</div>
<div class="xiats">> 预习新的内容</div>
<div class="xiatas">> 参加模拟考试</div>
<div class="xiatbs">> 与同学讨论问题</div>
<div class="xiatcs">> 巩固复习知识 </div>
<div class="xiatds">> 在线做作业</div>
<div class="xiates">> 查看学习动态</div>
<div class="xiatfs">> 检查学习成果</div>
</div>
<div class="gg">
 <a href="$_SBLOCK[tlad][1][url]" target="_blank"><img src="$_SBLOCK[tlad][1][thumb]" title="$_SBLOCK[tlad][1][subject]" /></a>
</div>
</div>
<div style="clear:both;"></div>
<?php
 $this->display('common/player');
$this->display('common/footer');
?>