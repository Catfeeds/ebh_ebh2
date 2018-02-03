<?php $this->display('shop/stores/stores_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>

<div class="masses">
<div class="lefku">
<div class="leftops">
<div class="toptuku">
<div class="waiku">
<?php $logo=empty($room['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$room['cface']?>
<img width="100" height="100" src="<?= $logo?>">
</div>
<h3 class="hei20"><?= $room['crname']?></h3>
<ul class="user_atten clearfix user_atten_l" style="margin-left:18px;">
<li class="S_line2">
<a style="text-decoration:none;" href="/studyline.html">

<strong node-type="follow"><?= $roomlist['coursenum']?></strong>
课件数
</a>
</li>
<li class="S_line2">


<strong node-type="fans"><?= $roomlist['examcount']?></strong>
作业数
</li>
<li class="W_no_border">
<strong node-type="weibo"><?= $roomlist['onlinecount']?></strong>
<span>直播数</span>
</li>
</ul>
</div>
</div>
<div class="lefmain">
<img style="margin-left: 26px;margin-top:6px;" src="http://static.ebanhui.com/ebh/citytpl/stores/images/tuyonghu0311.jpg" />
<?php if(!empty($user)) { ?>
	<?php 
		$sex = empty($user['sex']) ? 'man' : 'woman';
		$type = $user['groupid'] == 5 ? 't' : 'm';
		$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$type.'_'.$sex.'.jpg';
		$face = empty($user['face']) ? $defaulturl : $user['face'];
		$facethumb = getthumb($face,'78_78');
		$url = $user['groupid'] == 5 ? geturl('troom') : geturl('myroom');
	?>
<div class="toplogo">

	<div class="tuxiang">
	<div class="tukuang">
	<img src="<?= $facethumb ?>" style="height:78px;width:78px;">
	</div>
	<div style="float:left;">
	<p style="font-weight:bold;font-size:14px;"><?= $user['username'] ?></p>
	<p>上次登录时间:</p>
	<p><?= $user['lastlogintime']?></p>
	</div>
	</div>
	<?php if($user['groupid'] == 6){ ?>
	<input class="msjinr" onmouseover="this.className='msjinr2'" onmouseout="this.className='msjinr'" type="submit" onclick="window.location.href='/myroom.html'" value="马上进入" name="Submit">
	<?php }else{ ?>
	<input class="msjinr" onmouseover="this.className='msjinr2'" onmouseout="this.className='msjinr'" type="submit" onclick="window.location.href='/troom.html'" value="马上进入" name="Submit">
	<?php } ?>
	<div class="fotlog">
	 <?php if($user['groupid'] == 6){ ?>
	<a style="color:#808080;" href="/classactive.html">开通服务</a>
	|
	<a style="color:#808080;" href="/logout.html">退出</a>
	<?php }else{ ?>
	<a style="color:#808080;" href="/logout.html">退出</a>
	<?php } ?>
	</div>
	</div>
	
<?php }else{ ?>
<form id="form1" name="form1" action="/login.html?inajax=1&login_from=classroom" onsubmit="form_submit();return false;">
		<input type="hidden" name="loginsubmit" value="1" />
<div class="toplogo">

	<div class="useer">
	<span>帐号：</span><input class="pass" id="username" name="username" type="text" value="" />
	</div>
	<div class="useer">
	<span>密码：</span><input class="pass" id="password" name="password" type="password" value=""/>
	</div>
	<div class="fuxuan">
	<?php if(!empty($user)) { ?>
	<input id="xuangou" type="checkbox" name="cookietime" value="checkbox" style="margin-top:4px;_margin-top:-2px;float:left;" value="<?= 3600*24*14?>"  checked='checked'/>
	<?php }else{ ?>
	<input id="xuangou" type="checkbox" name="cookietime" value="checkbox" style="margin-top:4px;_margin-top:-2px;float:left;" value="<?= 3600*24*14?>" />
	<?php } ?>
	<label for="xuangou" style="float:left;color:#888;">下次自动登录</label></div>
	<input class="logobtn" onmouseover="this.className='logobtn2'" onmouseout="this.className='logobtn'" type="submit" name="Submit" value="立即登录" />
	<div class="qtlol">
	<span style="color:#808080;">用其他账号登录：</span>
	<a href="<?=geturl('otherlogin/qq')?>">
	<img src="http://static.ebanhui.com/ebh/citytpl/stores/images/qqico0925.jpg" />
	</a>
	<a href="<?=geturl('otherlogin/sina')?>">
	<img src="http://static.ebanhui.com/ebh/citytpl/stores/images/sianico0925.jpg" />
	</a>
	</div>
	<div class="fotlog">
	<a href="/register.html" style="color:#808080;">用户注册</a> | <a href="/forget.html" style="color:#808080;">忘记密码？</a>
	</div>
	</div>
	</form>
<?php } ?>


<div class="ggao">
<span class="titlan" style="float:left;">公告：</span><span style="word-wrap: break-word;float:left;width:155px;" title="<?= $roominfolist['message']?>"><?= shortstr($roominfolist['message'],86)?></span>
</div>
<div class="zhongbu">
<p style="color:#0081cc;font-weight:bold;">网校信息：</p>
<p>建校时间：<?= date('Y-m-d',$room['dateline'])?></p>
</div>
<div class="miaoshu">
<ul>
<li>

<p style="margin-bottom:5px;margin-top:8px;">课程与描述相符：</p>
<p class="pingfs">
<a style="cursor:pointer;" href="<?= geturl('cloudscore')?>">
<span class="barbg">
<span class="votebar" style="width:<?= round($roomlist['good'])?>0%;"></span>
</span>
</a>
</p>
<span class="fenshu"><?= round($roomlist['good'])?>分</span>
</li>
<li>
<p style="margin-bottom:5px;margin-top:8px;">课程的内容质量：</p>
<p class="pingfs">
<a style="cursor:pointer;" href="<?= geturl('cloudscore')?>">
<span class="barbg">
<span class="votebar" style="width:<?= round($roomlist['bad'])?>0%;"></span>
</span>
</a>
</p>
<span class="fenshu"><?= round($roomlist['bad'])?>分</span>
</li>
<li style="border:none;">
<p style="margin-bottom:5px;margin-top:8px;">老师的授课态度：</p>
<p class="pingfs">
<a style="cursor:pointer;" href="<?= geturl('cloudscore')?>">
<span class="barbg">
<span class="votebar" style="width:<?= round($roomlist['useful'])?>0%;"></span>
</span>
</a>
</p>
<span class="fenshu"><?= round($roomlist['useful'])?>分</span>
</li>
</ul>
</div>
</div>
<div class="lefdibg"></div>
</div>
<div class="rigku">
<div class="adplimg">

<?php 
	$crid=$room['crid'];
	$this->widget('ad_widget', $adlist, array('_id' => 'actor', '_width' => 515, '_height' => 180, 'code'=>'headfocus', 'crid'=>$crid, 'default' => 'http://static.ebanhui.com/ebh/citytpl/stores/images/ad130225.jpg'));
?>
</div>
<?php if($roomlist['isschool']==4){ ?>
		<?php if(empty($user)){
			$cloudaddurl="/sitecp.php?action=classrbalance";
		}else{ 
			if($user['groupid']==6){
				$cloudaddurl="/sitecp.php?action=classrbalance";
			}else{
				$cloudaddurl="javascript:alert('对不起，您是教师账号，不可以进行在线购买。');";
			}
		}
		?>
		<a class="goum" href="<?= $cloudaddurl?>"></a>
<?php }else{ ?>  
	<?php if(empty($user)){
			$cloudaddurl=geturl('classactive');
	  }else{
			if($user['groupid']==6){
				$cloudaddurl=geturl('classactive');
			}else{
				$cloudaddurl="javascript:alert('对不起，您是教师账号，不可以进行在线购买。');";
			 }	
	  } ?>
	 <?php if(!empty($user)){?>
	    <a class="goums" href="<?= $cloudaddurl?>"></a>
	  <?php }else{ ?>
		<a class="goums" name='<?= $cloudaddurl?>' href="javascript:;"></a>
	  <?php } ?>
<?php } ?>

<?php
	if($room['upid'] == '10427')
		$freeurl = 'http://ty.my.ebanhui.com/studyline.html';
	else
		$freeurl = geturl('freed');
?>
  <a class="shits" href="<?= $freeurl?>"></a>
<p class="jjie"><span class="titlan">简介：</span><?= shortstr($roomlist['summary'],340)?></p>


<div class="dagang" id="list1">
<div class="titgang">
  <img style="float:left;" src="http://static.ebanhui.com/ebh/citytpl/stores/images/dagang0225.jpg" width="87" height="33" /> 
 
  <a href="<?= geturl('studyline')?>" class="gengd"><img src="http://static.ebanhui.com/ebh/citytpl/stores/images/gengduo0225.jpg" width="44" height="15" /></a>
  </div>
  <?php if(!empty($folderlist)){?>  
<ul>
	<?php foreach($folderlist as $fkey=>$fval){ ?>
		<?php if($fkey == 2 || $fkey == 5){ ?>
		<li style="margin-right: 0px;">
		<?php }else{ ?>
		<li>
		<?php } ?>
		<div class="enidet" onmouseover="this.className='enidets'" onmouseout="this.className='enidet'">
		<div class="dettu">
		<h3>
		<a href="<?= geturl('studyline/'.$fval['folderid'])?>" title="<?= $fval['foldername']?>"><?= shortstr($fval['foldername'],16,'')?></a>
		</h3>
		<a class="img-shadow" href="<?= geturl('studyline/'.$fval['folderid'])?>"><img src="<?= empty($fval['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$fval['img']?>" width="114" height="159" /></a>
		</div>
		<div class="refdet">
		<p style="line-height:1.9; text-indent:25px;word-wrap: break-word;"><?= shortstr($fval['summary'],68)?></p>
		</div>
		</div>
		</li>
	<?php } ?>
</ul>

<?php }else{ ?>
  <div style="font-size: 16px;margin-left: 11px;margin-top: 10px;"> 暂 无 导 航 </div>
<?php } ?>
</div>
</div>
<div class="fotsi">
<ul>
<li><img style="margin-top:20px;" src="http://static.ebanhui.com/ebh/citytpl/stores/images/fotstu10318.jpg" />
<div class="waikes">
<h2 class="steres">学生</h2>
<p><a href="http://www.ebanhui.com/help/1359.html">如何注册账号？</a></p>
<p><a href="http://www.ebanhui.com/help/1385.html">如何搜索网校？</a></p>
<p><a href="http://www.ebanhui.com/help/1438.html">怎样挑选课程和科目？</a></p>
<p><a href="http://www.ebanhui.com/help/1384.html">购买年卡的几种方式？</a></p>
<p><a href="http://www.ebanhui.com/help/1377.html">如何提交作业？</a></p>
</div>
</li>
<li class="ftrigx"><img style="margin-top:20px;" src="http://static.ebanhui.com/ebh/citytpl/stores/images/fotstu20318.jpg" />
<div class="waikes">
<h2 class="steres">老师</h2>
<p><a href="http://www.ebanhui.com/help/1369.html">如何开通网校？</a></p>
<p><a href="http://www.ebanhui.com/help/1370.html">如何上传和管理课件？</a></p>
<p><a href="http://www.ebanhui.com/help/1372.html">如何管理学生？</a></p>
<p><a href="http://www.ebanhui.com/help/1374.html">如何上传和批改作业？</a></p>
<p><a href="http://www.ebanhui.com/help/1437.html">怎样导入其他格式的文件？</a></p>
</div>
</li>
<li><img src="http://static.ebanhui.com/ebh/citytpl/stores/images/fotstu30318.jpg" />
<div class="waikes">
<h2 class="steres">网校</h2>
<p><a href="http://www.ebanhui.com/help/1426.html">什么是云教育网校？</a></p>
<p><a href="http://www.ebanhui.com/help/1440.html">网校创建需要什么条件？</a></p>
<p><a href="http://www.ebanhui.com/help/1434.html">什么是子平台？</a></p>
<p><a href="http://www.ebanhui.com/help/1380.html">如何使用播放器？</a></p>
<p><a href="http://www.ebanhui.com/help/1381.html">如何使用课件制作软件？</a></p>
</div>
</li>
</ul>
</div>
</div>
<div style="clear:both;"></div>
<div style="position: relative;text-align: center;">
<script type="text/javascript">
<!--
	$(".goums").click(function(){
		if ($(this).attr("name") != '') {
			$.loginDialog($(this).attr("name"));
		}
	});
//-->
</script>
<?php
	$this->display('common/footer');
?>