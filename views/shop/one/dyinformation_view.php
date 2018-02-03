<?php $this->display('shop/mainschool/header'); ?>
<?php $jx = $room['domain'] == 'jx';?>
<?php if(!$jx){?>
<div class="dhtop">
<?php }else{?>
<div class="dhtop4">
<?php }?>
<ul style="margin-left:55px;">
<li class="dhdan"><a href="/"></a></li>
<li class="dhdan"><a href="<?= geturl('introduce')?>"></a></li>
<li class="dhdan"><a href="<?= geturl('dyinformation')?>"><img src="http://static.ebanhui.com/ebh/tpl/default/images/dhdt0411.jpg" /></a></li>
<li class="dhdan"><a href="<?= geturl('cloud')?>"></a></li>
<?php if(!$jx){?>
<li class="dhdan"><a href="<?= geturl('platform')?>"></a></li>
<?php }?>
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
		
		<h2 class="hsiz"><?= shortstr($itemview['subject'],50)?></h2>
		<p style="color:#666;height:28px;line-height:28px;"><?= date('Y-m-d H:i:s',$itemview['dateline'])?></p>
		<p style="line-height:1.8;"><?= stripslashes($itemview['message'])?></p>

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