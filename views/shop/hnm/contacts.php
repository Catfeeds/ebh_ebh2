<?php
$this->display('shop/hnm/header');
?>

<div style="clear:both"></div>
<div class="derfl" style="margin-bottom:20px;">
<div class="wigkhr">
<div class="zzind">
<div class="fontxian"  style="margin:0;padding:0;background:none;">
<div class="lefzong">
<div class="dizitu">

<ul>
<li class="stes"> 地址：<?= $room['craddress']?></li>
<li class="paees">电话：<?= $room['crphone']?></li>
<li class="elain">
邮箱：<a href="mailto:<?= $room['cremail']?>"><?= $room['cremail']?></a>
</li>
<?php if(!empty($room['crqq'])){?>
<li class="tsqq">
<span style="float:left;">Q  Q：</span>
<span class="qqwaik">
<a class="qqlx" target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?= $room['crqq']?>&amp;site=qq&amp;menu=yes">
<img src="http://static.ebanhui.com/ebh/tpl/default/images/qqtan1123.jpg"></a>
</span>
</li>
<?php } ?>
</ul>

</div>
</div>
<div class="lefadlo">
  <div class="xiaosa">
<img src="http://static.ebanhui.com/ebh/tpl/default/images/adlian01.jpg" />
<img src="http://static.ebanhui.com/ebh/tpl/default/images/adlian02.jpg" />
<img src="http://static.ebanhui.com/ebh/tpl/default/images/adlian03.jpg" />
</div>
<div class="fontsa">
<img src="http://static.ebanhui.com/ebh/tpl/default/images/adlian04.jpg" />
</div>
</div>
</div>
</div>
</div>
</div>
<div style="clear:both"></div>
<?php
$this->display('common/footer');
?>
