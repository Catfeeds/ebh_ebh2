<?php
$this->display('shop/hnm/header');
?>

<div style="clear:both"></div>
<div class="derfl" style="padding:0;margin-bottom: 20px;">
<div class="wigkhr">
<div class="fonttwo" style="margin:0;padding:0;background:none;">
<?php $itemid = $this->uri->itemid; ?>

<div class="rigxiang" style="height:786px;">	
<ul>
<?php if(empty($mitemlist)){?>
		<li  style="width:920px;text-align: center;border-bottom: 1px none #D1D1D1; margin-top: 40px;"><img src="http://static.ebanhui.com/ebh/citytpl/stores/images/wuzixun_03.jpg" /></li>
	<?php }else{ ?>
	<?php foreach($mitemlist as $value){?>
<li class="rwerm"><span class="eriwer"><a target="_blank" href="<?= geturl('dyinformation/'.$value['itemid'])?>"><?= $value['subject']?></a></span><span><?= date('Y-m-d H:i:s',$value['dateline'])?></span></li>
<?php } }?>
</ul>
</div>
</div>
</div>
</div>
<div style="text-align:center;clear:both;">
<?php
$this->display('common/footer');
?>
</div>
