<?php $this->display('shop/mainschool/header'); ?>
<div class="dhtop">
<ul style="margin-left:55px;">
<li class="dhdan"><a href="/"></a></li>
<li class="dhdan"><a href="<?= geturl('dyinformation')?>"><img src="http://static.ebanhui.com/ebh/tpl/default/images/dhdt0411.jpg" /></a></li>
<li class="dhdan"><a href="<?= geturl('platform')?>"></a></li>
<li class="dhdan"><a href="<?= geturl('contacts')?>"></a></li>
</ul>
</div>
<div class="main">
<div class="dtzhix">

<div class="topkuang"></div>
<div class="fonttwo">
<div class="rigxiang">
	<div class="zixun">

		<div class="juxiangq" style="margin-top:0;">
		
		<h2 class="hsiz"><?= $itemview['subject']?></h2>
		<p style="color:#666;height:28px;line-height:28px;"><?= date('Y-m-d H:i:s',$itemview['dateline'])?></p>
		<p style="line-height:1.8;"><?= $itemview['message']?></p>

		</div>
	</div>
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