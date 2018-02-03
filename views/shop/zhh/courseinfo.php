<?php $this->display('shop/zwx/header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" />
<style type="text/css">
.lvjies a.toug {
	background:#ea732f;
	color:#fff;
	cursor: pointer;
	display: block;
	float: right;
	height: 28px;
	line-height: 28px;
	text-align: center;
	text-decoration: none;
	width: 100px;
	font-size:14px;
	border:solid 1px #d6682a;
	margin-top:10px;
}
.lvjies a.dolog {
	background:#18a8f7;
	color:#fff;
	cursor: pointer;
	display: block;
	float: right;
	height: 28px;
	line-height: 28px;
	text-align: center;
	text-decoration: none;
	width: 100px;
	font-size:14px;
	border:solid 1px #0d9be9;
	margin-top:10px;
}
</style>

<body>
<div class="dhtop2">
<ul style="margin-left:55px;">
<li class="dhdan"><a href="/"><img src="http://static.ebanhui.com/ebh/tpl/default/images/dhind0411.jpg" /></a></li>
<li class="dhdan"><a href="<?= geturl('introduce')?>"></a></li>
<li class="dhdan"><a href="<?= geturl('dyinformation')?>"></a></li>
<li class="dhdan"><a href="<?= geturl('contacts')?>"></a></li>
</ul>
</div>
<div class="lvjies" style="background:white">
<h1>
<?=$folder['foldername']?>


</h1>
<?php if(!empty($folder['summary'])){?>
<p class="topjie">
<?=$folder['summary']?>
</p>
<?php }?>
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
