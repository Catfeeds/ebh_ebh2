<?php $this->display('homev2/header'); ?>
<?php $this->display('homev2/top');?>
<div class="divcontent">
    <div class="jetke">
<?php $this->display('homev2/purse_menu');?>
        <div class="wordent">
        	<div class="bsdtrs">
            	<span class="leftxt">您可提现金额：</span>
                <div class="rigtxt">
                	<span class="fonste">￥</span><span class="fonstr"><?=intval($user['balance'])?></span><span class="fonstw">.<?php $tmp = explode('.',$user['balance']);echo count($tmp) > 1 ? end($tmp) : '00';?></span> 元
                </div>
            </div>
            <div class="bsdtrs">
            	<span class="leftxt">提现金额：</span>
                <div class="rigtxt">
               	  <input class="lisste" name="txmoney" type="text" id="txmoney" value="" />
               	  <span id="txmoney_msg"></span>
                </div>
            </div>
            <div class="bsdtrs">
            	<span class="leftxt">选择提现方式：</span>
                <div class="rigtxt">
                	<?php if(empty($mybank)){ ?>
                		<span class="reltrs">您还未绑定银行卡，请先绑定</span><a href="<?=geturl('homev2/purse/bindbank')?>" class="lanlsbtn">绑定银行卡</a>
                	<?php }else{ ?>       
                		<?php foreach ($mybank as $my){ ?>
                		<a href="javascript:;" class="<?=$bank[$my['bindex']]['tclass'].' yaers'?>"><input class="krerts" type="radio" name="zfradio" value="<?=$my['bindex']?>" /><span class="rtyuds"><?=substr($my['account'],-4,4)?></span></a>
                		<?php } ?>
                    <?php } ?>
                    <a href="javascript:;" class="zhifub yaers"><input class="krerts" type="radio" name="zfradio" value="11" /><span class="rtyuds"></span></a>
                </div>
          	</div>
            <p class="wensre">说明：</p>
            <p class="wensre">1、1万元以内，每笔提现收取手续费1元。</p>
            <p class="wensre">2、超过1万，每笔提现收取手续费5元。</p>
            <p class="wensre">3、每笔提现金额不能超过5万元。</p>
            <p class="wensre">4、提交申请将于48小时内审核，具体到账时间以各银行提现时间为准。</p>
            <div class="kabsre">
                <a class="huanlsbtn" href="javascript:;">确定</a>
            </div>
        </div>
    </div>
</div>
<script language='javascript'>
$(function(){
	var mybalance = "<?=$user['balance']?>";//可提现余额
	function checkmoney(){
		var check = true;
		var money = $.trim($('#txmoney').val());
		var reg = /^\d+(\.\d{0,2})?$/;
		var ret = reg.test(money);
		if(!ret){
			check = false;
			$('#txmoney_msg').removeClass('cuotic').addClass('cuotic');
			$('#txmoney_msg').html('金额格式不对');
		}else{
			$('#txmoney_msg').removeClass('cuotic');
			$('#txmoney_msg').html('');
		}
		if(parseFloat(money)<=0){
			check = false;
			$('#txmoney_msg').removeClass('cuotic').addClass('cuotic');
			$('#txmoney_msg').html('提现金额不能小于或等于0');
			return check;
		}
		if(parseFloat(money)>50000){
			check = false;
			$('#txmoney_msg').removeClass('cuotic').addClass('cuotic');
			$('#txmoney_msg').html('单笔提现金额不能超过5万元');
			return check;
		}
		if(parseFloat(money) > parseFloat(mybalance)){
			check = false;
			$('#txmoney_msg').removeClass('cuotic').addClass('cuotic');
			$('#txmoney_msg').html('提现金额不能大于可提现金额');
		}else{
			//计算手续费
			var hfee = parseFloat(money) >= 10000 ? 5 : 1;
			if(parseFloat(money) + hfee > parseFloat(mybalance)){
				check = false;
				$('#txmoney_msg').removeClass('cuotic').addClass('cuotic');
				$('#txmoney_msg').html('您的可提现余额必须预留'+hfee+'元手续费');
			}
		}
		return check;
	}
	$('#txmoney').on('blur',function(){
		checkmoney();
	});
	$('.yaers').on('click',function(){
		$('.yaers input').removeAttr('checked');
		$(this).find('input').get(0).checked = true;
	})
	$('.huanlsbtn').on('click',function(){
		var check = checkmoney();
		var zftype =  $('input[name=zfradio]:checked').val();
		var money = $.trim($('#txmoney').val());
		if(typeof zftype == 'undefined'){
			dialog({
	        skin:"ui-dialog2-tip",
	        width:350,
	        content: "<div class='PPic'></div><p>请选择提现方式</p>",	
			onshow:function () {
				var that=this;
				setTimeout(function () {
					that.close().remove();
				},2000);
			}
			}).showModal();
			return false;	
		}
		if(check){
			location.href = '/homev2/purse/second.html?zftype='+zftype+'&money='+money;	
		}
	})
})
</script>
<?php $this->display('homev2/footer');?>