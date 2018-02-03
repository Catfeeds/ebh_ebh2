<?php $this->display('myroom/page_header'); ?>
<div class="topbaad">
<?php
$this->assign('menuid',3);
?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/jfxt.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<div class="rule">
		<div class="ter_tit" style="position: relative;">
		当前位置 > 我的积分 > 兑换记录
		</div>
		<div class="lefrig" style="background:#fff;border:solid 1px #cdcdcd;margin-top:15px;float:left;">
<?php
$this->assign('type','score');
$this->display('member/simplate_menu');
?>
<table width="100%" border="0" cellpadding="0" class="datatabs" style="margin-top:10px;">
<tbody class="tabhead">
  <tr>
					<th align="left" width="35%" style="padding-left: 15px;border-bottom: 1px solid #CDCDCD;border-top: 1px solid #CDCDCD;">来源/用途</th>
					<th align="left" width="10%"  style="border-bottom: 1px solid #CDCDCD;border-top: 1px solid #CDCDCD;">数量</th>
					<th align="center" width="15%"  style="border-bottom: 1px solid #CDCDCD;border-top: 1px solid #CDCDCD;">支出</th>
					<th align="center" width="25%"  style="border-bottom: 1px solid #CDCDCD;border-top: 1px solid #CDCDCD;">日期</th>
					<th align="center" width="15%"  style="border-bottom: 1px solid #CDCDCD;border-top: 1px solid #CDCDCD;">备注</th>
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
	<td width="22%" style="text-align:left;"><p>积分兑换</p><p class="yanse"><a target="_blank" href="<?=geturl('lottery/exchange/'.$ol['pid'])?>"><?=$ol['productname']?></a></p></td>
    <td width="10%">1</td>
    <td width="10%">-<?=$ol['credit']?></td>
    <td width="15%"><?=Date('Y-m-d H:i:s',$ol['dateline'])?></td>
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
<span style="margin-left:10px;">
		暂无任何信息
</span>
<?php
}?>
<?=show_page($ordercount)?>
</div>
</div>
<div style="clear:both;"></div>