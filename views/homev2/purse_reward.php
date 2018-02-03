<?php $this->display('homev2/header'); ?>
<?php $this->display('homev2/top');?>
<div class="divcontent">
    <div class="jetke">
<?php $this->display('homev2/purse_menu');?>
        <h2 class="etjudt" style="margin:10px 0 0 0">奖励金额将在您的好友购买服务十五日后返现到您的账户内，可用于购买服务或提现。</h2>
        <div class="wordent">
       	  <table border="0" cellspacing="0" cellpadding="0">
              <tr class="topsbt">
                <td>奖励记录</td>
                <td>用户名</td>
                <td>网校</td>
                <td>服务名称</td>
                <td>奖励金额(元)</td>
                <td>状态</td>
              </tr>
              <?php if(empty($list)){ ?>
              <tr><td colspan="6"  style="border:none;"><div class="nodata"></div></td></tr>
              <?php }else{ ?>
              	<?php foreach ($list as $item){ ?>
              		<tr>
	              		<td><?=date('Y-m-d H:i:s',$item['time'])?></td>
	              		<td><?=$item['fromname']?></td>
	              		<td><?=$item['crname']?></td>
	              		<td><?=$item['servicestxt']?></td>
	              		<td><?=$item['reward']?></td>
	              		<td><?=$item['status'] == 1 ? '已入账': '未入账'?></td>
	              	</tr>
              	<?php } ?>
              <?php } ?>
            </table>
            <?=$pagebar?>
        </div>
        <div class="bottrig"><? if($totalreward >0){ ?>共获得奖励：<span class="etkstet">￥<?=$totalreward?></span><?php } ?></div>
    </div>
</div>
<?php $this->display('homev2/footer');?>

