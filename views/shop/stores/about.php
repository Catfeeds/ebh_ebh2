<?php $this->display('shop/stores/stores_header'); ?>
<?php $this->display('shop/stores/contacts_common'); ?>

<div class="rigbian">
<h2 class="htitg" style="margin-bottom: 10px;">关于我们</h2>
<?= empty($conabout[0]['message'])?'':$conabout[0]['message']?>
</div>
</div>
<div class="fltkuang"></div>
</div>
<div style="text-align:center;clear:both;">
<?php
	$this->display('common/footer');
?>
</div>