<?php
$ht = $this->input->get('ht');
if ($ht == 1) {
  $this->display('homev2/header1');
} else {
  $this->display('homev2/header');
}
?>
<style>
.ghjut {width:auto;}
a.mytitle {
    float: left;
    height: 24px;
    line-height: 24px;
    margin: 10px 0 0 20px;;
    padding: 0 10px;
	color:#666;
	font-size:14px;
	font-family: 微软雅黑;
}
a.fenlan {
    background: #5E96F5 none repeat scroll 0 0;
    color: #fff;
} .content-nan {
	background:url(http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png) no-repeat bottom center;
	width:16px;
	height:16px;
	float:left;
	display: block;
} .content-nv {
	background:url(http://static.ebanhui.com/ebh/tpl/troomv2/images/women.png) no-repeat bottom center;
	width:16px;
	height:16px;
	float:left;
	display: block;
}
</style>
<?php $this->display('homev2/top');?>
<div class="divcontent">
<div class="topbaad">
<div class="user-main clearfix">
<div class="lefrig" style="background:#fff;margin-top:10px;">
<?php $this->display('homev2/small_menu');?>
<a class="mytitle fenlan" style="margin-left:45px" href="/homev2/profile/msg.html" >我购买的</a>
<a class="mytitle" href="/homev2/profile/share.html" >我分享的</a>
	<div class="wordent">
		<table class="datatabsim" width="100%"  style="font-size:12px;border:none;">
			<tbody class="tabheadsim" style="line-height: 24px;">
				<tr class="topsbt">
					<td align="left" width="15%" style="padding-left: 15px">服务方式</td>
					<td align="left" width="25%">服务时间</td>
					<td align="center" width="10%">服务时长</td>
					<td align="center" width="20%">所属网校</td>
					<td align="center" width="10%">金额</td>
					<td align="center" width="20%">备注</td>
				</tr>
			</tbody>
			<?php if (!empty($payorderList)){?>
			<tbody class="tabcont">
			<?php 
				//支付来源，默认1 年卡 2 快钱 3 支付宝 4人工开通 5内部测试 6 农行支付 7银联支付 8余额支付
				$payfromName = array('1'=>'年卡','2'=>'快钱','3'=>'支付宝','4'=>'人工开通','5'=>'内部测试','6'=>'农行支付','7'=>'银联支付','8'=>'余额支付','9'=>'微信支付');
			?>
				<?php foreach($payorderList as $val){?>
				<tr>
					<td><?=array_key_exists($val['payfrom'], $payfromName)?$payfromName[$val['payfrom']]:'不明'?></td>
					<td><?=Date('Y-m-d H:i:s',$val['dateline'])?></td>
					<td><?=!empty($val['omonth'])?$val['omonth'].'个月':$val['oday'].'天'?></td>

					<td><?php if(empty($val['rname'])){echo '精品课堂';}else{echo $val['rname'];}?></td>
					<?php if($val['fee'] < 0){$val['fee'] = '+'.ltrim($val['fee'],'-');}else{$val['fee'] = '-'.$val['fee'];}?>
					<td><span class="utrwr"><?=$val['fee']?></span></td>
					<?php if($val['fee']>0){?>
					<td>开通 <?= $val['oname'] ?> 服务(退款)</td>
					<?php }else{?>
					<td>开通 <?= $val['oname'] ?> 服务</td>
					<?php }?>
				</tr>
				<?php }?>
			</tbody>
			<?php }else{?>
			<tbody class="tabnone">
				<tr>
					<!--<th colspan="6" style="padding-top:10px;text-align:center"><div class="nodata"></div></th>!-->
				</tr>
			</tbody>
		<?php }?>
		</table>
	</div>
	
	<?=$pageStr?>
	<div style="clear:both">&nbsp;</div>
</div>
</div>
</div>
<div style="clear:both;"></div>
</div>
<?php $this->display('homev2/footer');?>