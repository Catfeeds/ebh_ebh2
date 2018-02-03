<?php $this->display('homev2/header'); ?>
<?php $this->display('homev2/top');?>
<div class="divcontent">
    <div class="jetke">
<?php $this->display('homev2/purse_menu');?>
        <div class="wordent">
          <?php if(!empty($list)){?>
       	  <table border="0" cellspacing="0" cellpadding="0">
              <tr class="topsbt">
                <td>处理时间</td>
                <td>提现类型</td>
                <td>提现金额(元)</td>
                <td>当前余额(元)</td>
                <td>处理状态</td>
                <td>备注</td>
              </tr>
              <?php foreach ($list as $item){?>   
              <tr>
                <td><?=date("Y-m-d H:i:s",$item['dateline'])?></td>
                <td><?=$item['applytype'] == 0 ? '转账到银行卡' : '转账到支付宝账号'?></td>
                <td><?=$item['value']?></td>
                <td><?=$item['curvalue']?></td>
                <td><?php if($item['status'] == 0){ echo '处理中';} else if($item['status'] == 1){ echo '处理成功';} else {echo '处理失败';} ?></td>
                <td><?=$item['desc']?></td>
              </tr>
              <?php }?>
          </table>
		  <?php }else{?>
		  <table border="0" cellspacing="0" cellpadding="0">
              <tr  colspan="4" style="border:none;">
                <td style="border:none;"><div class="nodata"></div></td>
              </tr>
            </table>
            <?php }?>
           <?=$pagebar?>
        </div>
    </div>
</div>
<?php $this->display('homev2/footer');?>