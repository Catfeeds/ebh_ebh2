<?php $hideebhinfo = false;
if(!empty($itemlist[0]['domain']) && $itemlist[0]['domain'] == 'jx'){
	$hideebhinfo = true;
	$this->assign('title','开通【'.$itemlist[0]['crname'].'】服务');
}
$this->assign('hideebhinfo',$hideebhinfo);
$othersetting = Ebh::app()->getConfig()->load('othersetting');
$favourable = true;
if (!empty($othersetting['dis_favourable'])) {
	$dis_favourable = $othersetting['dis_favourable'];
	unset($othersetting);
	if (is_array($dis_favourable) && !empty($roominfo) && in_array($roominfo['crid'], $dis_favourable)) {
		$favourable = false;
	}

}


?>
<?php $this->display('common/site_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/cloudlist.css" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/open.css?version=20160223001" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/minded.css<?=getv()?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<style>
.main .slst .fmiat {
	width:902px;
	font-family:微软雅黑;
}
.main .slst .fmiat .fash {
	height: auto;
}
.main .slst .fmiat p {
	line-height: 1.8;
    padding-left: 78px;
	padding-top:0px;
}
.main .slst .fmiat .fash li {
    float: left;
	font-size:16px;
	cursor: pointer;
	width:100px;
	text-align:center;
	font-family:"Microsoft YaHe";
}
.main .slst .fmiat .fash li input {
	width:20px;
	height:20px;
}
.main .slst .fmiat .fash .alipays {
	background: url(http://static.ebanhui.com/ebh/images/alipay.jpg?v=20160218) no-repeat center top;
	padding-top: 42px;
}
.main .slst .fmiat .fash .nongyes {
	background: url(http://static.ebanhui.com/ebh/images/abcicon.jpg?v=20160218) no-repeat;
	padding-top: 42px;
	width:127px;
}
.main .slst .fmiat .fash .yinlians {
	background: url(http://static.ebanhui.com/ebh/images/online.jpg?v=20160218) no-repeat;
	padding-top: 42px;
	width:115px;
}
.main .slst .fmiat .fash .bank {
	background: url(http://static.ebanhui.com/ebh/images/bank141219.jpg?v=20160218) no-repeat top center;
	width:112px;
}
.main .slst .fmiat .fash .weizhi {
	background: url(http://static.ebanhui.com/ebh/images/weizhit.jpg?v=20160218) no-repeat top center;
	padding-top: 42px;
	width:120px;
}
.main .slst .fmiat .fash .bank a {
	padding:47px 0 0 22px;
	float:left;
}
.etktds {
	padding-bottom:10px;
	margin-top:20px;
}
.etktds a.wertsw,.etktds a.swertsw {
	float:left;
	margin-left:30px;
	height:30px;
	line-height:30px;
	width:127px;
	background:#18a8f7;
	border:solid 1px #0d9be9;
	color:#fff;
	font-size:20px;
	font-weight:bold;
	text-align: center;
}
.curtr td{
	background-color: #fffdee!important;
}
a.zhutk {
	color:#299de6;margin-bottom:5px;float:left;
}
a.zhutk:hover {
	text-decoration: underline;
}
.disatr{
	background:#CCC;
}
.disachecktip{
	background:white;position:absolute;display:none;border:1px solid;width:100px;text-align:center;z-index:100
}
.benast {
	background:url(http://static.ebanhui.com/ebh/images/benast.jpg) no-repeat center left;
	height:19px;
	padding-left:25px;
	margin-left:10px;
	float:left;
	display:inline-block;
}
.nonst {
	background:url(http://static.ebanhui.com/ebh/images/nonst.jpg) no-repeat center left;
	height:19px;
	padding-left:25px;
	margin-left:10px;
	float:left;
	display:inline-block;
	
}
.tabll td{border:1px solid #f3f3f3;}
.textput{border:1px solid #999; height:30px; width:232px; line-height:28px;padding-left:10px; color:#bfbfbf;}
.surebtn{background: url(http://static.ebanhui.com/ebh/tpl/2016/images/querekt.jpg?version=20160311002) no-repeat center; width:90px; height:
28px; line-height:27px; cursor:pointer;text-align: center;color: #fff;font-family: Microsoft Yahei; margin-top:1px; font-size:14px;}
.surebtn:hover{background: url(http://static.ebanhui.com/ebh/tpl/2016/images/querekthover.jpg) no-repeat center; }
.main .slst .fmiat .anniu, .surebtn1 {background: url(http://static.ebanhui.com/ebh/tpl/2016/images/surekt.png) no-repeat center; width:156px; height:30px; line-height:30px; cursor:pointer;text-align: center;color: #fff;font-family: Microsoft Yahei; margin-top:1px; font-size:14px; margin-left:375px;}
li.yezf{ width:auto !important; margin-left:0 ; }
.nonsts{font-family:"Microsoft Yahei"; color:#333 !important; font-size:22px;}
.yezf b{ font-weight:normal; color:#848484; font-size:14px; line-height:40px;}
.ye{text-align:right; font-size:16px; color:#626262;font-family:Microsoft Yahei;}
a.hdjhk{ color:#00aaf0 !important; font-size:12px; }
div.cgyz{padding-left:10px;color:#fd2c16; font-family:Microsoft Yahei;}

/* 弹窗样式 */
.waigme {
	width:550px;
	height:290px;
	background-color:gray;
	border-radius:10px;
	display:none;
}
.nelame {
	width:530px;
	height:270px;
	margin:10px;
	float:left;
	display:inline;
	border: 8px solid rgba(255, 255, 255, 0.2);
	border-radius: 8px;
	box-shadow: 0 0 20px #333333;
	opacity: 1;
}
.nelame .leficos {
	width:125px;
	height:265px;
	float:left;
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/kaitongico0105.jpg) no-repeat 30px 32px;
}
.nelame .rigsize {
	width:375px;
	float:left;
	margin-top:25px;
}
.rigsize .tishitit {
	font-size:14px;
	color:#d31124;
	font-weight:bold;
	line-height:30px;
}
.rigsize .phuilin {
	line-height:2;
	color:#6f6f6f;
}
.nelame a.kaitongbtn {
	display:block;
	width:147px;
	height:50px;
	line-height:50px;
	background-color:#ff9c00;
	color:#fff;
	text-decoration:none;
	text-align:center;
	font-size:20px;
	float:left;
	font-family:"微软雅黑";
	font-weight:bold;
	margin-top:20px;
	border-radius:5px;
}
.nelame a.guanbibtn {
	float:left;
	color:#939393;
	font-size:14px;
	margin:40px 0 0 12px;
}
.main .aed{
	background:url(http://static.ebanhui.com/ebh/tpl/2016/images/titlebg.png);
	width:936px;
}
.main .aed p{
	padding-top:6px;
}
.main .slst .fmiat .studentview{
	text-align:center;
	margin-top:30px;
	margin-bottom:10px;
}
.main .slst .fmiat .studentview img{
	width:50px;
	height:50px;
	border-radius:25px;
	padding-left:0;
}
.main .slst .fmiat .studentview span{
	font-size:16px;
	color:#333;
	font-weight:bold;
	padding-left:10px;
}
td.titter{
	background:#28A8FA;
}
</style>
<div style="background:url(http://static.ebanhui.com/ebh/tpl/2012/images/bg12511.jpg); height:auto;">
<div style="width:960px;margin:0 auto;">
<div class="main" style="float:left;height:auto;padding-bottom:40px;width:940px;">
<div class="aed"><p>欢迎开通【<?= $roominfo['crname'] ?>】服务</p></div>
  <div class="slst" style="height:auto;">
	<div class="fmiat" style="height:auto;background:#fff;">
		<!--微信二维码支付弹出层!-->
		<div id="chekse" class="chekse" style="display:none;">
			<div><img id="weixinewm" class="ektrde" src="http://static.ebanhui.com/ebh/images/loading.gif" /></div>
			<div><span class="retyoe">微信扫一扫，完成支付</span></div>
		</div>
 <div class="studentview">
	<img src="<?=getavater($user,'50_50')?>">
	<span><?= $user['username'].(!empty($user['realname'])?'('.$user['realname'].')':'') ?></span>
 </div>
<p style="padding-left: 19px;font-weight: bold;color: #666;padding-bottom: 10px;font-size:16px;">开通服务：</p>
<form id="kqPay" target="_blank" name="kqPay" method="post" action="">
<input type="hidden" name="allowlist" value="<?php 
if (isset($appsetting['5ajhm'][$roominfo['crid']])) {
	echo in_array($sid, $appsetting['5ajhm'][$roominfo['crid']]) ? 1 : 0;
} else {
	echo 0;
}
?>" />
<div class="tabll">
<table cellspacing="0" border="1" width="100%">
<tr style="background-color: #28A8FA;color: #fff;font-weight: bold;border: solid 1px #28A8FA;">
<td class="titter">服务名称</td>
<td class="titter">原价</td>	
<td class="titter">售价</td>
<td class="titter">数量</td>
<td class="titter">折后总金额</td>
</tr>
<tr>
	<td width="20%"><?=$detail['name']?></td>
	<td width="20%"><s>￥<?=$detail['fprice']?>元</s></td>
	<td width="20%">￥<?=$detail['price']?>元</td>
	<td width="20%">×<?=$detail['number']?></td>
	<td width="20%">￥<?=$detail['price']*$detail['number']?>元</td>
</tr>
<input type="hidden" name="redeem" value="<?=empty($detail['lotid'])?0:$detail['lotid']?>">
<tr>
	<td id="switch0" style="text-align:right;font-weight:bold;" colspan="5">
		合计： <span style="font-size:24px;font-family:Microsoft Yahei;font-weight:normal;"></span>
		<span style="color:#ff2b2b;font-size:24px;" class="beforediscount">¥<?=$detail['fprice']*$detail['number']?>元</span>
		<span style="font-size:24px;font-family:Microsoft Yahei;font-weight:normal;"></span>
		&nbsp;&nbsp;
		折后价： <span style="font-size:24px;font-family:Microsoft Yahei;font-weight:normal;"></span>
		<span style="color:#ff2b2b;font-size:24px;" id="allprice">¥<?=$detail['price']*$detail['number']?>元</span>
		<span style="font-size:24px;font-family:Microsoft Yahei;font-weight:normal;"></span>
	</td>
	
</tr>
</table>
</div>

<input type="hidden" name="totalfee" id="totalfee" value="<?=$detail['price']*$detail['number']?>" />
<input type="hidden" name="totalyhfee" id="totalyhfee" value="" />
<input type="hidden" name="cardnumber" id="cardnumber" value="cardnumber" />
<!-- 优惠码start -->
<input type="hidden" id="isusecoupon" name="isusecoupon" value=0>
<input type="hidden" id="couponverify" name="couponverify" value=0>
<input type="hidden" id="couponcode" name="couponcode">
	<!-- 分类类型不显示优惠码 -->
</form>
<div style="clear:both"></div>
<p style="padding-top:20px; float:left; display:inline;padding-left: 19px;font-weight: bold;color: #666;font-size:16px;">支付方式：</p>
<div style="clear:both"></div>
<div class="fash" style="float:left; display:inline;">
 <ul id="paywayitem">
 <li class="alipays">
   <a href="javascript:;" class="benast">支付宝</a>
   <input id="alipay" name="payway" type="hidden" value="radiobutton" checked="checked"/>
 </li>
 <li class="weizhi">
   <a href="javascript:;" class="nonst">微信支付</a>
   <input id="weizhi" name="payway" type="hidden" value="radiobutton" />
 </li>
 <li class="nongyes">
   <a href="javascript:;" class="nonst">农行直通车</a>
   <input id="abcpay" name="payway" type="hidden" value="radiobutton" />
 </li>
 <li class="yinlians">
   <a href="javascript:;" class="nonst" style="margin-left:25px;">银联</a>
   <input id="abcallpay" name="payway" type="hidden" value="radiobutton" />
 </li>
 <!--<li class="bank" style="margin:-5px 0 0;">
 <a target="_blank" style="color:#d93800;">银行转账</a>
 </li>-->
 <li class="yezf mt35">
 	<a href="javascript:;" class="nonst" style="margin-left:10px;font-family:Microsoft Yahei;color:#333;font-size:22px;height:30px; line-height:28px;">余额支付（<span style="font-size:24px;">¥</span><span id="mytxtbalance" style="color: #ff2b4e; font-size:24px; font-family:宋体; font-weight:bold;"><?=$user['balance']?></span><span style="font-size:24px;">元</span>）</a>
	<input id="yepay" name="payway" type="hidden" value="radiobutton" />
	<!--<b id="balancemsg" style="display:none">账户余额不足，请<a class="chongzhi" href="javascript:;" target="_blank" style="color: #18a8f7; font-weight:bold;">充值</a></b>-->
 </li>
  <!--激活卡开通(目前只有点化网校+武汉分校支持激活卡开通方式)-->
 <?php if(!empty($roominfo) && (($roominfo['crid'] == 10631) || (isset($appsetting['5ajhm'][$roominfo['crid']]) && in_array($sid, $appsetting['5ajhm'][$roominfo['crid']])) || ($roominfo['crid'] == 10515) || ($roominfo['crid'] == 12434 ))) { ?>
 <li class="jhkkt mt30" style="width:590px;">
		<a href="javascript:;" class="nonst" style="margin-left:10px;font-family:Microsoft Yahei;color:#333;font-size:22px;height:30px; line-height:28px;">
			<span class="span1s" >激活卡开通：</span>
			<input id="cardpay" name="payway" type="hidden" value="radiobutton" />
			<input id="cardnum" type="text" class="textput" value="请输入激活码" style="color:#bfbfbf;width:370px;height:30px;border:none;border-bottom:solid 1px #cdcdcd"/>
		</a>
 </li>
 <?php } ?>
 </ul>
 </div>
 <div style="clear:both;"></div>

<div class="payhelp mt30">
<p style="font-size:14px;">支付帮助：</p>
<p style="font-size:14px;">1.如果您没有开通支付宝或网上银行，可以选择“银联”进行支付，支持各大银行的借记卡，无需开通网银有卡就能支付，并支持大额付款。</p>
<p style="font-size:14px;">2.如有问题咨询，请拨打客服热线：
<?php if(!$hideebhinfo){?>0571-88252183  88252153 13757168928
<?php }else{?>
0573-82090988 83959988 15505731188 15605737778
<?php }?>
</p>
</div>
<input type="hidden" id="sumprice" value="<?=$allprice?>" /> 
 <div id="kuaiqianmsg" style="font-size:14px;margin-top:10px;display:none;">
 <img src="http://static.ebanhui.com/ebh/tpl/2012/images/xiantiao1.jpg" />
 <p style="padding-top:5px;"> 尊敬的客户：</p>
 <p>您的开通请求已经提交,请您继续在支付网站上完成相关操作步骤。</p>
 <p>支付成功后，您可以用账号<span style="color:#075d80;">&nbsp;<?= $user['username'] ?>&nbsp;</span>登录 。&nbsp;<a style="color:#A11714;" href="<?= 'http://'.$_SERVER['HTTP_HOST'] ?>">[立即登录]</a></p>
 <p style="color:#a11512;">若支付网页没有自动弹出，请点击<a style="color:#0c630e;" href="javascript:void(0);" onclick="$('#activeBtn').click()"> 这里 </a>进入支付页面，继续完成网上支付。谢谢！</p>
 </div>
 <div class="czxy" style="padding-top:10px;padding-left:0px;text-align:center;">
	<input name="agreement" id="agreement" type="checkbox" value="1" checked="checked" />
	<label for="agreement" style="font-weight:bold;">我已阅读并同意《<a href="<?= geturl('agreement/payment') ?>" target="_blank" style="color:#00AEE7;">用户支付协议</a>》
	</label>
 </div>
 <input id="activeBtn" style="cursor:pointer; margin-top:20px;" class="anniu" type="button" name="button" value="确认开通" />
	</div>
	</div>
  </div>
 </div>
  <div class="footlintbg">
<img width="970" height="16" src="http://static.ebanhui.com/ebh/tpl/2016/images/shadow.png">
</div>
</div>
<div style="clear:both;"></div>
<!-- 弹窗start -->
<div class="nelame" style="display:none;">
	<div style="width:530px;height:270px;background:#fff;">
		<div class="leficos"></div>
		<div class="rigsize">
		<h2 class="tishitit">很抱歉，银行转账属于线下支付，无法享受优惠价，继续支付需要支付金额</h2>
		<p class="phuilin">您可以选择使用其他支付方式支付即可继续享受优惠价购买。</p>
		<p style="font-weight:bold; color:red">实际价格 <span id="nelnamemoneytxt" style="font-size:24px"><?=$allprice?></span> 元。</p>
		</div>
		<a href="/classactive/bank.html" target="_blank" class="kaitongbtn">继续支付</a>
		<a href="javascript:;" class="guanbibtn">选择其他支付方式</a>
	</div>
</div>
<!-- 弹窗end -->
<script type="text/javascript">

$(function(){	
	$.ajax({
		type:"get",
		url:"/room/collect/checkstar.html",
		async:true,
		dataType:'json',
		success:function(json){
			var datas = json;
			if(json.code){
				if(!datas.data['switch']){
					//$("#switch0").show();
					//$("#switch1").hide();
					$("#mt25").show();
				}else{
					//$("#switch0").hide();
					//$("#switch1").show();
					$("#mt25").hide();
					$("#mt25").hide();
				}
			}else{
				//console.log("接口错误");	
			}
		},
		error:function(){
			
		}
	});
	
	
	//关闭弹窗
	$('.guanbibtn').on('click',function(){
		$('.nelame').hide();
		$('.logDialog').remove();
	})
	//统一绑定支付方式点击
	$('#paywayitem li[class=bank]').on('click',function(){
		//判断下是否使用了优惠码
		var isusecoupon = $('#isusecoupon').val();
		if(isusecoupon == 1){
			showDivModel(".nelame");
		}else{
			window.open('/classactive/bank.html');
		}
	})
	$('#paywayitem li').not('.bank').on('click',function(e){
		$('#balancemsg').hide();
		$('#paywayitem li').not('.bank').find('a:first').removeClass('benast').addClass('nonst');
		$(this).find('a:first').removeClass('nonst').addClass('benast');
		$('#paywayitem input').prop('checked',false);
		$(this).find('input').prop('checked','checked');
		//如果是余额支付，判断下余额是否充足
		if($(this).is('.yezf')){
			var srcElement = e.srcElement || e.target;
			var totalfee = $('#totalfee').val(),
				totalyhfee = $('#totalyhfee').val(),
				isusecoupon = $('#isusecoupon').val(),
				couponverify = $('#couponverify').val(),
				totalmoney = 0;
			totalmoney = (isusecoupon == 1 && couponverify == 1) ? totalyhfee : totalfee;
			if(parseFloat($.trim($('#mytxtbalance').html())) < parseFloat(totalmoney)){
				$('#balancemsg').show();
			}else{
				$('#balancemsg').hide();
			}
			if($(srcElement).is('.chongzhi')){
				window.open('http://pay.ebh.net');
			}
			return false;
		}
	})
	$(".chkitem").click(function(){
		var result = checkitemrow($(this).val(),$(this).prop("checked"));
		if(!result) {
			$(this).prop("checked",true);
		}
	});
	//激活卡相关操作
	$('#cardnum').on('focus',function(){
		if($.trim($(this).val()) == '请输入激活码'){
			$(this).css({'color':'#000'});
			$(this).val('');
		}
	})
	$('#cardnum').on('blur',function(){
		if($.trim($(this).val()) == ''){
			$(this).css({'color':'#bfbfbf'});
			$(this).val('请输入激活码');
		}
	})
	//优惠码操作
	$('#mycouponcode').on('focus',function(){
		if($.trim($(this).val()) == '请输入优惠码'){
			$('.textput').css({'color':'#000'})
			$(this).val('');
		}
	})
	$('#mycouponcode').on('blur',function(){
		if($.trim($(this).val()) == ''){
			$('.textput').css({'color':'#bfbfbf'})
			$(this).val('请输入优惠码');
		}
	})
	$('#myusecoupon').on('click',function(){
		var check = $(this).is(':checked');
		if(check){
			//显示优惠码输入框
			$('#couponblock').show();
			$('#couponmsg').show();
			$('#isusecoupon').val(1);
		}else{
			//隐藏优惠码输入框
			$('#couponblock').hide();
			$('#couponmsg').hide();
			$('#isusecoupon').val(0);
		}
	})
	$('#usecoupontxt').on('click',function(){
		$('#myusecoupon').trigger('click');
	})
	//优惠码验证
	$("#verifycodebtn").on('click',function(){
		var code = $.trim($('#mycouponcode').val());
		var len = $('.chkitem:checked').length;
		if(len == 0){
			$('#verifycodemsg').html('您还没有选择任何课程，请选择后重试');
			$('#couponmsg').html('');
			return;
		}
		$.post('/tbuy/verifycoupon.html',{code:code},function(data){
			if(data.code < 0){
				$('#couponverify').val(0);
				$('#totalyhfee').val($('#totalfee').val());
				$('#verifycodemsg').html(data.msg);
				$('#couponmsg').html('');
				$('#couponcode').val('');
			}else{
				var yhsum = chargeyhsum();
				$('#couponverify').val(1);
				$('#totalyhfee').val(yhsum);
				var yh = parseFloat($('#totalfee').val()) - yhsum;
				//修复提示语
				if(yh >0){
					$('#verifycodemsg').html('验证成功，您已成功优惠：'+yh+'元');
					$('#couponmsg').html('优惠后：<span style="font-size:24px;font-family:Microsoft Yahei;font-weight:normal;">¥</span><span style="color:#ff2b2b;font-size:24px;">'+yhsum+'</span><span style="font-size:24px;font-family:Microsoft Yahei;font-weight:normal;">元</span>');
				}else{
					$('#verifycodemsg').html('验证成功，但你选择的课程没有优惠');
					$('#couponmsg').html('');
				}
				$('#couponcode').val(code);
			}
		},'json')
	})
	//支付操作
	$("#activeBtn").click(function(){
		if($("#agreement").prop("checked") !=true) {
			alert("请先阅读并同意《e板会用户支付协议》。");
			return;
		}
		//校验支付金额
		if(parseFloat($("#totalfee").val())<=0 && parseFloat($("#totalyhfee").val())<=0){
			alert("您没有可支付的服务选项");
			return;
		}
		//默认支付宝支付
		var payway = 'alipay'
		$('#paywayitem input').each(function(){
			if($(this).prop("checked")==true){
				payway = $(this).attr('id');
				return false;
			}
		})
		if(payway == 'yepay'){
			//余额支付
			var isusecoupon = $("#myusecoupon").is(':checked');
			couponverify = $("#couponverify").val(),
			totalfee = isusecoupon && couponverify == 1 ? $("#totalyhfee").val() : $("#totalfee").val();
			$.confirm("支付确认","系统将从您的账户中扣除金额 " + totalfee +" 元", function(r) {
				$.ajax({
					url:"/tbuy/bpay.html",
					type	:'POST',
					dataType:'json',
					data	:$("#kqPay").serialize(),
					success	:function(json){
						if(json != null && json != undefined && json.status == 1) {
	                         $.showmessage({
	                            img : 'success',
	                            message:'开通成功，请等待客服审核',
	                            title:'开通服务',
	                            callback :function(){
	                            	window.close()
	                                 //document.location.href = "/tbuy/success.html";
	                            }
	                        });
	                    } else {
							var msg = '开通失败，请稍后再试或联系客服';
							if(json != null && json != undefined && json.msg != undefined && json.msg != "")
								msg = json.msg;
	                        $.showmessage({
	                            img : 'error',
	                            message:msg,
	                            title:'开通服务'
	                        });
	                    }
					}
				});
			});
		}else if(payway == 'alipay'){
			//支付宝支付
			$("#kuaiqianmsg").show();
			$(".payhelp").hide();
			$("#kqPay").attr("action","/tbuy/alipay.html");
			$("#kqPay").submit();
		}else if(payway == 'weizhi'){
			//微信支付
			doweixinpay();
		}else if(payway == 'abcpay'){
			//农行直通车
			$("#kuaiqianmsg").show();
			$(".payhelp").hide();
			$("#kqPay").attr("action","/tbuy/abcpay.html");
			$("#kqPay").submit();
		}else if(payway == 'abcallpay'){
			//中国银联
			$("#kuaiqianmsg").show();
			$(".payhelp").hide();
			$("#kqPay").attr("action","/tbuy/abcallpay.html");
			$("#kqPay").submit();
		}else if(payway == 'cardpay'){
			$("#kuaiqianmsg").show();
			$(".payhelp").hide();

		$("#cardnumber").val($.trim($("#cardnum").val()));
		var cardnumber = $("#cardnumber").val();
		if(cardnumber ==  "请输入激活码"){
			alert("请输入激活码!");
			return;
		}
		if($("#kqPay input:checked").length != 1 && $("#ditemid").length != 1 && !isYatou){
			alert("激活卡开通单次仅能开通一门课程!");
			return;
		}
		$.confirm("开通确认","开通成功后该激活卡将失效", function(r) {
			$.ajax({
				url:"/tbuy/scardpay.html",
				type	:'POST',
				dataType:'json',
				data	:$("#kqPay").serialize(),
				success	:function(json){
					if(json != null && json != undefined && json.status == 1) {
                         $.showmessage({
                            img : 'success',
                            message:'开通成功，请等待客服审核',
                            title:'开通服务',
                            callback :function(){
                            	window.close()
                                 //document.location.href = "/tbuy/success.html";
                            }
                        });
                    } else {
						var msg = '开通失败，请稍后再试或联系客服';
						if(json != null && json != undefined && json.msg != undefined && json.msg != "")
							msg = json.msg;
                        $.showmessage({
                            img : 'error',
                            message:msg,
                            title:'开通服务'
                        });
                    }
				}
			});
		});

		}
	});
	xForm.hit($("#cardnum"));

	//微信支付逻辑
	var hasdoweixinreq = 0;
	var timer = {};
	function doweixinpay(){
		showwxpay();
		$.ajax({
			url:"/tbuy/wxnativepay.html",
			type	:'POST',
			dataType:'json',
			data	:$("#kqPay").serialize(),
			success	:function(res){
				if(res.status != 0){
					alert("请求失败，请稍后重试");
					location.reload();
					return;
				}
				var id = 'weixinpay_'+res.cachekey;
				var data_package = {
					cachekey:res.cachekey,
					callback:function(recallback){
						H.get('wxpaydialog').exec('close');
						recallback&&recallback();
					},
					count:0,
					t:{},
					successurl:res.successurl
				}
				$("#weixinewm").attr('src',res.url).css('width', '246px').css('height', '246px');

				hasdoweixinreq = 1;
				checkweixinbuy(data_package);
			}
		});
	}

	function checkweixinbuy(data_package){
		if(data_package.count >= 60){
			location.reload();
		}
		timer.t = data_package.t;
		$.ajax({
		   url: "<?=geturl('tbuy/checkweixinbuy')?>",
		   type:'post',
		   dataType:'json',
		   data: {cachekey:data_package.cachekey},
		   success: function(res){
		   		if(res.status == 0){
		   			data_package && data_package.callback(function(){
		   					clearTimeout(data_package.t);
		   					location.href = data_package.successurl;
		   				}
		   			);
		   		}else{
		   			data_package.t=setTimeout(function(){
		   				checkweixinbuy(data_package);
		   			},5000);
		   		}
		   		data_package.count++;
		   }
		 });
	}

	function cancelweixinpay(){
		H.get('wxpaydialog') && H.get('wxpaydialog').exec('close');
	}

	$("#alipay,#abcallpay,#abcpay,#yepay").click(function(){
		if($(this).prop('checked')){
			cancelweixinpay();
		}
	});
	//微信支付逻辑结束
});

function showwxpay(){
	H.create(new P({
		title:'微信支付',
		content:$("#chekse")[0],
		width:300,
		height:300,
		easy:true,
		id:'wxpaydialog'
	},{
		onclose:function(){
			window.location.reload(true);
		}
	})).exec('show');
}
</script>
<?php $this->display('common/site_footer'); ?>