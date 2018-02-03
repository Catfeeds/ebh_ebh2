<?php $this->display('shop/stores/stores_header'); ?>
<?php $this->display('shop/stores/contacts_common'); ?>

<div class="rigbian">
<h2 class="htitg" style="margin-bottom: 10px;">合作加盟</h2>
<?= empty($conjoin[0]['message'])?'':$conjoin[0]['message']?>
</div>
</div>
<div class="fltkuang"></div>
</div>
<div style="text-align:center;clear:both;">
<?php
	$this->display('common/footer');
?>
</div>