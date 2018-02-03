<?php $this->display('home/page_header');?>
<div class="topbaad">
<div class="user-main clearfix">
	<?php
	$this->assign('menuid',0);
	?>
	<div class="ter_tit">
	当前位置 > 个人信息 > 服务记录
	</div>
	<div class="lefrig" style="background:#fff;<?=(empty($room['iscollege'])||$user['groupid']!=6)?'border:solid 1px #cdcdcd;':''?>margin-top:15px; display: inline-block;padding-bottom:0;">
	
	<?php
	$this->assign('type','setting');
	$this->display('home/simplate_menu');
	?>
<style>
.tabheadsim th{
	border-top:none;	
}

.datatabsim td {
    border: none;
}
</style>
<!--  -->
<table class="datatabsim" width="100%"  style="font-size:12px;border:none;">
<tbody class="tabheadsim" style="line-height: 24px;">
<tr>
<th align="left" width="15%" style="padding-left: 15px">服务方式</th>
<th align="left" width="25%">服务时间</th>
<th align="center" width="10%">服务时长</th>
<!-- <th align="center" width="20%">订单号/卡号</th> -->
<th align="center" width="20%">所属网校</th>
<th align="center" width="10%">金额</th>
<th align="center" width="20%">备注</th>
</tr>
</tbody>
<?php if (!empty($payorderList)){?>
<tbody class="tabcont">
<?php 
	//支付来源，默认1 年卡 2 快钱 3 支付宝 4人工开通 5内部测试 6 农行支付 7银联支付 8余额支付
	$payfromName = array('1'=>'年卡','2'=>'快钱','3'=>'支付宝','4'=>'人工开通','5'=>'内部测试','6'=>'农行支付','7'=>'银联支付','8'=>'余额支付');
?>
<?php foreach($payorderList as $val){?>
  <tr>
    <td><?=array_key_exists($val['payfrom'], $payfromName)?$payfromName[$val['payfrom']]:'不明'?></td>
    <td><?=Date('Y-m-d H:i:s',$val['paytime'])?></td>
    <td><?=!empty($val['omonth'])?$val['omonth'].'个月':$val['oday'].'天'?></td>
   
	<td><?=$val['rname']?></td>
    <td><?=$val['fee']?></td>
    <td>开通 <?= $val['oname'] ?> 服务</td>
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
<?=$pageStr?>
</div>
</div>
</div>
<div style="clear:both;"></div>