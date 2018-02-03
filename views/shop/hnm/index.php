<?php
$this->display('shop/hnm/header');
?>

<div class="waidlog">
<div class="toadlog">
<div class="lefad"><?=$this->widget('ad_widget', $adlist, array('_id' => 'actor', '_width' => 660, '_height' => 270));?></div>
<div class="riglogo">
<h2 class="tituser">用户登录</h2>
<?php if(empty($user)){?>


<form id="form1" name="form1" action="/login.html?inajax=1&login_from=classroom" onsubmit="form_submit();return false;">
		<input type="hidden" name="loginsubmit" value="1" />
<input class="usertxt" type="text" value="账号" onblur="if(this.value==''){this.value='账号'}" onfocus="if(this.value=='账号'){this.value=''}" name="username"/>
<input type="password" class="usertxt"  name="password"/>
<div class="dengl">
<a href="javascript:void(0)" onclick="$('#form1').submit()" class="dengbet">登 录</a>
<label>
<input class="xunazbtn" name="cookietime" type="checkbox" value="1" />下次自动登录<label>
</div>
<div class="qtlol" style="float:left;margin:15px 0 15px 12px;">
<span style="color:#888;">用其他账号登录：</span>
<a href="/otherlogin/qq.html">
<img src="http://static.ebanhui.com/ebh/tpl/2012/images/qqico0925.jpg">
</a>
<a href="/otherlogin/sina.html">
<img src="http://static.ebanhui.com/ebh/tpl/2012/images/sianico0925.jpg">
</a>
</div>
<div class="userti">
<span class="wangpass"><a href="/forget.html">忘记密码</a></span>|<span style="margin-left:42px;"><a href="/register.html">现在注册</a></span>
</div>

<?php }else{
	$sex = empty($user['sex']) ? 'man' : 'woman';
    $type = $user['groupid'] == 5 ? 't' : 'm';
    $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$type.'_'.$sex.'.jpg';
    $face = empty($user['face']) ? $defaulturl : $user['face'];
    $facethumb = getthumb($face,'78_78');
?>
<div class="fanh" style="margin-left:25px;margin-top:20px;">

                    <div class="waikuang"><img src="<?=$facethumb?>" width="78" height="78" /></div>
                    <div class="grmingz" style="margin-left:15px;">
                        <p class="zi" style="margin-bottom:5px;"><?=$user['username']?></p>
                        <p>上次登录时间： <span class="col"><?=	$user['lastlogintime']?></span></p>
                    </div>
                </div>
                <div style="float:left;">
				<?php
				if($user['groupid']==5)
					$enterurl = '/teacher/choose.html';
				else
					$enterurl = '/myroom.html';
				?>
                                        <input type="button" class="loggrzx" onmouseover="this.className = 'loggrzx2'" onmouseout="this.className = 'loggrzx'" style="margin-bottom: 10px;margin-left:85px;" value="马上进入" onclick="window.location.href = '<?=$enterurl?>'" />
                                    </div>
                <div class="userti" style="margin-top:25px;">
				<?php
				if($user['groupid'] == 6){
					$centerurl = '/member.html';
				}else{
					$centerurl = '/teacher/choose.html';
				}
				?>
<span class="wangpass"><a href="<?=$centerurl?>">个人中心</a></span>|<span style="margin-left:42px;"><a href="/logout.html">退出</a></span>
</div>
                            </div>
				

<?php
}?>
</div>
</div>
</div>
<div class="derfl" style="margin-bottom:20px;">
<div class="wigkhr">
<div class="leffyhn">
<div class="ptjian">
<h2 class="hptjie"></h2>
<div class="hnsize" style="word-wrap:break-word">
	<?=shortstr($room['summary'],300)?>
