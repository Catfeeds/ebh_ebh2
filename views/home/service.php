<?php
$this->display('home/page_header');
?>
<div class="topbaad">
<div class="user-main clearfix">

	<div class="ter_tit" style="position: relative;">
	当前位置 > 服务记录
	</div>
	<div class="lefrig" style="background:#fff;border:solid 1px #cdcdcd;margin-top:15px;">
<div class="user-conts" style="width: 788px;">
<div class="center" style="padding-top:0px">
<table class="datatab" width="100%" border="0" cellspacing="0" cellpadding="0" style="width:786px;border:none">
<tbody class="tabhead">
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
    <!-- <td style="color:blue;"><?=$val['ordernumber']?></td> -->
   
	<td><?=$val['crname']?></td>
    <td><?=$val['totalfee']?></td>
    <td><?php 
       //把金额前的-替换掉
       $str = $val['remark'];
	   $str =  preg_replace ('/-(\d+[.00]+)/','金额\\1' ,$str);
	    echo $str;
    ?></td>
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
</div>
<div style="clear:both;"></div>