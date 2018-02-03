<?php 
	$uri = $this->uri;
	$controller = $uri->uri_control();
	$action = $uri->uri_method();
//var_dump($controller);
//var_dump($action);
?>

<div class="work_menu" style="width:1000px; position:relative;margin-top:0px;">
	<ul>
		 <li class="<?=(($controller=='purse')&&(($action=='index')||($action=='applycash')||($action=='applybanksecond')||($action=='applysuccess')||($action=='applyzfbsecond')))?"workcurrent":""?>"><a href="/homev2/purse/index.html" style="font-size:16px;"><span>账户余额</span></a></li>
		 <li  class="<?=(($controller=='purse')&&(($action=='bank')||($action=='bindbank')))?"workcurrent":""?>"><a href="/homev2/purse/bank.html" style="font-size:16px;"><span>我的银行卡</span></a></li>
		 <li class="<?=(($controller=='purse')&&($action=='reward'))?"workcurrent":""?>"><a href="/homev2/purse/reward.html" style="font-size:16px;"><span>奖励记录</span></a></li>
		 <li class="<?=(($controller=='purse')&&($action=='charge'))?"workcurrent":""?>"><a href="/homev2/purse/charge.html" style="font-size:16px;"><span>收益记录</span></a></li>
		 <li class="<?=(($controller=='purse')&&($action=='payment'))?"workcurrent":""?>"><a href="/homev2/purse/payment.html" style="font-size:16px;"><span>支付记录</span></a></li>
		 <li class="<?=(($controller=='purse')&&($action=='cashrecords'))?"workcurrent":""?>"><a href="/homev2/purse/cashrecords.html" style="font-size:16px;"><span>提现记录</span></a></li>
		 <li class="<?=(($controller=='purse')&&($action=='gratuity' || $action == 'gratuitydetail'))?"workcurrent":""?>"><a href="/homev2/purse/gratuity.html" style="font-size:16px;"><span>赞赏记录</span></a></li>
	</ul>
</div>