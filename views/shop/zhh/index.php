<?php $this->display('shop/zwx/header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/citytpl/stores/css/wxind.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery.lazyload.js"></script>

<style type="text/css">   

.huanqiu {
	float: left;
    height: 225px;
    _height: 235px;
	margin-right: 15px;
    width: 351px;
	display:inline;
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
    margin-left: 8px;
    margin-top: 5px;
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
.zizhan .fottpp {
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
	margin-top:12px;
}

</style>


<div class="dhtop2">
<ul style="margin-left:55px;">
<li class="dhdan"><a href="/"><img src="http://static.ebanhui.com/ebh/tpl/default/images/dhind0411.jpg" /></a></li>
<li class="dhdan"><a href="<?= geturl('introduce')?>"></a></li>
<li class="dhdan"><a href="<?= geturl('dyinformation')?>"></a></li>
<li class="dhdan"><a href="<?= geturl('contacts')?>"></a></li>
</ul>
</div>
</div>

<div style="clear:both"></div>

<div class="zzind">
<div class="fontxian">
<div class="lefzong">
<div class="zongjie" style="background:url(http://static.ebanhui.com/ebh/tpl/default/images/zzjsbg0412.jpg) no-repeat;_height:256px;">
<div class="leftu">
<?php $logo=empty($room['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$room['cface']?>
<img src="<?= $logo?>" width="100" height="100" />
</div>
<div class="rigjj" style="position: relative;">
<?php
	$name = $room['crname'];
	if($this->uri->uri_domain()=='szzhzx')
		$name = '博览课程';
?>
<h2 class="titlan"><?= $name?></h2>
<p class="ploes"><?= shortstr($room['summary'],300)?></p>

<ul>
<li class="xinmm"><?= $teacher['realname']?></li>
<?php
if(preg_match('/^[a-zA-Z0-9_\-]{1,}@[a-zA-Z0-9_\-]{1,}\.[a-zA-Z0-9_\-.]{1,}$/',$room['cremail'])){
	$pre = 'mailto:';
}elseif(substr($room['cremail'],0,7)!='http://'){
	$pre = 'http://';
}else{
	$pre = '';
}
?>
<li class="youxx" style="width:325px;"><a target="_blank" href="<?= $pre.$room['cremail']?>"><?= $room['cremail']?></a></li>
<li class="dianhh"><?= $room['crphone']?></li>
<li class="dizz" style="width:325px;"><?= $room['craddress']?></li>
</ul>
</div>
</div>

<div class="append_new">
	<?php
	$itemi = 0;
	foreach($folderslist as $item) {
		$furl = 'http://'.$this->uri->uri_domain().'.'.$this->uri->curdomain.'/myroom/stusubject/'.$item['folderid'].'.html';
		
	?>
	<ul style="float:left;">
		<li class="huanqiu linewline" <?= ((($itemi +1)% 2 == 0) ?' style="margin-right:0;"':'') ?>>
		<div class="enidet" onmouseout="this.className='enidet'" onmouseover="this.className='enidets'">
		<h3 class="kjname">
		<a href="<?= geturl('courseinfo/zhh/'.$item['folderid']) ?>" target="_blank" title="<?= $item['foldername'] ?>" class="" name="<?= $furl ?>"><?= ssubstrch($item['foldername'],0,28) ?></a>
		</h3>
		<div class="dettu" style="display:inline;">
		<a class="img-shadow" target="_blank" href="<?= geturl('courseinfo/zhh/'.$item['folderid']) ?>" name="<?= $furl ?>">
		<img width="114" height="159" src="<?= empty($item['img']) ? 'http://static.ebanhui.com/ebh/images/nopic.jpg' :$item['img'] ?> " style="opacity: 1;">
		</a>
		</div>
	<div class="rigxiaox">
	
	<p class="fottpp"><?= ssubstrch($item['summary'],0,150) ?></p>

		</div>
		<div style="width:100px;float:left;">
			<p class="botthui" style="width:82px;">
	课 时：
	<span><?= $item['coursewarenum']?></span>
	</p>
	<p class="botthui">
	人 气：
	<span><?= $item['viewnum']?></span>
	</p>
	</div>
		
		</div>
		</li>
		</ul>
	<?php 
		
		$itemi ++;
		}
	?>
</div>
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
	<div style="float:left;margin-top:20px;"><p style="font-weight:bold;font-size:14px;"><?= $user['username'] ?></p><p>上次登录时间:</p><p><?= $user['lastlogintime']?></p></div>
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
	<span>帐号：</span><input class="zhangh" id="username" name="username" type="text" value="" maxlength="16"/>
	</div>
	<div class="useer">
	<span>密码：</span><input class="pass" id="password" name="password" type="password" value="" maxlength="16"/>
	</div>
	<div class="fuxuan">
	<?php if(!empty($user)){ ?>
	<input id="xuangou" type="checkbox" name="checkbox" value="<?= 3600*24*14?>" checked='checked' style="margin-top:2px;float:left;" />
	<?php }else{ ?>
	<input id="xuangou" type="checkbox" name="checkbox" value="<?= 3600*24*14?>" style="margin-top:2px;float:left;" />
	<?php } ?>
	<label for="xuangou" style="float:left;color:#888;">下次自动登录</label></div>
	<input class="logobtn" type="submit" name="Submit" value="立即登录" />
	<div class="qtlol">
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
		<a style="color:#808080;" href="/register.html">用户注册</a> |
		<a style="color:#808080;" href="/forget.html">忘记密码？</a>
	</div>
	<?php } ?>
</form>
<?php } ?>
</div>

<?php if(!empty($mitemlist)){?>
<div class="zixunku">
<ul>
<?php foreach($mitemlist as $value){ ?>
<li><?= shortstr($value['subject'],30)?></li>
<?php } ?>
</ul>
</div>
<?php } ?>
<?php 
if($this->uri->uri_domain() == 'sy' || $this->uri->uri_domain() == 'sxyz' || $this->uri->uri_domain() == 'rqzx' || $this->uri->uri_domain() == 'hxsy' || $this->uri->uri_domain() == 'jsez' || $this->uri->uri_domain() == 'nhgj') { ?>
<div class="sanad" style="height:760px;margin-top:12px">
<a target="_blank" href="/getusername.html"><img src="http://static.ebanhui.com/ebh/tpl/default/images/chaxunbanner.gif" /></a>
<?php } else { ?>
<div class="sanad" style="height:453px;margin-top:12px">
<?php } ?>
<a target="_blank" href="http://static.ebanhui.com/help/bfq_install.htm"><img src="http://static.ebanhui.com/ebh/tpl/default/images/rengbuneng.jpg" /></a>
<a target="_blank" href="http://static.ebanhui.com/help/dayiru.htm"><img src="http://static.ebanhui.com/ebh/tpl/default/images/dayiru.jpg" /></a>
<a target="_blank" href="http://www.ebanhui.com/faq.html"><img src="http://static.ebanhui.com/ebh/tpl/default/images/changjian.jpg" /></a>

</div>
</div>
</div>

</div>
<div style="clear:both"></div>

<?php
$this->display('common/footer');
?>