<?php $this->display('shop/zwx/header'); ?>

<div class="dhtop3">
<ul style="margin-left:55px;">
<li class="dhdan"><a href="/"></a></li>
<li class="dhdan"><a href="<?= geturl('introduce')?>"></a></li>
<li class="dhdan"><a href="<?= geturl('dyinformation')?>"><img src="http://static.ebanhui.com/ebh/tpl/default/images/dhdt0411.jpg" /></a></li>
<li class="dhdan"><a href="<?= geturl('platform')?>"></a></li>
<li class="dhdan"><a href="<?= geturl('contacts')?>"></a></li>
</ul>
</div>
</div>
<div style="clear:both"></div>
<div class="fonttwo">
<?php $itemid = $this->uri->itemid; ?>

<div class="rigxiang">
<!--列表页面-->
<h2 class="titzixun">全部资讯</h2>
	
<ul>
<?php if(empty($mitemlist)){?>
		<li  style="width:920px;text-align: center;border-bottom: 1px none #D1D1D1; margin-top: 40px;"><img src="http://static.ebanhui.com/ebh/citytpl/stores/images/wuzixun_03.jpg" /></li>
	<?php }else{ ?>
	<?php foreach($mitemlist as $value){?>
	<li class="auli">
	<a href="<?= geturl('dyinformation/'.$value['itemid'])?>" title="<?= $value['subject']?>"><h2 class="cfrgt"><?= $value['subject']?></h2></a>
	<p style="color:#a9b8d6;"><?= date('Y-m-d H:i:s',$value['dateline'])?></p>
	<p class="xiangjie"><?= shortstr($value['note'],350)?></p>
	<a href="<?= geturl('dyinformation/'.$value['itemid'])?>" style="color:#0991bf;">阅读全文>></a>
	<p style="color:#0991bf;margin-top:25px;">分类：默认分类 <span style="color:#999999">|</span> 阅读<span>(<?= $value['viewnum']?>)</span> <span style="color:#999999">|</span></p>
	</li>
	<?php } ?>
<?php } ?>
</ul>
</div>
</div>
<div style="text-align:center;clear:both;">
<?php
$this->display('common/footer');
?>
</div>
