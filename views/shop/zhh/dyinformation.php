<?php $this->display('shop/zwx/header'); ?>
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
</style>
<div class="dhtop2">
<ul style="margin-left:55px;">
<li class="dhdan"><a href="/"></a></li>
<li class="dhdan"><a href="<?= geturl('introduce')?>"></a></li>
<li class="dhdan"><a href="<?= geturl('dyinformation')?>"><img src="http://static.ebanhui.com/ebh/tpl/default/images/dhdt0411.jpg" /></a></li>
<li class="dhdan"><a href="<?= geturl('contacts')?>"></a></li>
</ul>
</div>
</div>
<div style="clear:both"></div>
<div class="fonttwo">
<?php $itemid = $this->uri->itemid; ?>

<div class="rigxiang" style="overflow:hidden">
<!--列表页面-->
<h2 class="titzixun">全部资讯</h2>
<?php if(0){?>	
<ul>
<?php if(empty($mitemlist)){?>
		<li  style="width:920px;text-align: center;border-bottom: 1px none #D1D1D1; margin-top: 40px;"><img src="http://static.ebanhui.com/ebh/citytpl/stores/images/wuzixun_03.jpg" /></li>
	<?php }else{ ?>
	<?php foreach($mitemlist as $value){?>
	<li class="auli">
	<a href="<?= geturl('dyinformation/'.$value['itemid'])?>" title="<?= $value['subject']?>" target="_blank"><h2 class="cfrgt"><?= $value['subject']?></h2></a>
	<p style="color:#a9b8d6;"><?= date('Y-m-d H:i:s',$value['dateline'])?></p>
	<p class="xiangjie"><?= shortstr($value['note'],350)?></p>
	<a href="<?= geturl('dyinformation/'.$value['itemid'])?>" style="color:#0991bf;" target="_blank">阅读全文>></a>
	<p style="color:#0991bf;margin-top:25px;">分类：默认分类 <span style="color:#999999">|</span> 阅读<span>(<?= $value['viewnum']?>)</span> <span style="color:#999999">|</span></p>
	</li>
	<?php } ?>
<?php } ?>
</ul>
<?php }?>
<!-- ====== -->

<ul>
<?php if(empty($mitemlist)){?>
		<li  style="width:920px;text-align: center;border-bottom: 1px none #D1D1D1; margin-top: 40px;"><img src="http://static.ebanhui.com/ebh/citytpl/stores/images/wuzixun_03.jpg" /></li>
	<?php }else{ ?>
	<?php foreach($mitemlist as $value){?>
	<li class="navlie">
	<h2 class="navlietit"><a title="<?= $value['subject']?>" href="<?= geturl('dyinformation/'.$value['itemid'])?>" target="_blank"><?= shortstr($value['subject'],50)?></a></h2>
	<p class="martopbtm">发表于：<?= date('Y-m-d H:i:s',$value['dateline'])?>  阅读(<?= $value['viewnum']?>)次  </p>
	<a href="<?= geturl('dyinformation/'.$value['itemid'])?>" target="_blank"><img width="130px" height="98px" src="<?=empty($value['thumb'])?'http://static.ebanhui.com/portal/images/defaultpic.jpg':$value['thumb']?>" /></a>
	<p class="tiwes"><?= shortstr($value['note'],350)?></p>
	<a href="<?= geturl('dyinformation/'.$value['itemid'])?>" class="yuedubtn" target="_blank">阅读全文</a>
	</li>
	<?php } ?>
<?php } ?>
</ul>
<!-- =-==== -->
</div>
</div>
<div style="text-align:center;clear:both;">
<?php
$this->display('common/footer');
?>
</div>
