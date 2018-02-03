<?php $menuactiveid=3 ?>
<?php $sortmode = $this->uri->uri_sortmode();?>
<?php
$this->display('common/header');
?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
<script type="text/javascript">
$(function() {
	$('.newku a').lightBox();
	$('.spdiv a').lightBox();
//	$('.imagea').lightBox();
});
</script>
<!--[if lte IE 6]>  
<script type="text/javascript" src="/static/js/DD_belatedPNG_0.0.7a.js"></script>  
<script type="text/javascript">  
  DD_belatedPNG.fix('.wrap,.bottom,.cservice img,.cbuyclass,.log,.qtlol img');   
</script>
<![endif]-->
<link href="http://static.ebanhui.com/ebh/tpl/2014/css/seek.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/2014/css/fanart.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<div class="toptitnew"><a href="/">首页</a> > 原创空间</div>
<div class="main" style="margin-top:10px;">
<div class="put">
  <input type="submit" name="Submit" onclick="javascript:openplay()" class="putbtn" value="" />
</div>
<div class="present">
<p>原创空间，是基于“e板会”云计算中心，应用无线网络、矢量微媒体、手写感应、交互应用等技术和手段，云集一个个独立的用户创作空间，形成的一个开放共享的创作平台。
<br />&nbsp;&nbsp;&nbsp;&nbsp;所有用户可以通过“e板会”专用软件将自己的笔记、习题、书写作品、涂鸦形象等原创的内容发布上来，分享给大家，留下成长的痕迹，记录每一次的进步！<a href="http://sfds.ebanhui.com" title="书法大师" target="_blank"><span style="color:#ff8013;">（通过原创空间，你可以更好使用e板会书法大师，发掘书法大师的更多强大的功能，点击这里了解）</span>
</a></p>
</div>
<div class="login">
<?php
if(!empty($user)) {
		$sex = empty($user['sex']) ? 'man' : 'woman';
		$type = $user['groupid'] == 5 ? 't' : 'm';
		$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$type.'_'.$sex.'.jpg';
		$face = empty($user['face']) ? $defaulturl : $user['face'];
		$facethumb = getthumb($face,'78_78');
?>    
	<div class="usouter">
		<div class="figlef">
		<img src="<?= $facethumb ?>" width="78" height="78" /></div>
		<div class="showrig">
		<h2 style="font-weight:bold; font-size:14px; color:#3195c6;"><?= $user['username']?></h2>
		<p>上次登录时间：</p>
		<p><?= $user['lastlogintime']?></p>
		</div>
	</div>
	<?php if($user['groupid'] == 6){ ?>
	<input type="submit" class="logbtn2" value="" onclick="window.location.href='<?= geturl('member/space')?>'"/>
	<?php } else { ?>
	<input type="submit" class="logbtn2" value="" onclick="window.location.href='<?= geturl('teacher/choose')?>'"/>
	<?php } ?>
	<div class="jky">
		<p>
		<?php if($user['groupid'] == 6){ ?>
		<a href="<?= geturl('member')?>">个人中心</a>
		<?php } else { ?>
		<a href="<?= geturl('teacher/choose')?>">个人中心</a>
		<?php } ?>
		<em style="margin-left:5px; margin-right:5px; color:#ccc;">|</em><a href="<?=geturl('logout')?>">退出</a></p>
	</div>
<?php }else{ ?>
	<form method="post" action="/login.html?inajax=1&login_from=classroom" id="form1">
	<div class="qtlol" style="width:213px;margin-top:42px;"><span style="color:#000;">用其他账号登录：</span><a href="<?=geturl('otherlogin/qq')?>"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/qqico0830.png" /></a><a href="<?=geturl('otherlogin/sina')?>"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/sianico0830.png" /></a></div>
	  	<div class="vbf" style="margin-top:3px;">
			<input type="text" id="username" name="username" class="usk" value="帐号" onfocus="if($(this).val()=='帐号'){$(this).val('').css('color','#000000');}" onblur="if($(this).val()==''){$(this).val('帐号').css('color','#666666');}"/>
		</div>
		<div class="vbf" >
			<input type="text" id="show" class="usk" value="密码" onfocus="$(this).hide();$('#password').show().focus();$('#password').show().css('color','#000000');" />
			<input type="password" id="password" style="display:none" name="password" class="usk" onblur="if($(this).val()==''){$(this).hide();$('#show').show().css('color','#666666');}" />
		</div>
		<div style="float:left;width:240px;height:26px;;">
		<div id="lo">
			<input id="xuangou" name="cookietime" class="check" type="checkbox" style="vertical-align:middle;" value="1" />
		</div>
	  	<div class="zz">
			<label for="xuangou">下次自动登录</label> <span style="color:#CCC">|</span> <a href="<?= geturl('forget') ?>" target="_blank">忘记密码</a>
		</div>
</div>
		<div class="btnkuang">
		<input id="loginsubmit" type="button" class="logbtn" value="" />
		<input type="hidden" id="loginsubmit" name="loginsubmit" value="1" />
		</div>
	    <div class="jky">
	    	<p>还没有e板会帐号？<a href="<?= geturl('register')?>" target="_blank">立即注册>></a></p>
	    </div>
 	</form>
 <?php } ?>
