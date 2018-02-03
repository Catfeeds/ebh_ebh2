<?php $this->display('shop/zho/header'); ?>
<style>
.navlie {
	width: 920px;
	clear: #555;
	height: 220px;
	float: left;
	}
	.navlie .navlietit {
	height: 42px;
	line-height: 42px;
	border-bottom: dashed 1px #e7e7e7;
	font-size: 20px;
	font-family: "Microsoft YaHei";
	font-weight: bold;
}
.martopbtm {
	margin: 10px 0;
}
.navlie img {
	float: left;
}
.navlie .tiwes {
	width: 775px;
	margin-left: 15px;
	float: left;
	font-size: 14px;
	display: inline;
	line-height: 1.8;
}
.yuedubtn {
	float: right;
	font-size: 14px;
	display: block;
	width: 60px;
	margin-right: 10px;
	height: 24px;
	line-height: 24px;
	background: url(http://static.ebanhui.com/portal/images/quanico.jpg) no-repeat left center;
	padding-left: 20px;
}
.titbgt {
background: url(http://static.ebanhui.com/ebh/citytpl/stores/images/titbg1123.jpg) no-repeat scroll 0 0 transparent;
font-size: 14px;
height: 27px;
line-height: 27px;
padding-left: 10px;
margin-left: 5px;
}
.tongbjs {
line-height: 1.6;
margin-left: 6px;
width: auto;
margin-top: 10px;
min-height: 100px;
_height: 100px;
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
<div class="fonttwo">
<?php $itemid = $this->uri->itemid; ?>

<div class="rigxiang" style="overflow:hidden;margin:0">
<!--列表页面-->
<div class="mass">
<div class="rigku">
<div class="rigtop">
</div>
<div class="rigmain">
<div class="naver">
<h2 class="titbgt" style="color: #103ba8;font-weight:bold;"><?= $room['crname']?></h2>
<p class="tongbjs" style="text-indent:32px;font-size:14px;letter-spacing: 1pt;"><?= shortstr($room['summary'],450)?></p>
<h2 class="titbgt" style="font-size:12px;font-weight:bold;color:#000;">详情介绍</h2>
<?= str_replace('\\"','"',$classroommess['message'])?>
</div>

</div>
<div class="rigbottom"></div>
</div>
</div>
<div style="text-align:center;clear:both;">

</div>
</div>
<!-- =-==== -->
</div>
</div>
<div style="text-align:center;clear:both;">
<?php
$this->display('common/footer');
?>
</div>