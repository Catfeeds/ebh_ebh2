<?php $this->display('shop/zho/header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery.lazyload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.vticker-min.js"></script>

<style type="text/css">   
.scroll_div {width:958px;margin:0 auto;overflow: hidden;white-space: nowrap;}
#scroll_begin, #scroll_end, #scroll_begin ul, #scroll_end ul, #scroll_begin ul li, #scroll_end ul li{display:inline;}  
#scroll_begin ul li {margin-left:15px;}
.huanqiu {
	float: left;
    height: 225px;
    margin-right: 15px;
    width: 351px;
}
.huanqiu .enidet {
    border: 1px solid #d4d4d4;
    height: 220px;
    width: 351px;
	background:#fff;
}
.huanqiu .enidets {
    background-color: #eaf6fa;
    border: 1px solid #d4d4d4;
    height: 220px;
    width: 351px;
}
.huanqiu .dettu {
    float: left;
    margin-left: 12px;
    margin-top: 9px;
	width:130px;
}
.kjname{
    color: #666666;
    font-size: 14px;
    font-weight: bold;
    height: 30px;
    line-height: 30px;
	padding-left:10px;
    width: 330px;
}
.huanqiu .refdet {
    float: left;
    height: 86px;
    margin-left: 8px;
	overflow:hidden;
    margin-top: 20px;
	text-indent:30px;
    width: 90px;
	word-wrap:break-word;
}
.enidet a.mianstbtn {
	width:114px;
	height:34px;
	line-height:36px;
	display:block;
	background:#19a8f7;
	border:solid 1px #0e9be9;
	float:left;
	font-size:16px;
	font-weight:bold;
	color:#fff;
	text-align:center;
	margin-top:12px;
	margin-left:55px;
}
.enidets a.mianstbtn {
	width:114px;
	line-height:36px;
	color:#fff;	
	font-size:16px;
	font-weight:bold;
	height:34px;
	text-align:center;
	display:block;
	background:#0e9be9;
	border:solid 1px #0e9be9;
	float:left;
	margin-top:12px;
	margin-left:55px;
	 text-decoration: none;
}
.enidet a.zaixxbtn {
	width:114px;
	height:34px;
	line-height:36px;
	display:block;
	background:#ea732f;
	border:solid 1px #d6682a;
	float:left;
	font-size:16px;
	font-weight:bold;
	color:#fff;
	text-align:center;
	margin-top:12px;
	margin-left:55px;
}
.enidets a.zaixxbtn {
	width:114px;
	line-height:36px;
	color:#fff;	
	font-size:16px;
	font-weight:bold;
	height:34px;
	text-align:center;
	display:block;
	background:#d6682a;
	border:solid 1px #d6682a;
	float:left;
	margin-top:12px;
	margin-left:55px;
	text-decoration: none;
}
.xiaotiter {
    background: url("http://static.ebanhui.com/ebh/tpl/default/images/dihongx.jpg?v=20141208") no-repeat left bottom;
    height: 35px;
    line-height: 35px;
	font-size:18px;
	position: relative;
	padding-left:10px;
	width:709px;
	font-family:"微软雅黑";
	font-weight:bold;
	margin-bottom:10px;
}

.titerl {
    border-bottom: 1px solid #12abd5;
    float: left;
    height: 34px;
    width: 598px;
}
.linewline {
	margin-bottom:10px;
}

.rigxiaox {
    float: left;
    height: 128px;
    margin-top: 10px;
	margin-left:10px;
	width:195px;
}
.botthui {
    color: #999;
    margin-bottom: 0;
	margin-top:0px;
	margin-left:10px;
	float:left;
	width:100px;
}
.fottpp {
    color: #666;
    float: left;
    line-height: 2;
    margin-top: 0px;
    overflow: hidden;
    text-indent: 25px;
	margin-left:0px;
    width: 195px;
    word-wrap: break-word;
}
.lefadlo .toplogo .logobtn {
	background:#18a8f7;
	width:135px;
	height:32px;
	line-height:32px;
	border:none;
	font-size:16px;
	text-align:center;
	color:#fff;
	cursor:pointer;
	margin:0 0 10px 45px ;
}
.zzind .lefadlo .toplogo .msjinr {
	background:#18a8f7;
	width:135px;
	height:32px;
	line-height:32px;
	border:none;
	cursor:pointer;
	margin:0 0 27px 45px ;
	font-size:16px;
	text-align:center;
	color:#fff;
	margin-top:22px;
}
.rigjj a.lsts {
	position: absolute;
	top:0px;
	right:0px;
}
.append_new{
	float:left;
}

.fewof .leraten1 {
    background: url("http://static.ebanhui.com/ebh/tpl/default/images/titcqbg1.jpg") no-repeat scroll;
    color: #299de6;
    height: 36px;
    left: 0;
    line-height: 38px;
    position: absolute;
    top: -4px;
    width: 239px;
}
.fewof .leraten a{
	color: red;
}
.sp_div a {
	color:#299de6;
}
.rigxiaox a.zhutk {
	font-size:12px;font-weight:bold;color:#299de6;text-decoration: underline;margin-bottom:5px;float:left;width:195px;
}
.xueping {
    float: left;
	display:inline;
    margin: 10px 0 0 50px;
    width: 110px;
}
#edrghgh a.fenstbtn {
	float:left;
	display:block;
	width:50%;
	height:149px;
}
.sbs{
display:none;
}

