<?php
	$this->display('common/header');
?>
<?php 
  $type = $this->uri->viewmode;
  $type = empty($type)?'spacedateline':$type;
  $sortarray = array('spacedateline'=>'sort');
  $spacearray = array('space'=>'sort');
  $hotarray = array('hot'=>'sort');
  $sortmode = $this->uri->uri_sortmode();
?>
<link href="http://static.ebanhui.com/ebh/tpl/2014/css/seek.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link href="http://static.ebanhui.com/ebh/tpl/2014/css/fanart.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
<script type="text/javascript">
$(function() {
//	$('.newku a').lightBox();
	$('.spdiv a').lightBox();
//	$('.imagea').lightBox();
});
</script>
<script type="text/javascript">
$(function(){
	$('#findspace').click(function(){
		var searchvalue = $("#stitle").val();
		if(searchvalue=='请输入您要搜索的作品或作者名称'){
			searchvalue='';
		}
		var type = '<?=$type ?>';
		var href = '/spacelist-0-0-'+type+'.html?key='+searchvalue;
		location.href = href;
	});
});
function sortspace(type){
	var searchvalue = $("#stitle").val();
		if(searchvalue=='请输入您要搜索的作品或作者名称'){
			searchvalue='';
		}
		var href='/spacelist-0-0-'+type+'.html?q='+searchvalue;
		
		window.location.href = href;
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
</script>
<div class="main">
<div class="toptitnew"><a href="/">首页</a> > <a href="/space.html">原创空间</a> > 查找原创空间</div>
<div class="soupai" style="border:none;margin-top:10px;">
<ul>
<li <?php if($sortmode==0){echo 'class=xuanz';}?> ><a href="/spacelist-1-0-spacedateline.html">默认推荐</a></li>
<li <?php if($sortmode==1){echo 'class=xuanz';}?> ><a href="/spacelist-1-1-space.html">最新原创</a></li>
<li <?php if($sortmode==2){echo 'class=xuanz';}?> ><a href="/spacelist-1-2-hot.html">热门原创</a></li>
</ul>
<input name="spacevalue" id="spacevalue" type="text" class="seek" value="请输入您要搜索的作品或作者名称" onfocus="if($(this).val()=='请输入您要搜索的作品或作者名称'){$(this).val('').css('color','#666666');}" onblur="if($(this).val()==''){$(this).val('请输入您要搜索的作品或作者名称').css('color','#666666');}" />
  	<input class="seekbtn" type="submit" name="searchname" onclick="searchspace('space')" id="searchname" value="" />
 	<a href="<?= geturl('spacelist-0-0-space')?>"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/morebtn0620.jpg" /></a>
</div>
<div class="leflist">
<div class="ad"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/ad10726.jpg" /></div>

<div class="choose">
<h3 class="titchoosc">推荐</h3>
<ul>
	<?php foreach($bestlist as $bestk=>$bestv){ ?>
		<li><span class="tilbiao"><?= $bestk+1?></span><a href="<?= geturl('space/'.$bestv['id'])?>" class="buckes" title="<?= $bestv['title']?>"><?= ssubstrch($bestv['title'],0,16)?></a><span><a href="<?= geturl('spacelist.html?key='.$bestv['username'])?>" title="<?= $bestv['username']?>"><?= ssubstrch($bestv['username'],0,6)?></a></span></li>
	<?php } ?>
</ul>
</div>

<div class="choose">
	<h3 class="titchoosc">热评</h3>
	<ul>
		<?php foreach($hotlist as $hotk=>$hotv){ ?>
			<li><span class="tilbiao"><?= $hotk+1?></span><a href="<?= geturl('space/'.$hotv['id'])?>" class="buckes" title="<?= $hotv['title']?>"><?= ssubstrch($hotv['title'],0,16)?></a><span><a href="<?= geturl('spacelist.html?key='.$hotv['username'])?>" title="<?= $hotv['username']?>"><?= ssubstrch($hotv['username'],0,6)?></a></span></li>
		<?php } ?>
	</ul>
</div>
<div class="ad"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/ad20726.jpg" /></div>
</div>

		<?php if(!empty($pinfor)){?>
			<div id="yin" class="geren">
			<h2>原创者个人资料</h2>
				<div class="ziliao">
					<?php 
						$sex = empty($pinfor['sex']) ? 'man' : 'woman';
						$type = $pinfor['groupid'] == 5 ? 't' : 'm';
						$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$type.'_'.$sex.'.jpg';
						$face = empty($pinfor['face']) ? $defaulturl : $pinfor['face'];
						$facethumb = getthumb($face,'78_78');
					?>
					<div class="rwtu"><img src="<?= $facethumb ?>"  width="78px" height="78px" /></div>
					<ul>
					<li class="nicheng">昵称：<span style="font-weight:bold;"><?= shortstr($pinfor['nickname'],18)?></span></li>
					<li class="xname">姓名：<span><?= shortstr($pinfor['realname'],18)?><span style="color:#525252;"></span></span></li>
					<li class="qqhao">Q　Q：<a target="_blank"  href="http://wpa.qq.com/msgrd?v=3&uin=<?= $pinfor['qq']?>&site=qq&menu=yes""><?= $pinfor['qq']?></a></li>
					</ul>
					<ul>
					<li class="elash">邮箱：<a href="mailto:<?= $pinfor['email']?>"><?= $pinfor['email']?></a></li>
					<li class="zuopin">作品：<span style="color:#e21f2d;"><?= $pinfor['spacenum']?></span>&nbsp;幅</li>
					</ul>
					<p class="sita">地址：<?= ssubstrch($pinfor['address'],0,50)?>
					<span style="margin-left:35px;"></span></p>
				</div>
				<div class="weijian">
					<div class="neiqu">
					<h3>个人简介：</h3>
					<p><?= $pinfor['profile']?></p>
					</div>
				</div>
			</div>
		<?php }?>


<div class="list">
	<ul class="align_box">
		<?php if(empty($lists)){?>
			&nbsp;&nbsp;未找到任何记录
		<?php }else{ ?>
			<?php foreach($lists as $sv){?>
				<li > 
					<div class="spdiv">
						<a href="<?= $showpath.$sv['image']?>" title="<?= $sv['title']?>">
							<img src="<?= getthumb($showpath.$sv['image'],'126_126')?>" class="show_img" /> 
							<img class="alpha_img" src="http://static.ebanhui.com/ebh/tpl/2012/images/pixel.gif"/>
						</a>
					</div>
					<h3 class="sizes"><a href="/space/<?= $sv['id']?>.html" style="color:#007dc5;width:145px;float:left;" title="<?= $sv['title']?>"><?= ssubstrch($sv['title'],0,22)?></a>
						<span style=" color:#bf0000; margin-right:10px;"><a href="/spacelist.html?key=<?= $sv['username']?>"><?= $sv['username']?></a></span><span><?= date('Y-m-d',$sv['dateline'])?></span>
					</h3>
				</li> 
			<?php }?>
		<?php }?>
	</ul>
	<?= $pagestr ?>
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
</div>
<div style="clear:both;"></div>
<?php
	$this->display('common/player');
    $this->display('common/footer');
?>