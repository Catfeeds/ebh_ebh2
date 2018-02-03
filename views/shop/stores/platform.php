<?php $this->display('shop/stores/stores_header'); ?>
<?php $this->display('shop/stores/storesleft'); ?>
<div class="rigku">
<div class="rigtop">
</div>
<div class="rigmain">
<div class="naver">
<h2 class="titbgt" style="color: #103ba8;font-weight:bold;"><?= $room['crname']?></h2>
<p class="tongbjs"><?= shortstr($room['summary'],450)?></p>
<h2 class="titbgt" style="font-size:12px;font-weight:bold;color:#000;">详情介绍</h2>
<?= str_replace('\\"','"',$classroommess['message'])?>
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