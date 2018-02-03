<?php $this->display('shop/stores/stores_header'); ?>
<div class="main">
<div class="dtzhix">

<div class="topkuang"></div>
<div class="zixun">

	<!--列表页面-->
	<div class="rigxiang" style="width:920px;">

		<h2 style="width:905px;background: url('http://static.ebanhui.com/ebh/citytpl/stores/images/titbg1123.jpg') no-repeat;height: 27px;font-size: 14px;float: left;line-height: 27px;
    padding-left: 10px; margin-bottom: 20px;">全部资讯</h2>
	<ul>
	<?php if(empty($mitemlist)){?>
		<li  style="width:920px;text-align: center;border-bottom: 1px none #D1D1D1; margin-top: 40px;"><img src="http://static.ebanhui.com/ebh/citytpl/stores/images/wuzixun_03.jpg" /></li>
	<?php }else{ ?>
		<?php foreach($mitemlist as $value){ ?>
		<li class="auli">
		<a href="<?= geturl('dyinformation/'.$value['itemid'])?>" title="<?= $value['subject']?>"><h2 class="rigxiang_h2"><?= $value['subject']?></h2></a>
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
<div class="fltkuang">
</div>
</div>
</div>
<div style="text-align:center;clear:both;">
<?php
	$this->display('common/footer');
?>
</div>