</div>
<div class="adsan">
<?php
foreach($midadlist as $ml){
unset($target);
if($ml['itemurl']!='#'){
	if(substr($ml['itemurl'],0,7)!='http://'){
		$pre = 'http://';
	}else{
		$pre = '';
	}
	$url = $pre.$ml['itemurl'];
}else{
	$url = $ml['itemurl'];
	$target = '';
}
?>
<a target="<?=isset($target)?$target:'_blank'?>" href="<?=$url?>"><img title="<?=$ml['subject']?>" style="width:220px;height:102px;" src="<?=$ml['thumb']?>" /></a>
<?php }?>
</div>
<div class="xuexizhan">
<?php
$zizhanclass = 'zizhantit';
if($room['crid']=='10506')
	$zizhanclass = 'qiyezizhan';
elseif($room['crid']=='10427' || $room['crid']=='10426')
	$zizhanclass = 'wangxiaozizhan';
?>
<h2 class="<?=$zizhanclass?>"><span><img src="http://static.ebanhui.com/ebh/tpl/default/images/hn_zizhanlie.jpg" /> 列表</span></h2>
<ul class="zizhanlie">
<?php 
foreach($zwxlist as $k=>$zwx){
$logo=empty($zwx['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$zwx['cface'];
if($k<3){
?>
<li class="leich" style="margin-left:0;">
<?php }else{?>
<li class="leich" style="margin-left:0;_border-top: 2px solid #e8e8e8;">
<?php }?>
<a href="http://<?=$zwx['domain']?>.ebanhui.com" target="_blank">
<h3 class="ketit"><?=$zwx['crname']?></h3>
</a>
<div class="kewaik">
<a href="http://<?=$zwx['domain']?>.ebanhui.com" target="_blank">

<img style="width:100px;height:100px;" src="<?=$logo?>">
</a>
</div>
<div class="rigxiaox">
<p class="botthui">
课件数：
<span><?= ($zwx['coursenum'])?></span>
</p>
<p class="botthui">
作业数：
<span><?= ($zwx['examcount'])?></span>
</p>
	<?php 
		$cloudurl = 'http://'.$zwx['domain'].'.ebanhui.com';
		if(empty($user)){
		
	?>
	<input class="xuexibtns" type="button" value="开始学习"  onclick="location.href='http://<?= $zwx['domain']?>.ebanhui.com'" name='http://<?= $zwx['domain']?>.ebanhui.com'/>
	<?php }else{ ?>
		<?php if($user['groupid']==6){ ?>
				<input class="xuexibtns" type="button" value="开始学习" onclick="location.href='<?= $cloudurl?>'"/>
		<?php }else{ ?>
			<input class="xuexibtns" type="button" value="马上进入" onclick="location.href='<?= $cloudurl?>'"/>
		<?php } ?>
	<?php } ?>
</div>

<p class="fottpp"><?=$zwx['summary']?></p>
</li>
<?php }?>
</ul>
</div>
</div>
</div>
<div class="riggyhn">
<div class="reke">
<h2 class="hekec"></h2>
<div class="rekelie">
<ul>
<?php 
foreach($hotcourselist as $k=>$v){
	if($k<3){
		$lightstyle = ' style="color:#ff7e11;"';
	}else{
		$lightstyle = '';
	}
?>
<li><span class="wenlie" <?=$lightstyle?>>0<?=$k+1?></span><a target="_blank" href="/course/<?=$v['cwid']?>.html"><?=($v['title'])?></a></li>
<?php }?>
</ul>
</div>
</div>
<div class="dongt">
<h2 class="dongtit"></h2>
<div class="taodf">
<ul>
<?php foreach($newslist as $nl){?>
<li><a target="_blank" href="/dyinformation/<?=$nl['itemid']?>.html"><?=$nl['subject']?></a></li>
<?php }?>

</ul>
</div>
</div>
<div class="linkqq">
<a href="http://wpa.qq.com/msgrd?v=3&uin=642006923&site=qq&menu=yes" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/default/images/hn_linkqq.jpg" /></a>
</div>
</div>
</div>
</div>
<div style="text-align:center;clear:both;margin-bottom:10px;">

<?php
$this->display('common/footer');
?>
</div>
<style>
li.leich:hover{
	background-color:#f8f8f8;
}
</style>
</body>
</html>
