<?php $this->display('homev2/header'); ?>
<?php $this->display('homev2/top'); ?>
<div class="divcontent">
<div class="conentlft">
<div class="topbaad">
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/jfxt.css" rel="stylesheet" type="text/css" />
<div class="rule">
<div class="lefrig" style="background:#fff;margin-top:10px;float:left;">
	<div class="work_menu" style="width:786px; position:relative;margin-top:0px;margin-bottom:10px;">
		<ul>
			 <li><a href="/homev2/score/routinetask.html" style="font-size:16px;"><span>常规任务</span></a></li>
			 <li><a href="/homev2/score/credit.html" style="font-size:16px;"><span>积分明细</span></a></li>
			 <li class="workcurrent"><a href="/homev2/score/record.html" style="font-size:16px;"><span>兑换记录</span></a></li>
			<li><a href="/homev2/score/description.html" style="font-size:16px;"><span>积分说明</span></a></li>
			<!-- <li><a href="/homev2/score/lottery.html" style="font-size:16px;"><span>积分兑换</span></a></li> -->
		</ul>
	</div>
<table width="100%" border="0" cellpadding="0" class="datatabs" style="margin-top:10px;">
<tbody class="tabhead">
  <tr>
					<th align="left" colspan = "2" width="30%">来源/用途</th>
					<th align="left" width="9%">数量</th>
					<th align="center" width="9%">支出</th>
					<th align="center" width="15%">日期</th>
					<th align="center" width="20%">备注</th>
					</tr>
</tbody>
</table>

<?php
if(!empty($orderlist)){
foreach($orderlist as $ol){
?>
<table width="100%" border="0" cellpadding="0" class="datamis" style="border-left:none;border-right:none;">
  <tr>
    <td width="13%"><img width="85px;" heigth="55px;" src="<?= $ol['image']?>" /></td>
	<td width="22%" style="text-align:left;"><p>积分兑换</p><p class="yanse"><?=$ol['productname']?></p></td>
    <td width="12%">1</td>
    <td width="10%">-<?=$ol['credit']?></td>
    <td width="18%" align="center"><?=Date('Y-m-d H:i:s',$ol['dateline'])?></td>
	<?php if($ol['type']==1){?>
    	<td width="30%"><p>积分兑换</p><p><?php if($ol['status']==1){?>兑换成功<?php }?></p></td>
	<?php }else{?>
    	<td width="30%"><p>积分兑换</p><p><?php if($ol['status']==1){?>正在发货中...<?php }elseif($ol['status']==2){?><p>已发货<?=$ol['expressname']?></p> 订单号<?=$ol['expressNo']?><?php }elseif($ol['status']==3){?>已完成<?php }?></p></td>
	<?php }?>
  </tr>
</table>
<?php
}}else{
?>
<span class="nodata" style="display:block;">
</span>
<?php
}?>
<?=show_page($ordercount)?>
</div>
</div>
<div style="clear:both;"></div>
</div>
</div>
<div class="cotentrgt">
<img src="http://static.ebanhui.com/ebh/tpl/2016/images/rgtimg.jpg" />
</div>
</div>
<script type="text/javascript">
$(function(){
		$('.datamis tr:last td').css('border-bottom','none');
	});
</script>
<?php $this->display('homev2/footer');?>