</div>
<div class="soupai">
<ul>
<li <?php if($sortmode==0){echo 'class=xuanz';}?> ><a href="/spacelist-1-0-spacedateline.html">默认推荐</a></li>
<li <?php if($sortmode==1){echo 'class=xuanz';}?> ><a href="/spacelist-1-1-space.html">最新原创</a></li>
<li <?php if($sortmode==2){echo 'class=xuanz';}?> ><a href="/spacelist-1-2-hot.html">热门原创</a></li>
</ul>
<input name="spacevalue" id="spacevalue" type="text" class="seek" value="请输入您要搜索的作品或作者名称" onfocus="if($(this).val()=='请输入您要搜索的作品或作者名称'){$(this).val('').css('color','#666666');}" onblur="if($(this).val()==''){$(this).val('请输入您要搜索的作品或作者名称').css('color','#666666');}" />
  	<input class="seekbtn" type="submit" name="searchname" onclick="searchspace('space')" id="searchname" value="" />
 	<a href="<?= geturl('spacelist-0-0-space')?>"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/morebtn0620.jpg" /></a>
</div>
<div class="newyuan">

  <h3 class="titnew">
  	最新上传
  	
  </h3>
  <ul class="ap">

		<?php foreach($uploadslist as $sk=>$sv){ 
			if($sk==4 || $sk==9 || $sk==14 || $sk==19 || $sk==24|| $sk==29|| $sk==34|| $sk==39){
				$style = "style='border-right: none;'";
			}
		?>
		  <li class="newzuo <?=$sk==4||$sk==9||$sk==14||$sk==19||$sk==24||$sk==29||$sk==34||$sk==39?'bordnon':'' ?>">
		  <?php $svtitle=ssubstrch($sv['title'],0,20) ?>
			<ul class="align_box"> 
				<li class="newku" onmouseover="this.style.border='2px solid #66CAE9'" onmouseout="this.style.border='1px solid #CDCDCD'" > 
					<a href="<?= $showpath.$sv['image']?>" title="<?= $sv['title']?>">
						<img class="show_img" src="<?= getThumb($showpath.$sv['image'],'126_126')?>" />
						<img class="alpha_img" src="http://static.ebanhui.com/ebh/tpl/2012/images/pixel.gif"/> 
					</a>
				</li> 
		  	</ul>
			 <h2 class="pusnam"><a href="<?= geturl('space/'.$sv['id'])?>" title="<?= $sv['title']?>" class="imagea"><?= empty($svtitle)?'未命名':$svtitle ?></a></h2>
		  </li>
	  <?php } ?>
  </ul>
	<div class="page">
		<a class="current">1</a>
		<a href='/spacelist-2-0-space.html'>2</a>
		<a href='/spacelist-3-0-space.html'>3</a>
		<a href='/spacelist-4-0-space.html'>4</a>
		<a href='/spacelist-5-0-space.html'>5</a>
		<a href='/spacelist-6-0-space.html'>6</a>
		<a href='/spacelist-7-0-space.html'>7</a>
		<a href='/spacelist-8-0-space.html'>8</a>
		<a href='/spacelist-9-0-space.html'>9</a>
		<a href='/spacelist-2-0-space.html'>下一页</a>
		<a href='/spacelist-9-0-space.html'>尾页</a>
</div>
</div>


<div class="ycarts">
<h3 class="titnew">原创排行榜</h3>
		<div class="artslist">
			<ul>
				<?php foreach($memberlist as $snv){ 
					if($snv['sex']==1){
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
					}else{
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
					}
					$face = empty($snv['face']) ? $defaulturl : $snv['face'];
					$face = getthumb($face,'78_78');
				?>
						<li>
							<div class="houart" onmouseover="this.style.border='2px solid #66CAE9'" onmouseout="this.style.border='1px solid #CDCDCD'"><a href="/spacelist.html?key=<?= $snv['username']?>" title="查看该作者所有作品"><img src="<?= $face?>" width="78" height="78"/></a></div>
							<h2><a href="/spacelist.html?key=<?= $snv['username']?>" title="<?= $snv['username']?>"><?= $snv['username']?></a></h2>
							<h2 style="color:#999;"><a href="/spacelist.html?key=<?= $snv['username']?>" title="<?= $snv['realname']?>"><?= ssubstrch($snv['realname'],0,12) ?></a></h2>
						</li>
				<?php } ?>
			</ul>
	</div>
