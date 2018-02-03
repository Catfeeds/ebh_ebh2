<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $room['crname']?></title>
<meta name="keywords" content="<?=empty($systemsetting['metakeywords'])?'':$systemsetting['metakeywords']?>" />
<meta name="description" content="<?=empty($systemsetting['metadescription'])?'':$systemsetting['metadescription']?>" />
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/ebhseven.css" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/joinlc.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" rel="stylesheet" />	
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
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/dialog.js"></script>
<!--[if lte IE 6]>  
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/DD_belatedPNG_0.0.7a.js"></script>  
<script type="text/javascript">  
  DD_belatedPNG.fix('.head-logo,.head-logo a ,.current-city,.cservice img,.cbuyclass,.head-logo-text,.primg,.header-area span,.bottom,.qtlol img');   
</script>  
<![endif]-->
</head>

<?php $this->display('common/public_header'); ?>
<div class="long">
<div style="width:960px; margin:0 auto; position:relative;">
<a class="alogo" href="http://www.ebanhui.com/"></a>
<p class="top_tit"><?= $room['crname']?></p>
</div>
</div>
<div class="main">

<?php 
if(empty($user)){ 
		$cloudaddurl="/classactive.html";
}else{
	if($user['groupid'] == 6){
		$cloudaddurl="/classactive.html";
	}else{
		$cloudaddurl="javascript:alert('您是云教育网校的教师，不可以加入');";
	}	
}
?>
<div class="leftop">
<div class="topad">
<!--图片-->
<?php
	$this->widget('ad_widget', $adlist, array('_id' => 'actor', '_width' => 626, '_height' => 180));
?>
</div>
<div class="titjiaoyu"  id="shan">

