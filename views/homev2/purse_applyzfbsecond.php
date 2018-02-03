<?php $this->display('homev2/header'); ?>
<?php $this->display('homev2/top');?>
<div class="divcontent">
    <div class="jetke">
<?php $this->display('homev2/purse_menu');?>
        <div class="wordent">
        	<div class="bsdtrs">
            	<span class="leftxt">提现金额：</span>
                <div class="rigtxt">
                	<span class="fonste">￥</span><span class="fonstr"><?=intval($money)?></span><span class="fonstw">.<?php $tmp = explode('.',$money);echo count($tmp) > 1 ? end($tmp) : '00';?></span> 元<a id="txdesc" href="javascript:;" class="kweers">查看提现说明</a>
                </div>
            </div>
            <div class="bsdtrs">
            	<span class="leftxt">您选择的提现方式：</span>
                <div class="rigtxt">
                    <a href="javascript:;" class="zhifub yaers"><input checked="checked" class="krerts" type="radio" name="zfradio" value="11" /><span class="rtyuds"></span></a>
                </div>
            </div>
            <div class="bsdtrs">
            	<span class="leftxt">支付宝账号：</span>
                <div class="rigtxt">
               	  <input class="lisste" name="zfbaccount" type="text" id="zfbaccount" value="" />
               	  <span id="zfbaccount_msg"></span>
                </div>
            </div>
            <div class="bsdtrs">
            	<span class="leftxt">收款人姓名：</span>
                <div class="rigtxt">
               	  <input class="lisste" name="zfbname" type="text" id="zfbname" value="" />
               	  <span id="zfbname_msg"></span>
                </div>
            </div>
            <div class="bsdtrs">
            	<span class="leftxt">输入支付密码：</span>
                <div class="rigtxt">
               	  <input class="lisste" name="zfpasswd" type="text" id="zfpasswd" value="" /><a target="_blank" href="/homev2/safety/paypass.html?type=paypass&op=forget" class="kweers">忘记密码？</a>
               	  <span id='zfpasswd_msg'></span>
                </div>
            </div>
            <div class="bsdtrs">
            	<span class="leftxt">备注：</span>
                <div class="rigtxt">
               	  <input class="lisste" name="beizhu" type="text" id="beizhu" value="" />
               	  <span id="beizhu_msg"></span>
                </div>
            </div>
            <div class="kabsre huryus">
            	<a class="lanlsbtn" href="/homev2/purse/applycash.html?zftype=<?=$zftype?>&money=<?=$money?>">返回</a>
                <a class="huanlsbtn" href="javascript:;">提现</a>
            </div> 
            <p class="wensre">说明：</p>
            <p class="wensre">1、1万元以内，每笔提现收取手续费1元。</p>
            <p class="wensre">2、超过1万，每笔提现收取手续费5元。</p>
            <p class="wensre">3、每笔提现金额不能超过5万元。</p>
            <p class="wensre">4、提交申请将于48小时内审核，具体到账时间以各银行提现时间为准。</p>
        </div>
        <div id="txmessage" class="wordent" style="display:none;text-align:left;">
            <p class="listfe">1、用户可将自己的账户余额提现。提现至支付宝或者指定银行账户。</p>
            <p class="listfe"> （1）支付宝提现：用户可将余额提现至支付宝，到账时间以支付宝转账规则为准。</p>
            <p class="listfe"> 单笔提现金额小于1万元，代收1元手续费，超过1万，每笔提现收取手续费5元。（平台不收取任何手续费，该手续费由支付宝收取）。</p>
            <p class="listfe"> （2）银行卡提现：用户可将余额提现至您的指定银行账户，到账时间以具体银行转账规则为准。</p>
            <p class="listfe"> 单笔提现金额小于1万元，代收1元手续费，超过1万，每笔提现收取手续费5元。（平台不收取任何手续费，该手续费由银行收取）。</p>
            <p class="listfe"> （3）银行卡提现，需要先绑定银行卡。</p>
            <p class="listfe"> （4）对于暂不支持提现的银行，请先提现至您本人的支付宝账号。</p>
            <p class="listfe"> （5）支付宝提现，需先对您的支付宝账号进行实名制认证。未做实名认证的支付宝账号进行提现，会导致提现不成功。</p>
            <p class="listfe"> （6）申请提现必须设置支付密码，所有提现操作需输入支付密码。</p>
            <p class="listfe">2、申请提现审核成功后，钱款将于1-7个工作日内到账，您可在提现记录中，随时关注提现进度，审核成功后也将有短信提示。如有</p>
            <p class="listfe"> 特殊情况，可能会出现提现延迟的情况，请您耐心等待。</p>
        </div>
        <!-- 提示弹窗 -->
		<div id="tserrormsg" class="khrery">
			<h2 class="kester">申请失败</h2>
		</div>
    </div>
