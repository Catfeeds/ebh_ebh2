<?php $this->display('shop/stores/stores_header'); ?>
<?php $this->display('shop/stores/contacts_common'); ?>

<div class="rigbian">
<h2 class="htitg" style="margin-bottom: 10px;">版权说明</h2>
<?= empty($concopy[0]['message'])?'':$concopy[0]['message']?>
</div>
</div>
<div class="fltkuang"></div>
</div>
<div style="text-align:center;clear:both;">
<?php
	$this->display('common/footer');
?>
</div>