</div>

<div class="commen">
<h3 class="titnew">热点原创</h3>
	<ul class="align_box"> 
		<?php foreach($hotlist as $hotv){ ?>
			<li> 
				<div class="spdiv" onmouseover="this.style.border='2px solid #66CAE9'" onmouseout="this.style.border='1px solid #CDCDCD'">
				<a href="<?= $showpath.$hotv['image']?>" title="<?= $hotv['title']?>">
					<img class="show_img" src="<?= getThumb($showpath.$hotv['image'],'126_126')?>" /> 
					<img class="alpha_img" src="http://static.ebanhui.com/ebh/tpl/2012/images/pixel.gif"/> 
				</a>
				</div><?php $hotvtitle=ssubstrch($hotv['title'],0,20)?>
				<h3 class="sizes"><a href="<?= geturl('space/'.$hotv['id'])?>" title="<?= $hotv['title']?>" class="imagea"><?= empty($hotvtitle)?'未命名':$hotvtitle?></a></h3>
			</li> 
		<?php } ?>
	</ul>

</div>

<div class="choose">
	<h3 class="titnew">热点原创</h3>
		<ul class="align_box"> 
			<?php foreach($bestlist as $bestv){ ?>
				<li> 
					<div class="spdiv" onmouseover="this.style.border='2px solid #66CAE9'" onmouseout="this.style.border='1px solid #CDCDCD'">
						<a href="<?= $showpath.$bestv['image']?>" title="<?= $bestv['title']?>">
							<img class="show_img" src="<?= getThumb($showpath.$bestv['image'],'126_126')?>" /> 
							<img class="alpha_img" src="http://static.ebanhui.com/ebh/tpl/2012/images/pixel.gif"/> 
						</a>
					</div><?php $bestvtitle=ssubstrch($bestv['title'],0,20)?>
					<h3 class="sizes"><a href="<?= geturl('space/'.$bestv['id'])?>" title="<?= $bestv['title']?>" class="imagea"><?= empty($bestvtitle)?'未命名':$bestvtitle?></a></h3>
				</li> 
			<?php } ?>
		</ul>
</div>
</div>
<script type="text/javascript">
$(function(){
	$("#loginsubmit").click(function(){
		if($('#username').val() == ''||$('#username').val()=="帐号"){
			alert('帐号不能为空');
			$('#username').focus();
			return;
		}
		if($("#password").val() == ''){
			alert('密码不能为空');
			$('#password').focus();
			return;
		}
		$.ajax({
			url		:'/login.html?inajax=1&login_from=member',
			data	:$("#form1").serialize(),
			type	:'POST',
			dataType:'json',
			success	:function(json){
				if(json['code']==1){
					if(json["returnurl"]=='/member.html'){
							location.href="/member/space.html";
						}else{
							location.href=json["returnurl"];
						}
				}else{
					alert(json["message"]);
				}
				return false;
			}
		});
	});
});

	
function searchspace(type){
	var searchvalue = $("#"+type+"value").val();
	if(searchvalue=='请输入您要搜索的作品或作者名称'){
		searchvalue='';
	}
	
	if(type!=''){
		var href = '/spacelist-0-0-'+type+'.html?key='+searchvalue;
	}
	location.href = href;
}


function replaceAll(str,find,rp){
	while(true){
		if(str.indexOf(find) == -1){
			break;
		}
		str = str.replace(find,rp);
	}
	return str;
}

//兼容多个浏览器Enter提交
document.onkeydown=function(event) 
{ 
	e = event ? event :(window.event ? window.event : null); 
	if(e.keyCode==13){ 

		if($("#q").val()!="输入您要搜索的课件名称"){
			$("#scbar_btn").click();
		}else{
			$("#loginsubmit").click();
		}
	e.returnValue = false;
	}
}

</script>
<!-- <div style="clear:both;"></div> -->
<?php
	$this->display('common/player');
   
?>
</div>
<div style="clear:both;margin-top:-1px;"></div>
<?php  $this->display('common/footer'); ?>