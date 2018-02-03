<?php $this->display('home/page_header'); ?>
<style>
.myxuan .mytiku{
	background:url('http://static.ebanhui.com/ebh/tpl/2014/images/lottery_lucky.jpg') no-repeat center #fff;
}
.myxuan .comtiku{
	background:url('http://static.ebanhui.com/ebh/tpl/2014/images/lottery_exchange.jpg') no-repeat center #fff;
}
</style>
<div class="ter_tit">
 当前位置 > 积分计划  > 积分兑换 
</div>
<div class="lefrig" style="background:#fff;margin-top:15px;float:left;">
<?php
$this->assign('type','score');
$this->display('home/simplate_menu');
?>
<div class="myxuan">
		<ul>
		<!-- 幸运抽奖 -->
		<li class="mytiku">
		<a href="<?= geturl('home/score/lottery/lucky') ?>">
		</a>
		</li>
		<!-- 兑换礼品 -->
		<li class="comtiku">
		<a href="<?= geturl('home/score/lottery/exchange') ?>">
		</a>
		</li>
		
		</ul>
	</div>

</div>
<div style="clear:both;"></div>
