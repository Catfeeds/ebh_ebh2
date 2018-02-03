<?php $this->display('homev2/header'); ?>
<?php $this->display('homev2/top');?>
<div class="divcontent">
    <div class="jetke">
<?php $this->display('homev2/purse_menu');?>
        <div class="wordent">
        	<div class="tsobhs"></div>
            <div class="jskrry"></div>
            <p class="wensre">说明：</p>
            <p class="wensre">1、如信息填写不正确，导致提现失败，资金将退回至账户余额。</p>
            <p class="wensre">2、提现结果将以短信形式发送至您的手机。</p>
            <div class="kabsre">
            	<a class="lanlsbtn" href="<?=geturl('homev2/purse/cashrecords')?>">查看提现记录</a>
                <a class="huanlsbtn" href="<?=geturl('homev2/purse/index')?>">查看余额</a>
            </div>    
        </div>
    </div>
</div>
<?php $this->display('homev2/footer');?>