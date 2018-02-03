<?php $this->display('homev2/header'); ?>
<?php $this->display('homev2/top'); ?>
<div class="divcontent">
	<div class="conentlft">
<div class="lefrig" style="background:#fff;margin-top:10px;float:left;">
	<div class="work_menu" style="width:786px; position:relative;margin-top:0px;margin-bottom:10px;">
		<ul>
			 <li><a href="/homev2/score/routinetask.html" style="font-size:16px;"><span>常规任务</span></a></li>
			 <li><a href="/homev2/score/credit.html" style="font-size:16px;"><span>积分明细</span></a></li>
			 <li><a href="/homev2/score/record.html" style="font-size:16px;"><span>兑换记录</span></a></li>
			<li><a href="/homev2/score/description.html" style="font-size:16px;"><span>积分说明</span></a></li>
			<li class="workcurrent"><a href="/homev2/score/lottery.html" style="font-size:16px;"><span>积分兑换</span></a></li>
		</ul>
	</div>
<div class="myxuan">
		<ul>
		<!-- 幸运抽奖 -->
		<li class="mytiku">
		<a href="<?= geturl('homev2/score/lottery/lucky') ?>">
		</a>
		</li>
		<!-- 兑换礼品 -->
		<li class="comtiku">
		<a href="<?= geturl('homev2/score/lottery/exchange') ?>">
		</a>
		</li>
		</ul>
	</div>

</div>
<div style="clear:both;"></div>
</div>
<div class="cotentrgt">
<img src="http://static.ebanhui.com/ebh/tpl/2016/images/rgtimg.jpg" />
</div>
</div>
<?php $this->display('homev2/footer');?>