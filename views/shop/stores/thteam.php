<?php $this->display('shop/stores/stores_header'); ?>
<?php $this->display('shop/stores/storesleft'); ?>
<div class="rigku">
<div class="rigtop">
</div>
<div class="rigmain">
<div class="naver">
<h2 class="titbgt">全部讲师</h2>
<ul class="list1" style="width:708px;float:left;">

<?php if(!empty($teamlist)){ ?>
<?php foreach($teamlist as $value){ ?>
<li><a class="img-shadow" href="#"><img width="94" height="134" src="<?= getThumb($value['thumb'],'94_134','')?>"></a>
<div class="rigsize">
<h2><?= shortstr($value['subject'],26,'')?></h2>
<p title="<?= $value['note']?>"><?= shortstr($value['note'],110)?></p>
</div>
</li>
<?php } ?>
<?php }else{ ?>
<li  style="width:680px;text-align: center;border-bottom: 1px none #D1D1D1; margin-top: 60px;"><img 
src="http://static.ebanhui.com/ebh/citytpl/stores/images/wujiangshi_03.jpg" /></li>
<?php } ?>
</ul>


</div>
</div>
<div class="rigbottom"></div>
</div>
</div>
<div style="text-align:center;clear:both;">
<?php
	$this->display('common/footer');
?>
</div>