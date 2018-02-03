<?php $this->display('myroom/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/user.css" rel="stylesheet" type="text/css" />
<style>
.datatab {
	border:none;
}
.datatab td {
    border-left:none;
	border-right:none;
}
</style>
<div class="topbaad">
<div class="user-main clearfix" style="background:none;">
	<?php
	$this->assign('menuid',4);
	?>
	<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
		<div class="cright_cher" style="margin-top:0px;">
		<div class="ter_tit" style="position: relative;">
		当前位置 > 服务记录
		</div>
		<div class="lefrig" style="background:#fff;border:solid 1px #cdcdcd;margin-top:15px;float:left;width:786px;">
	<div class="user-conts">
<div class="center" style="padding:0px;">
<input type="hidden" value="member" name="action" />
<table class="datatab" width="100%" border="0" cellspacing="0" cellpadding="0" style="width:786px;border:none;">
<tbody class="tabhead">
<tr>
<th align="left" width="18%" style="text-align:center;">支付时间</th>
<th align="left" width="10%" style="text-align:center;">支付方式</th>
<th align="center" width="9%">服务时长</th>

<!-- <th align="center" width="20%">订单号/卡号</th> -->
<th align="center" width="23%" style="text-align:center;">所属网校</th>
<th align="center" width="10%">金额</th>
<th align="center" width="30%" style="text-align:center;">备注</th>
</tr>
</tbody>
<?php if (!empty($payorderList)){?>
<tbody class="tabcont">
<?php 
	//支付来源，默认1 年卡 2 快钱 3 支付宝 4人工开通 5内部测试 6 农行支付 7银联支付
	$payfromName = array('1'=>'年卡','2'=>'快钱','3'=>'支付宝','4'=>'人工开通','5'=>'内部测试','6'=>'农行支付','7'=>'银联支付');
?>
<?php foreach($payorderList as $val){?>
  <tr>
  <td><?=Date('Y-m-d H:i:s',$val['paytime'])?></td>
    <td style="text-align:center;"><?=array_key_exists($val['payfrom'], $payfromName)?$payfromName[$val['payfrom']]:'不明'?></td>
    <td><?=!empty($val['omonth'])?$val['omonth'].'个月':$val['oday'].'天'?></td>
    <!-- <td style="color:blue;"><?=$val['ordernumber']?></td> -->
   
	<td><span style="word-wrap: break-word;float: left;width: 156px;"><?=$val['crname']?></span></td>
    <td><?=$val['totalfee']?></td>
    <td><span style="word-wrap: break-word;float: left;width: 208px;"><?=$val['remark']?></span></td>
  </tr>
<?php }?>
</tbody>
<?php }else{?>
<tbody class="tabnone">
	<tr>
		<th colspan="6">暂无任何信息</th>
	</tr>
</tbody>
<?php }?>
</table>
<div style="clear:both">&nbsp;</div>
</div>
<?=$pageStr?>
</div>
</div>
</div>
<div style="clear:both;"></div>