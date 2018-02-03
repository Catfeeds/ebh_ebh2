<?php $this->display('shop/zwx/header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/citytpl/stores/css/wxind.css" />
<style type="text/css">
.lvjies a.toug {
	background:#ea732f;
	color:#fff;
	cursor: pointer;
	display: block;
	height: 28px;
	line-height: 28px;
	text-align: center;
	text-decoration: none;
	width: 100px;
	font-size:14px;
	border:solid 1px #d6682a;
	position: absolute;
	right: 0px;
	top: 0px;
}
.lvjies a.dolog {
	background:#18a8f7;
	color:#fff;
	cursor: pointer;
	display: block;
	height: 28px;
	line-height: 28px;
	text-align: center;
	text-decoration: none;
	width: 100px;
	font-size:14px;
	border:solid 1px #0d9be9;
	position: absolute;
	right: 0px;
	top: 0px;
}
#footer p{
	color:#000;
}
#footer{
	background:#f2f2f2;
}
</style>

<body>
<?php $jx = $room['domain'] == 'jx';?>
<?php if(!$jx){?>
<div class="dhtop">
<?php }else{?>
<div class="dhtop4">
<?php }?>
<ul style="margin-left:55px;">
<li class="dhdan"><a href="/"><img src="http://static.ebanhui.com/ebh/tpl/default/images/dhind0411.jpg" /></a></li>
<li class="dhdan"><a href="<?= geturl('introduce')?>"></a></li>
<li class="dhdan"><a href="<?= geturl('dyinformation')?>"></a></li>
<li class="dhdan"><a href="<?= geturl('cloud')?>"></a></li>
<?php if(!$jx){?>
<li class="dhdan"><a href="<?= geturl('platform')?>"></a></li>
<?php }?>
<li class="dhdan"><a href="<?= geturl('contacts')?>"></a></li>
</ul>
</div>
<div class="lvjies" style="background:white">
<h1 style="position:relative">
<?=$itemdetail['iname']?>

<?php
$roomurl = empty($itemdetail['fulldomain']) ? $itemdetail['domain'].'.ebh.net' : $itemdetail['fulldomain'];
if($itemdetail['fprice']==0){
	$furl = 'http://'.$roomurl.'/myroom/stusubject/'.$itemdetail['folderid'].'.html';
}else{
	$furl = 'http://'.$roomurl.'/ibuy.html?itemid='.$itemdetail['itemid'];
	if(!empty($itemdetail['sid']))
		$furl = $furl.'&sid='.$itemdetail['sid'];
	if($room['domain'] == 'yxwl') {	//易学yxwl
		$furl = '/classactive/bank.html';
	}
}
if(empty($user)){
	if($itemdetail['fprice']==0) {
	?>
		<a href="javascript:void(0);" class="dolog dologin" name="<?=$furl?>">试听课程</a>
	<?php }elseif(empty($itemdetail['cannotpay'])){
		
	?>
		<a href="javascript:void(0);" class="toug dologin" name="<?=$furl?>">报名付费</a><?php 
	}
}elseif($user['groupid'] == 6){
	if($itemdetail['fprice']==0) {
	?>
		<a href="<?=$furl?>" class="dolog">试听课程</a>
	<?php }elseif(empty($itemdetail['cannotpay'])){
	?>
		<a href="<?=$furl?>" class="toug">报名付费</a>
	<?php }
}?>
</h1>
<p class="topjie">
<?=$itemdetail['isummary']?></p>

<h2 style="text-align:center;font-size:16px;font-weight:bold;margin:10px 0 10px 0">
<?php if(!empty($itemdetail['speaker']) && !empty($itemdetail['detail'])) 
	echo $itemdetail['speaker'];?>
</h2>
<div style="text-indent:25px;line-height:2">
<?=$itemdetail['detail']?>
</div>
<div>
<h3 class="kubiao">
课程目录
</h3>

<div class="kemul">
<?php foreach($sectionlist as $k=>$section){?>
	<h2 class="xoakr"><a href="javascript:void(0)" style="color:#0033ff;text-decoration:none" onclick="showcws('<?=$k?>')"><?=$section[0]['sname']?></a></h2>

<ul id="ul<?=$k?>">
<?php
	foreach($section as $course){
?>

<li>
<p class="tibiat"><span class="dianse">&bull;</span><?=$course['title']?></p>
<p class="etkee"><?=$course['summary']?></p>
</li>

<?php }?>
</ul>
<?php }?>
</div>


</div>
</div>
</body>
<script>
function showcws(ulid){
	if($('#ul'+ulid).css('display')=='none')
		$('#ul'+ulid).show();
	else
		$('#ul'+ulid).hide();
}
$(".dologin").click(function(){
	if ($(this).attr("name") != '') {
		$.loginDialog($(this).attr("name"));
	}else{
		$.loginDialog();
	}
});
</script>
<?php $this->display('common/footer')?>