.wangxiaojianjie{width:960px; margin:0 auto; background:url("http://static.ebanhui.com/ebh/tpl/default/images/bjs.jpg") no-repeat right -60px;}
.wangxiaojianjie .title1{ background:url("http://static.ebanhui.com/ebh/tpl/default/images/title1.jpg") no-repeat left center; height:48px; margin-bottom:5px; margin-top:20px;}
.wangxiaojianjie  p{text-indent:32px; font-family:"微软雅黑"; font-size:16px; color:#696969;}
.advange .title2{ background:url("http://static.ebanhui.com/ebh/tpl/default/images/title2.jpg") no-repeat left center; height:52px; margin-bottom:20px; margin-top:20px;}
.advange{width:960px; margin:0 auto;}
.advange .advange_son ul li{ text-align:center; margin-bottom:30px;}
.fontxian .title3{ background:url("http://static.ebanhui.com/ebh/tpl/default/images/title3.jpg") no-repeat left center; height:60px;}
.fldty{ border-top:1px solid #e1e1e1; padding-top:30px;}
.mfst li{ width:165px; float:left; display:inline; margin-left:19px;}
.mfst li.first{ margin-left:0;}
.mfst{ width:719px; height:145px;}
.mfst img{width:165px; height:110px;}
.ljstg {
	float:left;
	width:190px;
	text-align:center;
	font-size:14px;
}
.ketgd {
	float:left;
	margin-left:33px;
}
.shitsti {
	width:230px;
	border:solid 1px #dadada;
	margin-top:10px;
	height:36px;
}
.shitsti img {
	float:left;
}
</style>


<div class="dhtopes">
<ul class="reygtds">
<li class="dhdanes" style="margin-left:90px;"><a href="/"></a></li>
<li class="dhdanes"><a href="<?= geturl('introduce')?>"></a></li>
<li class="dhdanes"><a href="<?= geturl('dyinformation')?>"></a></li>
<li class="dhdanes"><a href="<?= geturl('contacts')?>"></a></li>
</ul>
</div>

<div style="clear:both"></div>

<div class="zzind">
<div class="fontxian">
<div class="lefzong">
<?php $height = 190+ceil(count($mitemlist)/2)*20;?>
<div class="zongjiees" style="height:<?=$height?>px">
<div class="leftus">
<?php $logo=empty($room['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$room['cface']?>
<img src="http://static.ebanhui.com/ebh/tpl/default/images/legytu.jpg" width="100" height="100" />
</div>

<?php
if(preg_match('/^[a-zA-Z0-9_\-]{1,}@[a-zA-Z0-9_\-]{1,}\.[a-zA-Z0-9_\-.]{1,}$/',$room['cremail'])){
	$pre = 'mailto:';
}elseif(substr($room['cremail'],0,7)!='http://'){
	$pre = 'http://';
}else{
	$pre = '';
}
?>
<div class="rigjjs" style="position: relative;">
<div>
	<div style="float:left; display:inline;">
		<h2 class="titlans"><?= $room['crname']?></h2>
		<p class="youxx"> <a href="<?= $pre.$room['cremail']?>"><?= $room['cremail']?></a></p>
	</div>
	<div style="float:left; display:inline; padding-left:20px;">
		<a href="http://dh.ebh.net/course/35270.html" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/default/images/schoolint.jpg" height="36" width="112"/></a>
	</div>
</div>

<div style="clear:both;"></div>

<p class="ploes" style="height:105px"><?= shortstr($room['summary'],300)?></p>
<?php 
if(!empty($mitemlist)){
foreach($mitemlist as $value){
	$newsurl = geturl('dyinformation/'.$value['itemid']);

	?>
	<div class="auli" style="width:230px">
	&bull; <a style="text-decoration:underline" href="<?= $newsurl ?>" title="<?= $value['subject']?>" target="_blank"><span class="cfrgt"><?= shortstr($value['subject'],24)?></span></a>
	
	</div>
	<?php }
	} ?>


</div>
</div>
<?php 
if(empty($user))
	$freecw = 'href="javascript:void(0)" name="/" class="dologin"';
elseif($user['groupid'] == 6)
	$freecw = 'href="/myroom/stusubject/5901.html" target="_blank"';
else
	$freecw = 'href="javascript:void(0)"';
?>
<div class="mfst">
	<ul>
		<li class="first">
			<div><a href="http://dh.ebh.net/course/29682.html" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/default/images/shiting.jpg" /></a></div>
			<div style="text-align:center;"><a href="http://dh.ebh.net/course/29682.html" target="_blank" style="color:#18a8f7;font-size:16px; font-family:微软雅黑; ">毛笔基础班试看</a></div>
		</li>
		<li>
			<div><a href="http://dh.ebh.net/course/29674.html" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/default/images/shiting1.jpg" /></a></div>
			<div style="text-align:center;"><a href="http://dh.ebh.net/course/29674.html" target="_blank" style="color:#18a8f7;font-size:16px; font-family:微软雅黑; ">钢笔基础班试看</a></div>
		</li>
		<li>
			<div><a href="http://dh.ebh.net/course/29687.html" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/default/images/shiting3.jpg" /></a></div>
			<div style="text-align:center;"><a href="http://dh.ebh.net/course/29687.html" target="_blank" style="color:#18a8f7;font-size:16px; font-family:微软雅黑; ">国画基础班试看</a></div>
		</li>
		<li>
			<div><a href="http://dh.ebh.net/course/34005.html" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/default/images/shiting4.jpg" /></a></div>
			<div style="text-align:center;"><a href="http://dh.ebh.net/course/34005.html" target="_blank" style="color:#18a8f7;font-size:16px; font-family:微软雅黑; ">小学生字同步练习试看</a></div>
		</li>
	</ul>
</div>
<div class='title3'></div>

<?php 
	$i = 0;
	//foreach($termlist as $splist){
	foreach($splist as $spkey=>$sp) { 
		if(empty($sp['itemlist']) || !is_array($sp))
			continue;
		?>
<div id="itempid_<?= $sp['pid'] ?>" class="append_new " <?= $i == 0? '' : 'style="display:none;"' ?> >
	<?php
	$itemi = 0;
	$lastsid = '';
	foreach($sp['itemlist'] as $k=>$item) {
		$furl = '';
		if($item['fprice'] == 0 || isset($mylist[$item['folderid']])) {
			$furl = '/myroom/stusubject/'.$item['folderid'].'.html';
		} else {
			
			$furl = '/ibuy.html?itemid='.$item['itemid'];
			if(!empty($item['sid']) && isset($sortlist[$item['sid']])) {
				$furl .= '&sid='.$item['sid'];
			}
			
		}
		
		
		if($item['sid']!=$lastsid){
			
			
		?>
		
			<?php 
				
				
				if(empty($user))
					$fsurl = 'href="javascript:void(0);"class="dologin" name="/ibuy.html?itemid='.$item['itemid'].'"';
				elseif($user['groupid'] == 6){
					if($item['fprice'] == 0 || isset($mylist[$item['folderid']])) {
						$fsurl = 'href="/myroom/stusubject/'.$item['folderid'].'.html" target="_blank"';
					}else{
						$fsurl = 'href="/ibuy.html?itemid='.$item['itemid'].'" target="_blank"';
					}
				}
					
				else
					$fsurl = 'href="javascript:void(0);" onclick="alert(\'对不起，您是教师账号，不允许进行此操作。\')"';
				?>
			
			
			<div class=""  style="margin-top:15px;width:719px;height:195px;">
			<ul>
	<li class="huanqiu linewline" style="width:719px;margin:0;height:195px;">
		<div onmouseover="this.className='enidets'" onmouseout="this.className='enidet'" class="enidet" style="width:717px;height:190px;">
		<div style="display:inline;width:230px;height:170px;" class="dettu" >
		<?php $sortimage = '';?>
		<a href="<?=geturl('courseinfo/'.$item['itemid'])?>" onclick="">
		<img width="230" height="170" style="opacity: 1;" src="<?=$item['simg']?>">
		</a>
		</div>
		
<div class="rigxiaox" style="width:460px;">
		<h3 class="kjname" style="width:440px;">
		<a style="color:blue;font-size:16px;" href="<?=geturl('courseinfo/'.$item['itemid'])?>" title="<?=$item['iname']?>"><?=$item['iname']?></a>
		</h3>
	<p><a class="zhutk" style="width:460px;" href="<?=geturl('courseinfo/'.$item['itemid'])?>" ><?=$item['speaker']?></a></p>
	<p class="fottpp" style="width:460px;"><?=$item['summary']?></p>

		</div>
		<?php if(!isset($mylist[$item['folderid']]) && $item['fprice'] != 0) {
			if(empty($item['cannotpay'])){?>
				<a <?=$fsurl?> style="background: none repeat scroll 0 0 #ea732f;color: #ffffff;cursor: pointer;display: block;float: right;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #d6682a;margin-top:10px;margin-right:10px;">报 名</a>
				<?php }else{?>
				<a href="javascript:void(0)" style="background: none repeat scroll 0 0 #888888;color: #ffffff;cursor: default;display: block;float: right;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #888888;margin-top:10px;margin-right:10px;">报 名</a>
			<?php }}else{?>
				<a <?=$fsurl?> style="background: none repeat scroll 0 0 #0d9be9;color: #ffffff;cursor: pointer;display: block;float: right;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #18a8f7;margin-top:10px;margin-right:10px;">进 入</a>
		<?php }?>
		</div>
		</li>
		</ul>
	</div>
			
		<?php	
			}
		}
	?>
</div>
<?php 
	}
?>
</div>



<div class="lefadlo">
<div class="toplogo">
<img src="http://static.ebanhui.com/ebh/tpl/default/images/usetit0217.jpg" />
<?php if(!empty($user)) { ?>
	<?php 
			$sex = empty($user['sex']) ? 'man' : 'woman';
            $type = $user['groupid'] == 5 ? 't' : 'm';
            $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$type.'_'.$sex.'.jpg';
            $face = empty($user['face']) ? $defaulturl : $user['face'];
            $facethumb = getthumb($face,'78_78');
            $url = $user['groupid'] == 5 ? geturl('troom') : geturl('myroom');
		?>
	<div class="tuxiang">
	<div class="tukuang" style="margin-left:20px;margin-top:18px;_margin-left:10px;">
	<img src="<?= $facethumb ?>"/></div>
	<div style="float:left;margin-top:20px;"><p style="font-weight:bold;font-size:14px;"><?=empty($user['realname'])?$user['username']:$user['realname'] ?></p><p>上次登录时间:</p><p><?= $user['lastlogintime']?></p></div>
	</div>
	<?php if($user['groupid'] == 6){ ?>
	<input class="msjinr" type="submit" name="Submit" value="马上进入" onclick="window.location.href='<?= geturl('myroom')?>'" />
	<? }else{ ?>
	<input class="msjinr" type="submit" name="Submit" value="马上进入" onclick="window.location.href='<?= geturl('troom')?>'"/>
	<? } ?>
	<div class="fotlog">
	<?php if($user['groupid'] == 6){ ?>
	<a href="/logout.html" style="color:#808080;">退出</a>
	<? }else{ ?>
	<a href="/logout.html" style="color:#808080;">退出</a>
	<? } ?>
	</div>
<?php }else{ ?>
<form id="form1" name="form1" action="/login.html?inajax=1&login_from=classroom" onsubmit="form_submit();return false;">
		<input type="hidden" name="loginsubmit" value="1" />
	<div class="useer">
	<input class="zhangh2" id="username" name="username" type="text" value="请输入账号" onfocus="if ($('#username').val() == '请输入账号'){$('#username').val('').css('color', '#000000'); }" onblur="if ($('#username').val() == ''){$('#username').val('请输入账号').css('color', '#C3C3C3'); }" maxlength="20"/>
	</div>
	<div class="useer">
	<input class="pass2" id="password" name="password" type="password" value="" maxlength="16"/>
	</div>
	<div class="fuxuan">
	<input type="checkbox" id="cookietime" name="cookietime" value="1"  checked='checked' style="margin-top:2px;float:left;"/>
	<label for="cookietime" style="float:left;color:#888;">下次自动登录</label></div>
	<input class="logobtn" type="submit" name="Submit" value="立即登录" />
	
	<div class="qtlol" style="height:20px">
		<span style="color:#808080;">用其他账号登录：</span>
		<a href="/otherlogin/qq.html">
		<img src="http://static.ebanhui.com/ebh/tpl/default/images/qqico0925.jpg">
		</a>
		<a href="/otherlogin/sina.html">
		<img src="http://static.ebanhui.com/ebh/tpl/default/images/sianico0925.jpg">
		</a>
	</div>
	
	<?php if(empty($user)){	?>
	<div class="fotlog">
		<a style="color:#808080;" href="javascript:void(0)" onclick="showreg('/register/inpage.html','注册账号')">用户注册</a> |
		<a style="color:#808080;" href="/forget.html">忘记密码？</a>
	</div>
	<?php } ?>
</form>
<?php } ?>
</div>
<div class="shitsti">
<a href="http://soft.ebh.net/dh_tv.apk" ><img src="http://static.ebanhui.com/ebh/tpl/2014/images/xinap.jpg"></a>
</div>

<div class="sanad" style="height:1374px;margin-top:12px">

<?php
$helpurl = 'http://static.ebanhui.com/help/cz_issue.htm';

?>
<a target="_blank" href="<?= $helpurl ?>"><img src="http://static.ebanhui.com/ebh/tpl/default/images/ruhechongzhi.jpg" /></a>
<p class="ljstg">关注微信公众号</p>
<img class="ketgd" src="http://static.ebanhui.com/ebh/tpl/2014/images/dh_wei.jpg" />
<div class="news-container" style="width: 208px;float:left;display:inline;margin-left:20px;height:200px;">
<ul>
<?php
foreach($opencountlist as $opencount){
	$rnlength = strlen($opencount['realname']);
	
	$realname = '*'.mb_substr($opencount['realname'],-($rnlength/3-1),2,'utf-8');
?>
	
	<li style="height:39px;overflow:hidden" title="<?=$opencount['oname']?>"><span style="color:blue"><?= shortstr($opencount['username'], 2, '***').substr($opencount['username'],-2)?>(<?=$realname?>)</span> <br/><?='开通 '.$opencount['oname'].' 服务'?></li>
<?php
	}
?>
</ul>
</div>

</div>

</div>
</div>

</div>
<div style="clear:both"></div>

<div class='wangxiaojianjie'>
	<div class='title1'></div>
	<div class='neirong'>
		<p>中国点化网校在线互动教学平台，拥有先进的互联网教学技术和一流的师资队伍，为中小学生和广大书画艺术爱好者提供专业、便捷、高效的一站式线上学习服务。点化网校的教学内容涵盖了硬笔书法、毛笔书法、国画绘画等多种内容；同时开设了亲子启蒙教育、书画鉴定鉴赏、艺术品交流拍卖等特色内容。通过生动的教学课件、老师与学员互动、云端同步学习、分层次专业班级的教学服务，为广大学习者提供良好的书画艺术专业学习。学习合格的学员将获得由中国点化网校与国家或省级书协、美协联合颁发相应的结业证书。</p>
		<p>点化网校师资阵容强大，由原中国硬笔书法家协会主席王正良老师领衔，众多国家及省书协、美协的艺术家和中国美术学院资深老师分别授课，以全新的网络平台、创新的教学理念，为中小学生和广大书画爱好者提供极佳的学习平台。</p>
		<p>相关课程配套教材，学习结束考试及格颁发结业证书。</p>
		<div style=" text-align:center; margin-top:20px;"><img src="http://static.ebanhui.com/ebh/tpl/default/images/jianjies.jpg" ></div>
	</div>
</div>
<div style="clear:both"></div>
<div class="advange">
	<div class="title2"></div>
	<div class="advange_son">
		<ul>
			
			<li><img src="http://static.ebanhui.com/ebh/tpl/default/images/do.jpg"> </li>
			
		</ul>
	</div>
</div>

<script type="text/javascript">
<!--
	$(".dologin").click(function(){
		if ($(this).attr("name") != '') {
			$.loginDialog($(this).attr("name"));
		}else{
			$.loginDialog();
		}
	});
	var curid = 0;
	var curidt = 0;
	var firstclick = 0;
	$(document).ready(function () {
            //滚动新闻条
            $('.news-container').vTicker({
                speed: 500,
                pause: 1000,
                showItems: 29,
                animation: 'fade',
                mousePause: false,
                height: 0,
                direction: 'up'
            });
			$(".sp_div").click(function(){
				var sp_id = $(this).attr("id");
				if(sp_id != "" && sp_id != undefined) {
					sp_id = sp_id.substring(3);
					if(sp_id != curid) {
						$(".sp_div").removeClass("leraten");
						$(this).addClass("leraten");
						$(".append_new").hide();
						$("#itempid_" + sp_id).show();
						curid = sp_id;
					}
				}
				setCookie('ebh_spselected',sp_id);
			});
			// $(".st_div").click(function(){
				// var st_id = $(this).attr("id");
				// if(st_id != "" && st_id != undefined) {
					// st_id = st_id.substring(3);
					// if(st_id != curidt) {
						// $(".st_div").removeClass("leraten1");
						// $(this).addClass("leraten1");
						// $(".tsub").hide();
						// $(".tsub_"+st_id).show();
						// $(".append_new").hide();
						// $(".sp_div").removeClass("leraten");
						// $(".tsub_"+st_id+" div:first").addClass("leraten");
						// curid = $(".tsub_"+st_id+" div:first").attr("id").substring(3);
						// $("#itempid_" + curid).show();
						// curidt = st_id;
					// }
				// }
				// if(firstclick==1)
					// setCookie('ebh_spselected',curid);
				// setCookie('ebh_stselected',st_id);
			// });
			// var historystid = getcookie('ebh_stselected');
			// if(historystid!=''){
				// $("#st_"+historystid).click();
				// firstclick = 1;
			// }
			var historyspid = getcookie('ebh_spselected');
			if(historyspid!=''){
				$("#sp_"+historyspid).click();
			}
        });
		
	function showreg(url,title){
		height = 530;
		width = 645;
		var html = '<iframe scrolling="no" marginheight="0" marginwidth="0" frameborder="0" width="'+width+'" height="'+height+'" src="'+url+'"></iframe>';
		H.create(new P({
			id:'artdialogreg',
			title:title,
			content:html,
			easy:true,
			padding:10
		}),'common').exec('show');
	}
	function showundersort(sid){
		var showed = $('.sbs'+sid).css('display');
	
		if(showed == 'none')
			$('.sbs'+sid).show();
		else
			$('.sbs'+sid).hide();
	}
//-->

</script>
<?php
$this->display('common/footer');
?>