<ul id="mainimg">
<li  class="bofang">
<a href="/down.html" style="text-decoration: none;cursor: pointer;" target="_blank" >
<p>最新功能，全力支持e板会格式文件，学习前请先下载播放器！</p>
</a>
</li>
<li  class="kehu">
<a href="http://soft.ebanhui.com/ebhclient.zip" style="text-decoration: none;cursor: pointer;" target="_blank">
<p>绿色插件，便捷登录，输入账号密码即可登录学习。</p>
</a>
</li>
<li class="shenqing">
<a href="<?= $cloudaddurl?>" style="text-decoration: none;cursor: pointer;" >
<p>全球唯一，互联网首创，快速加入，获得最优质的学习服务！</p>
</a>
</li>
<li class="art">
<?php if(!empty($room['crqq'])){ ?>
<a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?= $room['crqq']?>&amp;site=qq&amp;menu=yes" style="text-decoration: none;cursor: pointer;" target="_blank">
<p>全天候技术和服务支持，全力支持用户体验和学习。</p>
</a>
<?php }else{ ?>
<a href="http://wpa.qq.com/msgrd?v=3&amp;uin=985400915&amp;site=qq&amp;menu=yes" style="text-decoration: none;cursor: pointer;" target="_blank">
<p>全天候技术和服务支持，全力支持用户体验和学习。</p>
</a>
<?php } ?>
</li>
</ul>
</div>
</div>
<?php if(!empty($user)){ ?>
	<?php 
			$sex = empty($user['sex']) ? 'man' : 'woman';
            $type = $user['groupid'] == 5 ? 't' : 'm';
            $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$type.'_'.$sex.'.jpg';
            $face = empty($user['face']) ? $defaulturl : $user['face'];
            $facethumb = getthumb($face,'78_78');
            $url = $user['groupid'] == 5 ? geturl('troom') : geturl('myroom');
		?>

	<div class="rigtop">
	<div class="dettu" id="list1">
	<ul>
		<li>
		<?php $logo=empty($room['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$room['cface']?>
	<a class="img-shadow" href="#">
	<img src="<?= $logo?>" width="100" height="100" /></a>
		</li>
	</ul>
	</div>
	<div class="usouter">
		<div class="figlef">
		<img src="<?= $facethumb?>" width="78" height="78" />
		</div>
		<div class="showrig">
		<h2 style="font-weight:bold; font-size:14px; color:#fff;"><?= $user['username']?></h2>
		<p>上次登录时间：</p>
		<p><?= $user['lastlogintime']?></p>
		<?php if($user['groupid'] == 6){ ?>
		<p><a href="/classactive.html" style="color:#f27245;">开通服务</a><em style="margin-left:5px; margin-right:5px; color:#ccc;">|</em><a href="/logout.html">退出</a></p>
		<?php }else{ ?>
		<p><a href="/logout.html">退出</a></p>
		<?php } ?>
		</div>
		</div>	
		<?php if($user['groupid'] == 6){ ?>
		     <input type="submit" class="loginiu" value="" onclick="window.location.href='<?= geturl('myroom')?>'"/>
		<?php }else{ ?>
			<input type="submit" class="loginiu" value="" onclick="window.location.href='<?= geturl('troom')?>'"/>
		<?php } ?>
		</div>
	
	
<?php }else{ ?>	
	<div class="rigtop">
	<div class="dettu" id="list1">
	<ul>
		<li>
		<?php $logo=empty($room['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$room['cface']?>
	<a class="img-shadow" href="#">
	<img src="<?= $logo?>" width="100" height="100" /></a>
		</li>
	</ul>
	</div>
 <div class="qtlol"><span style="float:left;">用其他账号登录：</span><a href="<?=geturl('otherlogin/qq')?>"  id="qq_login_btn">
<img src="http://static.ebanhui.com/ebh/tpl/2012/images/qqico0830.jpg" /></a><a href="<?=geturl('otherlogin/sina')?>"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/sianico0830.jpg" /></a></div>  	
<div class="users" style="margin-top:160px;">
<form id="form1" name="form1" action="<?= geturl('login')?>" onsubmit="form_submit();return false;">
<input type="hidden" name="loginsubmit" value="1" />
	
	<img src="http://static.ebanhui.com/ebh/tpl/2012/images/user0807.jpg" />
	<input class="acc" id="username" name="username" type="text" value="" />
	</div>
	<div class="users">
	<img src="http://static.ebanhui.com/ebh/tpl/2012/images/code0807.jpg" width="55" height="26" />
	<input class="acc" id="password" name="password" type="password" value="" />
	</div>
	<input type="submit" class="logbtn" name="Submit" value="" />
	<?php if(!empty($user)) { ?>
	<input id="xuangou" type="checkbox" class="kuang" name="checkbox" checked='checked' value="<?= 3600*24*14?>" /><label for="xuangou">自动登录</label>
	<?php }else{ ?>
	<input id="xuangou" type="checkbox" class="kuang" name="checkbox" value="<?= 3600*24*14?>" /><label for="xuangou">自动登录</label>
	<?php } ?>
	<p><a href="<?= geturl('forget')?>" style="color:#FFFFFF; margin-left:25px;">忘记密码</a></p>
	<?php if(!empty($user)){ ?>
		<?php $reurl = "javascript:tologinn('".'/login.html?returnurl=__url__'."');"?>    
	<p class="logmun">还没有e板会帐号？<a href="$reurl" style="color:#08859c;">免费注册>></a></p>
	<?php }else{ ?>
	<p class="logmun">还没有e板会帐号？<a href="<?= geturl('register')?>" style="color:#08859c;">免费注册>></a></p>
	<?php } ?>
</form>
</div>
<?php } ?>
	
<?php $tplsetting=unserialize($room['tplsetting'])?>
<?php if(!empty($room['summary']) && (empty($tplsetting) || $tplsetting['s'])){?>
<div class="jianju"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/topjianju0830.jpg" /></div>
<div class="intro">
<h2 class="titoulin">平台简介</h2>
<p> <?= $room['summary']?></p>
<?php } ?>
<?php if(!empty($room['message'])){?>
<div class="jianju"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/topjianju0830.jpg" /></div>
<div class="intro">
<h2 class="titoulin">平台详细介绍</h2>
<p class="xianqq"> <?= $room['message']?></p>
</div>
<?php } ?>
<?php if(!empty($folderlist)){ ?>
<div class="jianju"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/jianjuhui0830.jpg" /></div>
<div class="outline" id="list2">
<h2 class="titoulin">学习大纲</h2>
<ul id="list1">
 <?php foreach($folderlist as $fval){ ?>
<li>
<div class="enidet">
<div class="dettu">
<h3><a onclick="showdialog()" target="dialog" href="<?= geturl('smallcourse-0-0-0-'.$fval['folderid'])?>"><?= shortstr($fval['foldername'],14)?></a></h3>
<a onclick="showdialog()" target="dialog" href="<?= geturl('smallcourse-0-0-0-'.$fval['folderid'])?>" class="img-shadow">
<img width="114" height="159" src="<?= empty($fval['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$fval['img']?>" />
</a>
</div>
<div class="refdet">
<h5 style="color:#0065ac; font-size:14px; margin-top:5px; margin-bottom:20px;"><a onclick="showdialog()" target="dialog" href="<?= geturl('smallcourse-0-0-0-'.$fval['folderid'])?>">课程介绍：</a></h5>
<p><a href="<?= geturl('smallcourse-0-0-0-'.$fval['folderid'])?>" target="dialog" onclick="showdialog()"><?= shortstr($fval['summary'],138)?></a></p>
</div>
</div>
</li>
<?php } ?>
</ul>
</div>
<?php } ?>
<?php if(empty($tplsetting) || $tplsetting['f']){ ?>

<?php if(!empty($classroomlist)){ ?>
<div class="jianju"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/jianjuhui0830.jpg" /></div>
<div class="adtion">
<h2 class="titoulin">免费试听</h2>
<ul>
<?php foreach($classroomlist as $val){ ?>
<li class="qianp"><a href="javascript:freeplay('<?= $val['cwsource']?>','<?= $val['cwid']?>','<?= str_replace("'"," ",$val['title'])?>',1);" title="<?= $val['title']?>"><?= shortstr($val['title'],26)?></a></li>
<?php } ?>
</ul>
</div>
<?php } ?>
<?php } ?>
<?php if(empty($tplsetting) || $tplsetting['c']){?>
<div class="jianju"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/jianjuhui0830.jpg" /></div>
<div class="folo">
<div class="lefdiv">
<p style="width:280px; padding-left:40px;"><span>地址：</span><?= ssubstrch($room['craddress'],0,26)?></p>
<p style="width:183px;"><span>电话：</span></span><?= $room['crphone']?></p>
<?php $url='http://'.$room['domain'].'.ebanhui.com'?>
<p><span>网址：</span><a href="<?= $url?>"><?= $url?></a></p>
<p style="margin-top: 5px; padding-left: 80px; width: 240px;"><?= ssubstrch($room['craddress'],13,23)?></p>
<?php if(!empty($room['crqq'])){?>
<p style="margin-top: 5px; width: 183px;"><span>Q  Q ：</span><a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?= $room['crqq']?>&amp;site=qq&amp;menu=yes" target="_blank"><?= $room['crqq']?></a></p>
<?php }else{ ?>
<p style="margin-top: 5px; width: 205px;"><span>Q  Q ：</span><a href="http://wpa.qq.com/msgrd?v=3&amp;uin=985400915&amp;site=qq&amp;menu=yes" target="_blank">985400915</a></p>
<?php } ?>
<p style="margin-top:5px; width:212px;"><span>邮箱：</span><a href="mailto:<?= $room['cremail']?>"><?= $room['cremail']?></a></p>
</div>
<div class="rigdiv"><span><?= round($room['crprice'])?></span></div>
</div>
<?php } ?>
</div>

<!-- 申请加入教室 -->
<div id="join2" name="join2" style="display:none;overflow:hidden;">
<div class="classconfirm" id="joinform2">
	<form action="" method="post" id="sform2" name="sform2" onsubmit="return checkform('rname','mobile','email')">
		<input type="hidden" id="crid2" name="crid" />
    	<input type="hidden" id="teacherid2" name="teacherid" />
			<div class="joinlc">
				<p class="tit_cue">请填写您真实的和人信息，带*号的内容必须填写。</p>
				<ul>
				
				<li class="current fifx">
				<span>*</span><em>姓&nbsp;名：</em>
				<input type="text" class="txt_box" name="rname" maxlength="25"  id="rname2" onblur="checkrname2(this.value)" value="" />
				<span id="rnamemsg2"></span></li>
				
				<li class="current fify">
				<span>*</span><em>邮&nbsp;箱：</em>
				<input type="text" class="txt_box" name="email" maxlength="60"  id="email2" onblur="checkemail2(this.value)" value=""  />
				<span id="emailmsg2"></span></li>
				<li class="current fifz">
				<span></span><em class="em2">手&nbsp;机：</em>
				<input type="text" class="txt_box" name="mobile" maxlength="11" onblur="checkmobile2(this.value)"  id="mobile2" value=""/>
				<span id="mobilemsg2"></span>
				</li>
				
				<li class="current fifc">
				<span></span><em class="em2">Q&nbsp;&nbsp;&nbsp;Q：</em>
				<input type="text" class="txt_box" name="qq" id="qq2" maxlength="15"  value=""/>
				</li>
				
				<li class="currs fifa">
				<span style=""></span><em style="margin-left: 35px;_margin-left:24px;_margin-right:3px;font-size: 14px;">留&nbsp;言：</em>
				<textarea id="remarks2" name="remarks" class="txt_duobox"></textarea>
				</li>
				</ul>
				<p class="sadew">
				  <input id="sendbtn2" type="button" class="operate" name="Submit" value="确&nbsp;&nbsp;认" />
				  <input type="button" name="Submit2" class="cancer" onclick="$('#join2').dialog('close');" value="取&nbsp;&nbsp;消" />
				</p>
			</div>
			
	
		
	</form>
</div>
	<div id="joinmessage2" style="display:none;align:center;" >
    </div>
</div>

<script type="text/javascript">

$(function(){
var buttons = {};
	$("#join2").dialog({
		autoOpen: false,
		resizable:false,
		title:"申请加入教室",
		buttons:buttons,
		width: 520,
		height:430,
		modal: true,
		open:function(){
			$('#remarks2').val('');
		},
		beforeclose:function(){
			$( "#join2" ).dialog( "option", "buttons",buttons);
			$("#joinform2").css('display','block');
			$("#joinmessage2").css('display','none');
		}
		});
		$("#sendbtn2").click(function(){
			if(checkform2('rname','mobile','email')){
				var crid = $_SGLOBAL['room']['crid'];
				var rname = $("#rname2").val();
				var mobile = $("#mobile2").val();
				var email = $("#email2").val();
				var qq = $("#qq2").val();
				var teacherid = $_SGLOBAL['room']['uid'];
				var remarks = $("#remarks2").val();

				$("#joinmessage2").html("正在发送请求");
				$("#joinform2").hide();
				$("#joinmessage2").show();
				$.ajax({
					url:"#getsitecpurl()#?action=member",
					type:'post',
					data:{'crid':crid,'rname':rname,'mobile':mobile,'email':email,'teacherid':teacherid,'qq':qq,'remarks':remarks,'op':'application','inajax':1},
					dataType:'text',
					success:function(msgs){
						if(msgs!=''){
//							$("#join").dialog("close");
//							$("#dialogmsg").dialog('open');

							$("#joinmessage2").html('<div style=" width:74px; height:62px; float:left; display:inline; margin-top:100px; margin-left:70px;"><img src="http://static.ebanhui.com/ebh/tpl/default/images/access_bg.png" width="74" height="62" /></div><div style=" width:305px; float:left; display:inline; margin-top:100px; margin-left:10px;"><b style="font-size:14px;">'+msgs+'</b><p>3秒关闭</p><div class="skip"><a style="cursor:pointer;" onclick="javascript:$(\'#join2\').dialog(\'close\');">立即关闭。</a></div></div>');
							buttons = $( "#join2" ).dialog( "option", "buttons" );
							//$("#dialogmsg").html('<span style="color:red">'+msg+'</span>');
							$( "#join2" ).dialog( "option", "buttons", [    ]);
							$("#op"+$("#join2").data('crid')+"2").html('<input type="button" name="button" class="yisq" value="" />');
							setTimeout(function(){$("#join2").dialog('close')},3000);
						}
					}
				})
			}
		});
	
	});



var showdialog2 = function(){
	$("#join2").dialog('option','title',"申请加入");
	$("#join2").dialog('open');
}
function checkrname2(rname){
	if(rname ==""){
		$("#rnamemsg2").html('<img class="cue" src="http://static.ebanhui.com/ebh/tpl/2012/images/error.png" />');
		return false;
	}
	$("#rnamemsg2").html('<img class="cue" src="http://static.ebanhui.com/ebh/tpl/2012/images/righttip.png" />');
	return true;
	
}
function checkmobile2(mobile){
if(mobile!=''){
	var ab = /^(1[3-9]{1}[0-9]{9})$/;
	if(!ab.test(mobile)){
		$("#mobilemsg2").html('<img class="cue" src="http://static.ebanhui.com/ebh/tpl/2012/images/error.png" />');
		return false;
	}	
	$("#mobilemsg2").html('<img class="cue" src="http://static.ebanhui.com/ebh/tpl/2012/images/righttip.png" />');	
}
return true;
}
function checkemail2(email){
if(email == ""){
	$("#emailmsg2").html('<img class="cue" src="http://static.ebanhui.com/ebh/tpl/2012/images/error.png" />');
	return false;
}else{
	var emailreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	if(!emailreg.test(email)){
		$("#emailmsg2").html('<img class="cue" src="http://static.ebanhui.com/ebh/tpl/2012/images/error.png" />');
		return false;
	}
}
$("#emailmsg2").html('<img class="cue" src="http://static.ebanhui.com/ebh/tpl/2012/images/righttip.png" />');
return true;
}

function checkform2(rname,mobile,email){
var rname = $("#"+rname+"2").val();
var email = $("#"+email+"2").val();
if(checkrname2(rname)!=true||checkemail2(email)!=true){
	return false;
}
return true;
}
var tologinn = function(url){
	url = url.replace('__url__',encodeURIComponent(location.href));
	location.href=url;
	}

</script>
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
<div style="clear:both;"></div>
<?php
	$this->display('common/player');
	$this->display('common/footer');
?>