</div>
<script language='javascript'>
function checkdata(){
	var check = true,
		zfbaccount = $.trim($('#zfbaccount').val()),
		zfbname = $.trim($('#zfbname').val()),
		zfpasswd = $.trim($('#zfpasswd').val()),
		beizhu = $.trim($('#beizhu').val());
	if(zfbaccount == ''){
		check = false;
		$('#zfbaccount_msg').removeClass('cuotic').addClass('cuotic');
		$('#zfbaccount_msg').html('支付宝账号不能为空');
	}else{
		$('#zfbaccount_msg').removeClass('cuotic');
		$('#zfbaccount_msg').html('');
	}
	if(zfbname == ''){
		check = false;
		$('#zfbname_msg').removeClass('cuotic').addClass('cuotic');
		$('#zfbname_msg').html('收款人姓名不能为空');
	}else{
		$('#zfbname_msg').removeClass('cuotic');
		$('#zfbname_msg').html('');
	}
	if(zfpasswd == ''){
		check = false;
		$('#zfpasswd_msg').removeClass('cuotic').addClass('cuotic');
		$('#zfpasswd_msg').html('支付密码不能为空');
	}else{
		$('#zfpasswd_msg').removeClass('cuotic');
		$('#zfpasswd_msg').html('');
	}
	if(beizhu.length > 18){
		check = false;
		$('#beizhu_msg').removeClass('cuotic').addClass('cuotic');
		$('#beizhu_msg').html('备注不能超过18字');
	}else{
		$('#beizhu_msg').removeClass('cuotic');
		$('#beizhu_msg').html('');
	}
	if(beizhu.length > 0){
		var reg = /^[\u4e00-\u9fa5a-z0-9\s]+$/gi;//只能输入汉字、英文字母、数字
		if(!reg.test(beizhu)){
			check = false;
			$('#beizhu_msg').removeClass('cuotic').addClass('cuotic');
			$('#beizhu_msg').html('备注不能含有特殊字符');	
		}
	}
	return check;
}
$(function(){
	var money = "<?=$money?>";//提现金额，不可更改
	$('#zfbaccount').on('blur',function(){
		var zfbaccount = $.trim($('#zfbaccount').val());
		if(zfbaccount == ''){
			$('#zfbaccount_msg').removeClass('cuotic').addClass('cuotic');
			$('#zfbaccount_msg').html('支付宝账号不能为空');
		}else{
			$('#zfbaccount_msg').removeClass('cuotic');
			$('#zfbaccount_msg').html('');
		}
	})
	$('#zfpasswd').on('focus',function(){
		$(this).attr('type','password');
	});
	$('#zfbname').on('blur',function(){
		var zfbname = $.trim($('#zfbname').val());
		if(zfbname == ''){
			$('#zfbname_msg').removeClass('cuotic').addClass('cuotic');
			$('#zfbname_msg').html('收款人姓名不能为空');
		}else{
			$('#zfbname_msg').removeClass('cuotic');
			$('#zfbname_msg').html('');
		}
	})
	$('#beizhu').on('blur',function(){
		var beizhu = $.trim($('#beizhu').val())
		if(beizhu.length > 18){
			$('#beizhu_msg').removeClass('cuotic').addClass('cuotic');
			$('#beizhu_msg').html('备注不能超过18字');
		}else{
			$('#beizhu_msg').removeClass('cuotic');
			$('#beizhu_msg').html('');
		}
		if(beizhu.length > 0){
			var reg = /^[\u4e00-\u9fa5a-z0-9\s]+$/gi;//只能输入汉字、英文字母、数字
			if(!reg.test(beizhu)){
				$('#beizhu_msg').removeClass('cuotic').addClass('cuotic');
				$('#beizhu_msg').html('备注不能含有特殊字符');	
			}
		}
	})
	//查看提现说明
	$('#txdesc').on('click',function(){
		H.create(new P({
	        title:'提现说明',
	        id:'tiptxmessage',
	        content:$('#txmessage'),
	        easy:true
	    })).exec('show');
	})
	$('.huanlsbtn').bind('click',function(){
		var bool = checkdata();
		if(bool){
			$('.huanlsbtn').unbind('click');
			doapply();
		}
	})
	function doapply(){
		var zftype = $('input[name=zfradio]:checked').val(),
		zfpasswd = $.trim($('#zfpasswd').val()),
		zfbaccount = $.trim($('#zfbaccount').val()),
		zfbname = $.trim($('#zfbname').val()),
		beizhu = $.trim($('#beizhu').val());
		//校验支付密码
		$.post('/homev2/purse/checkpaypwd.html',{'zfpasswd':zfpasswd},function(data){
			if(data.code == 0){
				$.post('/homev2/purse/doapplycash.html',{'zftype':zftype,'money':money,'recaccount':zfbaccount,'recname':zfbname,'beizhu':beizhu},function(data){
					if(data.code == 0){
						location.href = '/homev2/purse/applysuccess.html';
					}else{
						H.create(new P({
					        title:'提示信息',
					        id:'tiptserrormsg',
					        content:$('#tserrormsg'),
					        easy:true
					    })).exec('show');
					}
				},'json');
			}else{
				$('#zfpasswd_msg').removeClass('cuotic').addClass('cuotic');
				$('#zfpasswd_msg').html('支付密码错误');
				$('.huanlsbtn').unbind('click').bind('click',function(){
					var bool = checkdata();
					if(bool){
						$('.huanlsbtn').unbind('click');
						doapply();
					}
				})
			}
		},'json');
	}
})
</script>
<?php $this->display('homev2/footer');?>